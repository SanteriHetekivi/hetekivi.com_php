<?php
	$page = "giftList";
	$session=&$_SESSION["session"];	
	require(STANDARD_SMARTY);
	if($session->checkLogin())
	{
		$giftTypes = SQL_SELECT_COLUMN($_table="gifts_types", $_column="title");
		$userID = $session->user->getValue("id");
		$giftPositions = SQL_getGiftPositions($userID);
		$getGiftsUserDoesNotHaveTitles = SQL_getGiftsUserDoesNotHaveTitles($userID);
		$giftsUserDoesNotHave = SQL_getGiftsUserDoesNotHave(array_keys($getGiftsUserDoesNotHaveTitles));
		$onChange = "var elements = ".json_encode($giftsUserDoesNotHave)."; 
			this_edit(false, elements[from.value]);";
		$table = (isset($session->tables[$page]) && is_object($session->tables[$page]))?$session->tables[$page]:FALSE;
		if($table)
		{
			$table = $session->tables[$page];
			$table->updateColumnReferences("gift_position", $giftPositions);
			$table->updateColumnReferences("gifts_types_id", $giftTypes);
			$table->updateExtraValues("not_in_giflist", $getGiftsUserDoesNotHaveTitles);
			$table->updateExtraScript("not_in_giflist", "onChange", $onChange);
			$table->UPDATE();
			//debug($table);
		}
		else
		{
			$giftPositionsSelected = max($giftPositions);
			$table = new Table($page, "Gift", TRUE, TRUE, $_page = FALSE, "users_links.gift_position ASC", $_mainHeaders = FALSE, $_columns = FALSE, $_elements = FALSE);
			$table->addColumn($_name = "gift_position", $_title = "Position", $_isLinkedValue = TRUE, $_references = $giftPositions  , $_dataType = "select", $_tds = FALSE);
			$table->addColumn($_name = "image", $_title = "Image", $_isLinkedValue = FALSE, $_references = FALSE, $_dataType = "image", $_tds = FALSE);
			$table->addColumn($_name = "url", $_title = "Url", $_isLinkedValue = FALSE, $_references = FALSE, $_dataType = "url", $_tds = FALSE);
			$table->addColumn($_name = "gifts_types_id", $_title = "Type", $_isLinkedValue = FALSE, $_references = $giftTypes, $_dataType = "reference", $_tds = FALSE);
			$table->addColumn($_name = "price", $_title = "Price", $_isLinkedValue = FALSE, $_references = FALSE, $_dataType = "euro", $_tds = FALSE);
			
			$table->addExtra($name = "not_in_giflist", $extraType="edit_input", $title = "Select", $values = $getGiftsUserDoesNotHaveTitles, $inputType = "select", $onClick = FALSE, $onChange);
			$table->UPDATE();
			//debug($table);
			$session->tables[$page] = $table;
		}
		$smarty->assign("giftTypes",$giftTypes);
		$smarty->assign("userid",$userID);
		$smarty->assign("table",$table);
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page.".tpl");
		$smarty->display("bottom.tpl");
	}else
	{
		$smarty->assign("giftListTable",getGiftListTable($_userid=1));
		$smarty->assign("pagePath",PAGES_PATH.$page."/");
		$smarty->display($page."_noLogin.tpl");
	}
	
	
?>