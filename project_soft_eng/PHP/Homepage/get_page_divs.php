<?php 
	
	$userID = $_POST['id'];

	$divs['confirm'] = "not ok";  $divs['all'] = ""; 

	// ===================================================================================================================================================

	include_once("../Database/config.php");
	include_once("../Database/selector.php");
	include_once("Divs/personal_information.php");
	include_once("Divs/contact_information.php");
	include_once("Divs/user_information.php");
	include_once("Divs/command_information.php");
	include_once("Divs/my_photo.php");
	include_once("Divs/service_information.php");
	include_once("Divs/academic_information.php");
	include_once("../function_calls.php");


	$selector = new Selector();

	$info = $selector->getValues([], "*", "users", [["userID", $userID]], $divs["confirm"])[0];
	
	$info_rank = $selector->getValues([], "*", "ranktbl", [["rankID", $info["user_rank"]]], $divs["confirm"])[0];
	
	$info_gender = $selector->getValues([], "*", "gender", [["genderID", $info["gender"]]], $divs["confirm"])[0];

	$info_resident = $selector->getValues([], "*", "residency", [["residencyID", $info["residence"]]], $divs["confirm"])[0];

	$info_mpp = $selector->getValues([], "*", "muster_points", [["muster_pointID", $info["muster"]]], $divs["confirm"])[0];

	$info_serv = [
			$selector->getValues([], "*", "service_program", [["service_programID", $info["program"]]], $divs["confirm"])[0]["service_program"],
			$selector->getValues([], "*", "program_status", [["statusID", $info["status"]]], $divs["confirm"])[0]["status"],
			$selector->getValues([], "*", "service_options", [["service_optionID", $info["service_option"]]], $divs["confirm"])[0]["service_option"],
			$selector->getValues([], "*", "service_contract", [["service_contractID", $info["contract"]]], $divs["confirm"])[0]["contract"]
	];

	$info_acd = $selector->getValues([], "*", "academics", [["user", $userID], ["current_term", get_term(date("Y-m-d"))]], $divs["confirm"])[0];

	$school_abbrev = $selector->getValues([], "*", "campuses", [["campusID", $info["userSchool"]]], $divs["confirm"])[0]["abbrev"];

	unset($selector);	


	// ===================================================================================================================================================	


	$epi = extended_personal_info($userID);

	$chain_of_command_arr = extended_command_info($userID);

	$subjects = extended_academic_info($userID);

	$divs["all"] = 
	(

		get_personal_information($info_rank["abbrevRank"], $info["lastName"], $info["firstName"], $info["middleInitial"], $info["dob"], $info_gender["gender"], 
								 $epi[0], $epi[1], $epi[2])."\n".
		
		get_contact_information(
						$info["phone"], $info["email"], $info_resident["resident"], $info["street"], $info["city"],
			 			$info["state"], $info["zip"], $info["apt"], $info_mpp["point"])."\n".					
		
		get_user_information($info["username"])."\n".

		get_command_information($chain_of_command_arr)."\n".

	    get_photo_information($info["photo"])."\n". //$info["photo"]  -> diminish the quality of photos: it's taking too long to load. 

		get_service_information($info_serv[0], $info_serv[1], $info_rank["abbrevRank"], $info_serv[2], $info_serv[3])."\n".
		
		get_academic_information($school_abbrev, $info_acd["grad_term"], $info_acd["major"], $info_acd["cum_gpa"], $subjects)

	);

	// ===================================================================================================================================================


	$divs['confirm'] = "ok";

	echo json_encode($divs);

?>