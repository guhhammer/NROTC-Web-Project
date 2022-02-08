<?php
	include("../../Database/config.php");
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());
	date_default_timezone_set("America/Los_Angeles");

	//TODO: MOVE THIS SOMEWHERE ELSE SO IT CAN BE ACCESSED FOR CHIT APPROVALS TOO
	int get_next_Coc($billet){
		$nextCoC;
		if($billet == 223){
			$nextCoC = 222;
		}
		elseif($billet == 222){
			$nextCoC = 221;
		}
		elseif($billet == 221){
			$nextCoC = 212;
		}
		elseif($billet == 212){
			$nextCoC = 211;
		}
		elseif($billet == 211){
			$nextCoC = 202;
		}
		elseif($billet == 202){
			$nextCoC = 201;
		}
		elseif($billet == 201){
			$nextCoC = 112;
		}	
		elseif($billet == 112){
			$nextCoC = 111;
		}
		elseif($billet == 111){
			$nextCoC = 103;
		}
		elseif($billet == 103){
			$nextCoC = 102;
		}
		elseif($billet == 102){
			$nextCoC = 101;
		}
		else{
			$nextCoC = 0;
		}
		return $nextCoC;
	}//END OF get_next_CoC

	$userID = $_POST['id'];

	$divs['confirm'] = "not ok";  
	$divs['all'] = ""; 
	$divs["pending_chits"] = ""; 
	$divs["completed_chits"] = "";

	$id = $_COOKIE['id'];
	$divs['confirm'] = "ok";
	
	//Create Chit	
	//TODO:

	//Initialize variables
	$timestamp = date("Y-m-d H:i:s");
	$current_date = date("Y-m-d");
	$request_date = $_POST[beginDateTime]->format("Y-m-d");
	$current_term;
	
	//Find the termID for the period of the chit
	$find_term = 'SELECT * FROM term';
	$result = $conn->query($find_term);
	
	while(($row = $result->fetch_assoc())!= NULL){
		if(($request_date <= $row["enddate"]) && ($request_date >= $row["beginDate"])) {
			$current_term = $row["termID"];
		}
	}
	if($current_term == NULL){
		//throw some error here
	}

	//Find the user's AID and billet
	$findAIDstmt = 'SELECT DISTINCT termID, company, platoon, squad 
			FROM billet_term_roster
			WHERE user = '.$userID.'
			    AND term ='.$current_term;
	
	$result = $conn->query($findAIDstmt);
	
	$company;
	$platoon;
	$squad;
	$billet;

	while(($row = $result->fetch_assoc())!= NULL){
		$company = $row["company"];
		$platoon = $row["platoon"];
		$squad = $row["squad"];
		$billet = $row["billet"];
	}
	if($company == NULL)
		{$company = '0';}
	if($platoon == NULL)
		{$platoon = '0';}
	if($squad == NULL)
		{$squad = '0';}

	$aid = $company.$platoon.$squad;

	$nextCoC = get_next_Coc($billet);

	$event;

	//Insert Documentation file into DB
	//TODO: Call upload.php here
	$docID; //save docID here to insert below

	//Insert Chit into DB
	$stmt = 'INSERT INTO chits (
			chitID, timestamp, justification, 
			dateTimeBegin, dateTimeEnd, routingStatus, 
			transMode, distance, primaryPhone, 
			primaryAddress, alternatePhone, alternateAddress, 
			documentation, cancel, aid, 
			nextCoC, chitType, event, 
			user, awAction, lastComment) 
		VALUES (
			NULL, '.$timestamp.', '.$_POST[justification].', 
			'.$_POST[beginDateTime].', '.$_POST[endDateTime].', '1',
			 '.$_POST[travelMode].', '.$_POST[distance].', '.$_POST[priPhone].', 
			 '.$_POST[primary_address].', '.$_POST[altPhone].', '.$_POST[altAddress].', 
			 '.$docID.', 0, '.$aid.', 
			 '.$nextCoC.', '.$_POST[chitType].', '.$_POST[event].', 
			 '.$userID.', '.$nextCoC.', NULL)';

	if($conn->query($stmt) == TRUE){
		echo "Chit successfully submitted";
	}
	else{
		echo "Error: ". $stmt . "<br>". $conn->error;
	}
	//TODO: Validation and popup message that chit submission was successful

	$conn->close();

?>
