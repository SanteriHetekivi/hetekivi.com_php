<?php
	$page = "home";
	$session=&$_SESSION["session"];	
	require(STANDARD_SMARTY);
	if($session->checkLogin())
	{
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page.".tpl");
	}else
	{
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page."_noLogin.tpl");
	}
?>