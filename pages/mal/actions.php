<?php
	$page = "mal";
	$session=&$_SESSION["session"];	

	$table = (isset($session->tables[$page]) && is_object($session->tables[$page]))?$session->tables[$page]:FALSE;
	
	$submit = ($_POST["submit"])?$_POST["submit"]:FALSE;
	if($submit == "Save" && $table)
	{
		$table->SAVE();

	}
	
	navigate($page);
?>