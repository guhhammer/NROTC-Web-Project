<?php 

	include_once("../../../Database/config.php");
	include_once("../../../Database/selector.php");


	$ok = "";  $index_ = ["residence", "street", "apt", "city", "state", "zip"];
	
	$new_values = explode(",", $_POST["info_arr"]); $selector = new Selector();

	for($i = 0; $i < sizeof($new_values); $i++) {
		if(strlen($new_values[$i]) > 0){

			$selector->setValues("users", [$index_[$i]], [$new_values[$i]], [["userID", $_POST["id"]]], $ok);

		}
	}

?>