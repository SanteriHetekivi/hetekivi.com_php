<?php
	$session=&$_SESSION["session"];
	if($session->checkLogin())navigate(HOME);
	$page = "login";
	$smarty->display($page.".tpl");
?>