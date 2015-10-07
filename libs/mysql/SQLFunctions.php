<?php	
	
	function SQL_loadMyanimelistXMLToDataspace()
	{
		$file = simplexml_load_file(TMP_XML_FILE_PATH);
		$user = $file->children()[0]->user_name;
		$alreadyIn = SQL_getMangaTitles(false,$user);
		if(isset($user))
		{
			foreach($file->children() as $series) 
			{ 
				$manga = array();
				$manga["title"] = (string)$series->series_title;
				if(isset($manga["title"]) && !empty($manga["title"]))
				{
					$manga["mal_id"] = (string)$series->series_mangadb_id;
					$manga["id"] = SQL_GET_ID("mangas", "mal_id = '".$manga["mal_id"]."'");
					$manga["status"] = (string)$series->series_status;
					$manga["chapters"] = (string)$series->series_chapters;
					$manga["image"] = (string)$series->series_image;
					
					$synonyms = explode("; ", $series->series_synonyms);
					$altTitles = array();
					foreach($synonyms as $synonym)$altTitles[] = clean($synonym);
					$altTitles = array_filter($altTitles);
					
					$userLink["manga_anime_user"] = (string)$user;
					$userLink["manga_anime_status"] = (int)$series->my_status;
					$userLink["manga_anime_score"] = (int)$series->my_score;
					$userLink["manga_anime_parts"] = (int)$series->my_read_chapters;
					$userLink["manga_anime_last_updated"] = toMysqlDateTime((int)$series->my_last_updated);
					$mManga = new Manga($manga);
					if(!empty($altTitles)) $mManga->setAltTitles($altTitles);
					foreach($userLink as $column => $value) $mManga->setLinkedValue($column,$value);
					$mManga->COMMIT();
				}
			}
		}return FALSE;
		
		return TRUE;
	}
	
	function SQL_getMangaTitles($_userID = FALSE, $_manga_anime_user = FALSE, $_alsoAltTitles = FALSE, $_allowed_status = FALSE)
	{	
		$where = "mangas_id > 0 ";
		if($_userID) $where .= "users_id='".$_userID."' ";
		if($_manga_anime_user) $where .= "manga_anime_user='".$_manga_anime_user."' ";
		if($_allowed_status && is_array($_allowed_status)) $where .= "AND manga_anime_status IN ('".implode("','", $_allowed_status)."') ";
		$titles = SQL_SELECT_COLUMN("mangas", "title", "id IN (SELECT mangas_id FROM users_links WHERE ".$where." ) ");
		if(is_array($titles))
		{
			$ids = SQL_SELECT_COLUMN("users_links", "mangas_id", $where);
			if($_alsoAltTitles) $titles = $titles + SQL_SELECT_COLUMN("mangas_animes_altTitles", "title", "mangas_animes_id IN (" . implode(",",$ids) . ") AND manga_or_anime='manga'");
			return array_filter(array_unique($titles));
		}else return array();
	}
	
	function SQL_getMyanimelistUsers()
	{
		return SQL_SELECT_DISTINCT("mangas", "user");
	}
	
	function SQL_getUsersGifts($userid, $onlyMothers = FALSE)
	{
		$mother = ($onlyMothers)?" AND gift_mother_id='0'":"";
		$gifts = ($userid)?SQL_SELECT_OBJECTS($_table="gifts", $_where="id IN (SELECT gifts_id FROM users_links WHERE gifts_id > 0 AND users_id = '".$userid."'".$mother.") "):FALSE;
		if($gifts && is_array($gifts))
		{
			function cmp($a, $b) 
			{
				if ($a->getPosition() == $b->getPosition())return 0;
				return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
			}
			uasort($gifts, 'cmp');
		}
		return $gifts;
	}
	
	function SQL_getGiftsUserDoesNotHaveTitles($userid)
	{
		$gifts = ($userid)?SQL_SELECT_COLUMN($_table="gifts", $_column="title", $_where="id NOT IN (SELECT gifts_id FROM users_links WHERE gifts_id > 0 AND users_id = '".$userid."') "):Array();
		return $gifts;
	}
	
	function SQL_getGiftPositions($userid)
	{
		$positions = array();
		$giftPositions = SQL_SELECT_COLUMN($_table="users_links", $_column="gift_position", $where="users_id='".$userid."' AND gifts_id>0");
		if(is_array($giftPositions) && !empty($giftPositions))
		{
			foreach($giftPositions as $position)$positions[$position]= $position;
			$positions[max($positions) + 1] = max($positions) + 1;
		}else $positions[1] = 1;
		asort($positions);
		return $positions;
	}
	
	function SQL_getUsersMALEntries($userid, $manga_or_anime, $MALUser, $pageNo=false)
	{
		$manga_anime_user = ($MALUser)?" AND manga_anime_user='".$MALUser."' ":"";
		$table = ($manga_or_anime === "anime")?"animes":"mangas";
		$offset = ($pageNo)?($pageNo-1)*10:0;
		$mangas_ids = SQL_SELECT_COLUMN("users_links", $table."_id", 
			"users_id='".$userid."'".$manga_anime_user."ORDER BY manga_anime_last_updated DESC LIMIT 10 OFFSET ".$offset);
		$elements = IDstoObject($mangas_ids, $manga_or_anime);
		if($elements && is_array($elements))
		{
			function cmp($a, $b) 
			{
				if ($a->getLinkedValue("manga_anime_last_updated") == $b->getLinkedValue("manga_anime_last_updated"))return 0;
				return ($a->getLinkedValue("manga_anime_last_updated") > $b->getLinkedValue("manga_anime_last_updated")) ? -1 : 1;
			}
			uasort($elements, 'cmp');
		}
		return $elements;
	}
	
	function SQL_getGiftsUserDoesNotHave($ids)
	{
		return SQL_SELECT(FALSE, "gifts", false, false, "id IN ('".implode("','", $ids)."')");
	}
	
?>
