<?php
	$page = "login";
	$session=&$_SESSION["session"];
	if(isset($_POST["login"]) && isset($_POST["username"]) && isset($_POST["password"]))
	{
		$session->Login($_usename=$_POST["username"],$_password=$_POST["password"]);
		navigate(HOME);
	}
	navigate($page);
?>