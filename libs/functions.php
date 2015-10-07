<?php	
	
	function toMysqlDateTime($_dateTime){ return date("Y-m-d H:i:s", $_dateTime); }
	
	function clean($_string) 
	{
		// Replace non-AllLet characters with space
		$_string = preg_replace("/[^A-Za-z]/", ' ', $_string);
		// Replace Multiple spaces with single space
		$_string = preg_replace('/ +/', ' ', $_string);
		// Trim the string of leading/trailing space
		return strtolower(trim($_string));
	}
	
	function passwordHash($_password)
	{
		//return password_hash(SALT2.$_password.SALT1, PASSWORD_DEFAULT);
		return sha1(SALT2.$_password.SALT1);
	}
	
	function checkPassword($_password,$_hashedPassword)
	{
		//return password_verify(SALT2.$_password.SALT1 , $_hashedPassword);
		//die((sha1(SALT2.$_password.SALT1) === $_hashedPassword));
		return (sha1(SALT2.$_password.SALT1) === $_hashedPassword);
	}
	
	function navigate($_url, $_outside=false)
	{
		if($_outside)header("Location:".$_url);
		else header("Location:index.php?page=".$_url);			
		exit(0);
	}
	
	
	function search_manga($_mangaPage, $_user, $_included, $_excluded)
	{
		$result = array();
		$titles = SQL_getMangaTitles($_user,true);	
		$page=1;
		$id = 0;
		$samePage = FALSE;
		$first = "";
		$genres = makeGenres($_mangaPage, $_included, $_excluded);	
		if($_mangaPage=="Batoto")
		{
			$query = "//a[starts-with(@href,'http://bato.to/comic/_/')]";
			$searchLink = "http://bato.to/comic/_/";
			$imageClass = "width:300px; float:right; text-align:center; padding:10px;";
			$url = "http://bato.to/search?" . $genres . "completed=c&p=";
		}
		elseif($_mangaPage=="MangaFox")
		{
			$query = "//a[@class='series_preview manga_close']";
			$searchLink = "http://mangafox.me/manga/";
			$imageClass = "cover";
			$url = "http://mangafox.me/search.php?". $genres . "is_completed=1&advopts=1&sort=rating&order=za&page=";
		}
		else return FALSE;
		do
		{
			libxml_use_internal_errors(true);
			$resultPage = new DOMDocument();
			$resultPage->loadHTMLFile($url.$page);
			$xpath = new DOMXPath($resultPage);
			$linkClasses = $xpath->query($query);
			if(is_object($linkClasses))
			{
				if($first != $linkClasses->item(0)->nodeValue) 
				{
					$first = $linkClasses->item(0)->nodeValue;
					foreach($linkClasses as $linkClass)
					{
						$new = TRUE;
						$title = $linkClass->nodeValue;
						$searchTitle = strtolower(clean($title));
						foreach($titles as $tmpTitle)
						{
							if(stripos(clean(strtolower($tmpTitle)) , $searchTitle) !== false)
							{
								$new = FALSE;
								break;
							}
						}
						if($new)
						{
							$result[$id]["title"] = $title;
							$result[$id]["link"]= $linkClass->getAttribute('href');
							$result[$id]["searchTitle"]= urlencode($searchTitle);
							++$id;
						}
					}
				}else $samePage = TRUE;
			}
			++$page;
		}while(is_object($linkClasses) && $samePage === FALSE);
		return $result;
	}
	
	function makeGenres($_mangaPage, $_included, $_excluded)
	{
		$genres = "";
		if(!empty($_included) || !empty($_excluded))
		{
			if($_mangaPage=="Batoto")
			{
				$genres = "genres=;";
				if(is_array($_included))foreach($_included as $include) $genres .= "i".$include.";";
				if(is_array($_excluded))foreach($_excluded as $exlude) $genres .= "e".$exlude.";";
				$genres = rtrim($genres, ";") . "&genre_cond=and&";
			}
			elseif($_mangaPage=="MangaFox")
			{
				$allGenres = array("Action", "Adult", "Adventure", "Comedy", "Doujinshi", "Drama", "Ecchi", "Fantasy", "Gender+Bender", "Harem", "Historical", 
					"Horror", "Josei", "Martial+Arts", "Mature", "Mecha", "Mystery", "One+Shot", "Psychological", "Romance", "School+Life", "Sci-fi", "Seinen", 
					"Shoujo", "Shoujo+Ai", "Shounen", "Shounen+Ai", "Slice+of+Life", "Smut", "Sports", "Supernatural", "Tragedy", "Webtoons", "Yaoi", "Yuri");
				foreach($allGenres as $genre)
				{
					if(is_array($_excluded) && in_array($genre, $_included)) $genres .= "genres%5B$genre%5D=1&";
					elseif(is_array($_excluded) && in_array($genre, $_excluded)) $genres .= "genres%5B$genre%5D=2&";
					else $genres .= "genres%5B$genre%5D=0&";
				}
			}
		}
		return $genres;
	}
	
	function startsWith($_string, $_value) 
	{
		// search backwards starting from _string length characters from the end
		return $needle === "" || strrpos($_string, $_value, -strlen($_string)) !== FALSE;
	}
	
	function endsWith($_string, $_value)
	{
		// search forward starting from end minus _value length characters
		return $needle === "" || (($temp = strlen($_string) - strlen($_value)) >= 0 && strpos($_string, $_value, $temp) !== FALSE);
	}
	
	function getGiftListTable($_userid,$_edit=false)
	{
		$gitfs = SQL_getUsersGifts($_userid);
		$html = "<table>
				<tr>
					<th>#</th>
					<th>Image</th>
					<th>Title</th>
					<th>Type</th>
					<th>Price</th>
				</tr>";
		$html .= $_edit?"<tr><td td align='center' bgcolor='green' colspan='7'><button style='width:100%' onclick='editGiftList(0)'>ADD</button></td></tr>":"";
		if(is_array($gitfs))
		{
			foreach($gitfs as $gift)
			{
				
				$id = $gift->getValue("id");
				$delete = "
					<form action='' method='post'>
						<input type='hidden' value='giftList' name='action'>
						<input type='hidden' value='$id' name='id'>
						<input type='submit' name='Delete' value='DELETE'>
					</form>";
				$html .= "<tr>
							<td id=giftPosition$id>".$gift->getValue("position")."</td>
							<td><img id=giftImage$id style='width:100px;height:150px;' src='".$gift->getValue("image")."'></td>
							<td><a id=giftTitle$id href='".$gift->getValue("url")."'>".$gift->getValue("title")."</a></td>
							<td>".$gift->getTypeTitle()."<input id=giftType$id type='hidden' value='".$gift->getValue("gifts_types_id")."'/></td>
							<td id=giftPrice$id>".number_format($gift->getValue("price"),2,',',' ')."&euro;</td>";
				$html .= $_edit?"<td><button type='button' onclick='editGiftList($id)'>EDIT</button><BR>$delete</td></tr>":"</tr>";
			}
		}
		$html .= "</table>";
		return $html;
	}
	
	function in_array_case_insensitive($needle, $haystack) 
	{
		return in_array( strtolower($needle), array_map('strtolower', $haystack) );
	}
	
	function getUser() { return $_SESSION["session"]->user; }
	
	function getUserID() 
	{ 
		$user = getUser();
		return ($user)?$user->getID():FALSE;
	}
	
	function euro($_value = false){ return (is_numeric($_value))?number_format($_value,2,',',' '):FALSE; }
	
	function checkLogin()
	{
		$session=&$_SESSION["session"];
		if(is_object($session)) return $session->checkLogin();
		else return false;
	}
	
	function IDstoObject($ids, $object)
	{
		if($ids && $object && is_array($ids))
		{
			$objects = array();
			foreach($ids as $id)
			{
				$objects[$id] = getObjectByName($object, $id);
				if(!$objects[$id]) return FALSE;
			}
		}else return FALSE;
		return $objects;
	}
	
	function stringContains($word, $string){ return (stripos($string, $word) !== FALSE); }
	
?>
