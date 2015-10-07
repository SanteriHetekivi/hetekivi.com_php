<?php
	$page = "giftList";
	
	
	$table = (isset($session->tables[$page]) && is_object($session->tables[$page]))?$session->tables[$page]:FALSE;
	$submit = ($_POST["submit"])?$_POST["submit"]:FALSE;
	if($submit == "Save" && $table)
	{
		$table->SAVE();

	}
	
	if(isset($_POST["addNewType"]) && isset($_POST["title"]))
	{
		$mType = new GiftType(array("title"=>$_POST["title"]));
		$mType->COMMIT();
	}
	
	/*if(isset($_POST["Save"]) && isset($_POST["gift"]))
	{
		$gift = $_POST["gift"];
		$position = $gift["position"];
		unset($gift["position"]);
		$mGift = new Gift($gift);
		$mGift->setPosition($position);
		$mGift->COMMIT();
	}
	if(isset($_POST["Delete"]) && isset($_POST["linkedID"]))
	{
		$mUserLink = new UserLink($_POST["linkedID"]);
		$mUserLink->REMOVE();
	}*/
	
	navigate($page);
?>