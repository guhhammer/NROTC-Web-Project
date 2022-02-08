<?php 

	include_once("../../../Database/config.php");
	include_once("../../../Database/selector.php");

	$ok = "";
	
	(new Selector())->setValues("users", [$_POST["popup_ask"]], [$_POST["new_value"]], [["userID", $_POST["id"]]], $ok);
	
?>