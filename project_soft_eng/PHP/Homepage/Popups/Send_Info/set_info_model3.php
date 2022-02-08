<?php 
		
	include_once("../../../Database/config.php");
	include_once("../../../Database/selector.php");

	$data = $_POST['data'];
	$data = str_replace(' ', '+', $data);
	$data = substr($data, strpos($data, ',') + 1);
	$data = base64_decode($data);
	$ok = "";

	$file_column = ($_POST['popup'] === "transcript_new") ? "transcript" : ( ($_POST['popup'] === "degree_plan_new") ? "degree_plan" : "photo");
	

	$selector = new Selector();

	$selector->setValues("users", [$file_column], [$data], [["userID", $_POST["id"]]], $ok);
			
	if(!($file_column === "photo")){

		$selector->setValues("users", [$file_column."_name"], [$_POST["name"]], [["userID", $_POST["id"]]], $ok);

	}

	unset($selector);

	echo json_encode($ok." ".$file_column);

?>