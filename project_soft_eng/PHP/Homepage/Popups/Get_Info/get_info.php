<?php 
	
	include_once("../../../Database/config.php");
	include_once("../../../Database/selector.php");

	$res["ok"] = "";
	$res["file"] = (new Selector())->getFile($_POST["popup_ask"], "users", [["userID", $_POST["id"]]], $res["ok"]);

	echo json_encode($res);

?>