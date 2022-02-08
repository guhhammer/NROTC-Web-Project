<?php 

	
	$userID = $_POST['id'];

	$divs['confirm'] = "not ok";  $divs['all'] = ""; $divs["curr_term"] = ""; $divs["prev_term"] = "";


	//=======================================================================================


	include("Divs/current_term.php");
	include("Divs/previous_term.php");


	//=======================================================================================


	$divs["all"] = (get_current_term($userID, $divs["curr_term"])."\n".
					get_previous_terms($userID, $divs["prev_term"]));


	//=======================================================================================


	$divs['confirm'] = "ok";

	echo json_encode($divs);


?>