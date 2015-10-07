<?php	
	header("Content-Type: text/html; charset=utf-8");
	ini_set("display_errors","1");
	ini_set("error_reporting",E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
	ini_set("file_uploads","on");
	set_time_limit(0);

	require_once("/libs/conf.php");

	$libraries = array("dump_r","smarty",
		"mysql",
		"classes");
		
	function debug($_variable)
	{
		die(dump_r($_variable));
	}
	require_once(LIBS_PATH."functions.php");
	
	
	foreach($libraries as $library)require(LIBS_PATH.$library."/".$library.".php");
	require(LIBS_PATH."mysql/SQLFunctions.php");
	
	session_name("HETEKIVI");
	session_start();
	if(!isset($_SESSION["session"])) $_SESSION["session"]=new Session();
	$session=&$_SESSION["session"];
	
	$action = isset($_POST["action"])?$_POST["action"]:FALSE;
	$page = isset($_GET["page"])?$_GET["page"]:HOME;
	//debug($_POST);
	if($action == "login") require(PAGES_PATH."login/actions.php");
	elseif($page=="logout") {$session->Logout();navigate(HOME);}
	elseif($session->checkLogin())
	{
		require_once(LIBS_PATH."xajax/xajax_core/xajax.inc.php");
		$xajax = new xajax();
		$xajax->setCharEncoding("UTF-8");
		$xajax->configure('javascript URI', 'https://www.hetekivi.com/libs/xajax/');
		require_once(LIBS_PATH."AJAXFunctions.php");
		if($action)
		{
			if($session->checkPage($action)) require(PAGES_PATH.$action."/actions.php");			
			else navigate(HOME);
		}
		elseif($page && $session->checkPage($page))
		{
			require(PAGES_PATH.$page."/page.php");
		}
	}
	elseif($page && $session->checkPage($page)) 
	{
		require(PAGES_PATH.$page."/page.php");
	}
	else navigate(HOME);
	exit();
?>