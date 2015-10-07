<?php
	
	//Setting up smarty
	require(LIBS_PATH."/smarty/smarty-3.1.27/libs/Smarty.class.php");
	
	
	function startSMARTY()
	{
		$smarty = new Smarty;
		$smarty->compile_check = true;
		$smarty->debugging = false;
		$smarty->setTemplateDir(TEMPLATES_PATH);
		$smarty->setCompileDir(LIBS_PATH."smarty/templates_c");
		$smarty->setCacheDir(LIBS_PATH."smarty/cache");
		$smarty->setConfigDir(LIBS_PATH."smarty/configs");
		$smarty->force_compile = false;
		$smarty->error_reporting = E_ALL & ~E_NOTICE;
		$smarty->caching = 0;
		
		return $smarty;
	}
	

?>