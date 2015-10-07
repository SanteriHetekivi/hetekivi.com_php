<?php	
	$smarty = startSMARTY();
    $smarty->assign("xajax_javascript",($xajax)?$xajax->getJavascript('libs/xajax/'):FALSE);
	$smarty->display(TEMPLATES_PATH."head.tpl");
	$smarty->assign("page",$page);
	$smarty->assign("pages",$session->getPages());
	$smarty->assign("isLogged",$session->checkLogin());
	$smarty->display("top.tpl");
?>
