<?php
	$page = "mal";
	$session=&$_SESSION["session"];	
	require(STANDARD_SMARTY);
	if($session->checkLogin())
	{
		$table = (isset($session->tables[$page]) && is_object($session->tables[$page]))?$session->tables[$page]:FALSE;
		if($table)
		{
			$table = $session->tables[$page];
			$table->UPDATE();
		}
		else
		{
			$table = new Table($page, "Manga", TRUE, TRUE, $_page = FALSE, "users_links.manga_anime_last_updated DESC" , $_mainHeaders = FALSE, $_columns = FALSE, $_elements = FALSE);
			$table->addColumn($_name = "image", $_title = "Image", $_isLinkedValue = FALSE, $_references = FALSE, $_dataType = "image", $_tds = FALSE);
			$table->addColumn($_name = "title", $_title = "Name", $_isLinkedValue = FALSE, $_references = FALSE, $_dataType = FALSE, $_tds = FALSE);
			$table->addColumn($_name = "manga_anime_score", $_title = "Score", $_isLinkedValue = TRUE, $_references = FALSE, $_dataType = "number", $_tds = FALSE);
			$table->UPDATE();
			$session->tables[$page] = $table;
		}
		$userID = $session->user->getValue("id");
		$smarty->assign("table", $table);
		$smarty->assign("userid",$userID);
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page.".tpl");
		$smarty->display("bottom.tpl");
	}else
	{
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page."_noLogin.tpl");
	}
	
	
?>