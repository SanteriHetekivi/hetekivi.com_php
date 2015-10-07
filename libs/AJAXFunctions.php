<?php	


	function AJAX_searchManga($_mangaPage, $_user, $_included, $_excluded, $_minChapters=FALSE, $_maxChapters=FALSE)
	{
		$objResponse = new xajaxResponse();
		$mMangaSearch = new MangaSearch($_mangaPage, $_included, $_excluded, $_user);
		$mMangaSearch->SEARCH();
		$result = $mMangaSearch->getSearchResult();
		$google = "https://www.google.fi/search?q=myanimelist+manga+";
		$mal = "http://myanimelist.net/manga.php?q=";
		$html = "<table>
				<tr>
					<th>Image</th>
					<th>Title</th>
					<th>Google</th>
					<th>Manga</th>";
		$html .=(isset($result[0]["chapters"]))?"<th>Chapters</th></tr>":"</tr>";
		foreach($result as $id => $manga)
		{
			$parametres = json_encode(array($_user,$_mangaPage));
			$html .= "<tr>
					<td id='image$id'><button onclick=\"xajax_getMangaImage('".$manga["link"]."','".$_mangaPage."', 'image$id');\">Get Image</button></td>
					<td><a href='" . $manga["link"] . "'>" . $manga["title"] ."</a></td>
					<td><a href='" . $google.$manga["searchTitle"]. "'>Google</a></td>
					<td><a href='" . $mal.$manga["searchTitle"]. "'>MyAnimelist</a></td>";
			$html .=(isset($manga["chapters"]))?"<td>".$manga["chapters"]."</td></tr>":"</tr>";
		}
		$html .= "</table>";
		$objResponse->assign("searchResults", "innerHTML", $html);
		
		return $objResponse;

		
	}
	
	function getMangaImage($_link,$_mangaPage, $_div)
	{
		$objResponse = new xajaxResponse();
		$image = "<img style='width:150px;height:200px;' src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/600px-No_image_available.svg.png'>";
		if($_mangaPage=="Batoto") $query = "//img[starts-with(@src,'http://img.bato.to/forums/uploads/7')]";
		elseif($_mangaPage=="MangaFox")$query ="//img[starts-with(@src,'http://a.mfcdn.net/store/manga')]";
		else
		{
			
		}			
		libxml_use_internal_errors(true);
		$mangaPage = new DOMDocument();
		$mangaPage->loadHTMLFile($_link);
		$xpath = new DOMXPath($mangaPage);
		$image = $xpath->query($query);
		$imageUrl = $image->item(0)->getAttribute('src');
		$image = "<img style='width:150px;height:200px;' src='$imageUrl'>";
		
		$objResponse->assign($_div, "innerHTML", $image);
		return $objResponse;
	}
	function getGiftList($userid)
	{
		$objResponse = new xajaxResponse();
		
		$gifts = SQL_getUsersGifts($userid, TRUE);
		$edit = checkLogin();
		
		
		$smarty = startSMARTY();
		$smarty->assign("edit", $edit);
		
		$smarty->assign("gifts", $gifts);
		
		$html = $smarty->fetch("giftList_table.tpl");
		
		$objResponse->assign("giftListTable", "innerHTML", $html);

		return $objResponse;
	}
	function AJAX_getValue($table,$column,$id)
	{
		echo SQL_SELECT_VALUE_ID($_table=$table, $_column=$column, $_id=$id);
	}
	function setGiftUserDoesNotHave($giftid)
	{
		$objResponse = new xajaxResponse();
		
		$gift = SQL_SELECT_ID("gifts", $giftid);
		foreach($gift as $column => $value)
		{
			$objResponse->assign($column, 'value', $value);
		}
		if(isset($gift["image"]))$objResponse->assign("prevImg", "src", $gift["image"]);
		return $objResponse;
	}

	function getMALTable($userid, $manga_or_anime, $MALUser = FALSE, $page = 1)
	{
		$objResponse = new xajaxResponse();
		
		$entries = SQL_getUsersMALEEntries($userid, $manga_or_anime, $MALUser, $page);

		$parts = ($manga_or_anime === "anime")?"episodes":"chapters";
		
		$smarty = startSMARTY();
		
		$smarty->assign("entries", $entries);
		$smarty->assign("parts", $parts);
		$smarty->assign("page", $page);
		$smarty->assign("userid", $userid);
		$smarty->assign("manga_or_anime", $manga_or_anime);
		$smarty->assign("MALUser", $MALUser);

		$html = $smarty->fetch("mal_table.tpl");
		
		$objResponse->assign("mal_table", "innerHTML", $html);

		return $objResponse;
	}

	$xajax->register(XAJAX_FUNCTION,'getGiftList');
	$xajax->register(XAJAX_FUNCTION,'setGiftUserDoesNotHave');
	$xajax->register(XAJAX_FUNCTION,'getMALTable');
	
	$xajax->configure('debug', true);
	$xajax->processRequest();
	

?>
