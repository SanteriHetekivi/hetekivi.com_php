<?php
	$page = "mangaSearch";
	$session=&$_SESSION["session"];	
	require(STANDARD_SMARTY);
	if($session->checkLogin())
	{
		$users = SQL_getMyanimelistUsers();
		$searchOn = false;
		$genres = array();
		$mangaPages = array("MangaFox","Batoto");
		$included = array();
		$exluded = array();
		$myAnimelistUser = "";
		$result = "";
		if(isset($_GET["mangaPage"]))
		{
			$genres["Baka-Updates"] = array("Action"=>"Action","Adult"=>"Adult","Adventure"=>"Adventure","Comedy"=>"Comedy","Doujinshi"=>"Doujinshi",
					"Drama"=>"Drama","Ecchi"=>"Ecchi","Fantasy"=>"Fantasy","Gender Bender"=>"Gender+Bender","Harem"=>"Harem",
					"Hentai"=>"Hentai","Historical"=>"Historical","Horror"=>"Horror","Josei"=>"Josei","Lolicon"=>"Lolicon","Martial Arts"=>"Martial+Arts",
					"Mature"=>"Mature","Mecha"=>"Mecha","Mystery"=>"Mystery","Psychological"=>"Psychological","Romance"=>"Romance","School Life"=>"School+Life",
					"Sci-fi"=>"Sci-fi","Seinen"=>"Seinen","Shotacon"=>"Shotacon","Shoujo"=>"Shoujo","Shoujo Ai"=>"Shoujo+Ai","Shounen"=>"Shounen","Shounen Ai"=>"Shounen+Ai",
					"Slice of Life"=>"Slice+of+Life","Smut"=>"Smut","Sports"=>"Sports","Supernatural"=>"Supernatural","Tragedy"=>"Tragedy","Yaoi"=>"Yaoi","Yuri"=>"Yuri");
			$genres["MangaFox"] = array("Action"=>"Action", "Adult"=>"Adult", "Adventure"=>"Adventure", "Comedy"=>"Comedy", "Doujinshi"=>"Doujinshi", "Drama"=>"Drama", 
				"Ecchi"=>"Ecchi", "Fantasy"=>"Fantasy", "Gender Bender"=>"Gender+Bender", "Harem"=>"Harem", "Historical"=>"Historical", "Horror"=>"Horror", "Josei"=>"Josei", 
				"Martial Arts"=>"Martial+Arts", "Mature"=>"Mature", "Mecha"=>"Mecha", "Mystery"=>"Mystery", "One Shot"=>"One+Shot", "Psychological"=>"Psychological", 
				"Romance"=>"Romance", "School Life"=>"School+Life", "Sci-fi"=>"Sci-fi", "Seinen"=>"Seinen", "Shoujo"=>"Shoujo", "Shoujo Ai"=>"Shoujo+Ai", "Shounen"=>"Shounen", 
				"Shounen Ai"=>"Shounen+Ai", "Slice of Life"=>"Slice+of+Life", "Smut"=>"Smut", "Sports"=>"Sports", "Supernatural"=>"Supernatural", "Tragedy"=>"Tragedy", 
				"Webtoons"=>"Webtoons", "Yaoi"=>"Yaoi", "Yuri"=>"Yuri");
			$genres["Batoto"] = array("4-Koma"=>"40", "Action"=>"1", "Adventure"=>"2", "Award Winning"=>"39", "Comedy"=>"3",
					"Cooking"=>"41", "Doujinshi"=>"9", "Drama"=>"10", "Ecchi"=>"12", "Fantasy"=>"13", 
					"Gender Bender"=>"15", "Harem"=>"17", "Historical"=>"20", "Horror"=>"22", "Josei"=>"34", 
					"Martial Arts"=>"27", "Mecha"=>"30", "Medical"=>"42", "Music"=>"37", "Mystery"=>"4", 
					"Oneshot"=>"38", "Psychological"=>"5", "Romance"=>"6", "School Life"=>"7", "Sci-fi"=>"8", 
					"Seinen"=>"32", "Shoujo"=>"35", "Shoujo Ai"=>"16", "Shounen"=>"33", "Shounen Ai"=>"19", 
					"Slice of Life"=>"21", "Smut"=>"23", "Sports"=>"25", "Supernatural"=>"26", "Tragedy"=>"28", 
					"Webtoon"=>"36", "Yaoi"=>"29", "Yuri"=>"31", "[no chapters]"=>"44");
			$mangaPage = $_GET["mangaPage"];
			$genres = $genres[$mangaPage];
			if(isset($_GET["search"]) && isset($_GET["user"]))
			{
				if(isset($_GET['include']))$included = $_GET['include'];
				if(isset($_GET['exclude']))$exluded = $_GET['exclude'];
				$myAnimelistUser = $_GET["user"];
				$searchOn = true;
			}
		}
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->assign("mangaPage",$mangaPage);
		$smarty->assign("mangaPages",$mangaPages);
		$smarty->assign("genres",$genres);
		$smarty->assign("users",$users);
		$smarty->assign("searchOn",$searchOn);
		$smarty->assign("myAnimelistUser",$myAnimelistUser);
		$smarty->assign("included",$included);
		$smarty->assign("exluded",$exluded);
		$smarty->assign("result",$result);
		$smarty->display($page.".tpl");
	}else
	{
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page."_noLogin.tpl");
	}
?>