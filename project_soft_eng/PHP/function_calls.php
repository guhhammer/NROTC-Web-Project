<?php
	include_once("Database/config.php");
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());


//LIST OF COMPLETED FUNCTIONS AVAILABLE:
/*	get_term($requested_date) returns the requested termID (i.e. the semester)
	get_user_billet($userID, $term) returns the billetID of the given user
	get_next_Coc($origin_userID,$userID,$term) returns the userID of the next user in the chain of command of the given user
	get_aid($userID,$term) returns a string of the aid (concatendated company platoon squad) of a given user
	get_CoC_up($userID,$term) returns a string to display a table of a given user's complete chain of command
	get_OI($userID) returns the userID of the assigned OI of a given user
	get_user_cmd_billet($userID, $term) returns a string of the title of the command billet held by the given user
	get_user_collateral_billet($userID, $term) returns a string of all collateral billets currently held by the given user
	
	function get_user_rank_name($userID) Retuns a string of the ($userID)'s abbreviated rank last name, first and middle initials (ex: LDCR Last, F.M.)
	function get_user_dob($userID) Returns a date value of the ($userID)'s date of birth
	function get_user_gender($userID) Returns a string of the ($userID)'s gender
	function get_personal_info($userID) Retuns a table displaying the user's personal information.
	function get_current_courses($userID) Retuns a table displaying the ($userID)'s current courses for the current term only
*/
//NOT COMPLETE YET:
/*
	function set_OI($userID, $OI)
	function set_new_term($semester,$begin,$end)
	function assign_billet($term, $billetID,$company,$platoon,$squad,$userID)
	function add_student($user_array)
	function add_staff()
	function update_phone($userID, $new_phone)
	function update_email($userID, $new_email)
	function update_address($userID,$new_street,$new_apt,$new_city,$new_residence)
	function update_muster($userID,$new_muster)
	function update_password($userID,$new_password)
	function update_photo($userID,$new_photo)
	function set_new_event($event_title,$event_date,$event_duration,$event_type,$event_owner,$event_notes)
	function update_event()
	function get_event_roster($eventID)
*/

function get_term($requested_date) {
	//Status: Works
	//ToDo: Popup error message when no term is defined for the date.
	//Function: Returns the termID (primary key of term tbl) for the given date. 
		
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }

		$current_term;
		//$requested_date = strtotime($requested_date);

		$find_term = "SELECT * FROM term";

		$result = $conn->query($find_term);

		if($result->num_rows >0){

			while($row = $result->fetch_assoc()){
				if((strtotime($requested_date) < strtotime($row['enddate'])) && (strtotime($requested_date) > strtotime($row['begindate'])) ) {
					$current_term = $row['termID'];
				}
			}
		}

		if($current_term == NULL){
			//throw some error here
			echo "Contact your adminstrator to add term";
		}
		else{
			return $current_term;
			}
	}

function get_user_cmd_billetID($userID, $term){
	//Status: Works
	//ToDo: Popup error when the user ($userID) has not been assigned a billet.
	//Function: Returns the billetID (primary key of billets Table) of a given user ($userID) for a given term($term) for only command billets.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());
		$billet;

		$find_billet_stmt = 'SELECT billet 
			FROM billet_term_roster, billets
			WHERE billet = billetID
				AND command = 1
				AND user = '.$userID.'
			    AND term ='.$term;

		$result = $conn->query($find_billet_stmt);
		if($result->num_rows > 0){

			while($row = $result->fetch_assoc()){
				$billet = $row['billet'];
			}
		}
		else{
			//Throw error here.
			echo "Contact your administrator. No billet assigned for the defined term.";
		}
		return $billet;
	}

function get_all_user_billets($userID, $term){
	//Status: Works
	//ToDo: Popup error when the user ($userID) has not been assigned a billet.
	//Function: Returns an array of billetIDs (primary key of billets Table) for a given user ($userID) for a given term($term) for all billets.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());
		$billets = [];

		$stmt = 'SELECT billet 
			FROM billet_term_roster
			WHERE user = '.$userID.'
			    AND term ='.$term;

		$result = $conn->query($stmt);
		if($result->num_rows > 0){
			$i = 0;
			while($row = $result->fetch_assoc()){
				$billets[$i] = $row['billet'];
				$i++;
			}
		}
		else{
			//Throw error here.
			echo "Contact your administrator. No billet assigned for the defined term.";
		}
		return $billets;
	}

function get_next_Coc($origin_userID,$userID,$term){
	//Status: Works
	//ToDo: None
	//Function: Returns the userID (primary key of users Table) for the next higer billet in the given user's ($userID) 
		// chain of command. Uses $origin_userID to determine the OI assigned.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );

		$nextCoC;
		$user_billet = get_user_cmd_billetID($userID,$term);
		$user_aid = get_aid($userID,$term);	
		$oi = get_OI($origin_userID);

		$find_next_CoC_stmt = 'SELECT *
			FROM billet_term_roster
			WHERE term ='.$term.'
			    ORDER BY billet DESC, company ASC, platoon ASC, squad ASC';

		$result = $conn->query($find_next_CoC_stmt);
		$match_col;
		$match_val;

		while($row = $result->fetch_assoc() ) {
			if($result->num_rows > 0 ){
				if($user_billet > 231){ //match aid and next billet not equal
					$match_col = $row['company'].$row['platoon'].$row['squad'];
					$match_val = $user_aid;
				}
				elseif($user_billet > 221){ //match comp and plt and next billet not equal
					$match_col = $row['company'].$row['platoon'];
					$split = str_split($user_aid,1);
					$match_val = $split[0].$split[1];
				}
				elseif($user_billet > 211){ //match comp and next billet not equal
					$match_col = $row['company'];
					$split = str_split($user_aid,1);
					$match_val = $split[0];
				}
				elseif($user_billet > 201){ //match next billet not equal
					$match_col = "";
					$match_val = "";
				}
				elseif($user_billet == 112){ //match $oi to $row['user']
					$match_col = $row['user'];
					$match_val = $oi;
				}
				elseif($user_billet > 112){ //match next lower
					$match_col = "";
					$match_val = "";
				}
				elseif($user_billet == 101){//done
					return null;
				}
				
				if( ($user_billet > $row['billet']) && ($match_col == $match_val) ) {
					$nextCoC = $row['user'];
					return $nextCoC; 
				}
			}
			else {}
		}
	}	

function get_aid($userID,$term){
	//Status: Works
	//ToDo:
	//Function: Returns a string of the Assignment Identifer Code of the company/platoon/squad for the user ($userID) of a given term ($term).
	//Note: Permenant Unit Staff have a code of 000.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());
		
		$findAIDstmt = 'SELECT DISTINCT company, platoon, squad 
				FROM billet_term_roster
				WHERE user = '.$userID.'
				    AND term ='.$term;
		
		$result = $conn->query($findAIDstmt);
		
		$company; $platoon; $squad;

		if($result->num_rows >0){

			while($row = $result->fetch_assoc()){
			$company = $row['company'];
			$platoon = $row['platoon'];
			$squad = $row['squad'];
			}
		}
		else{} //No else should occur since company, platoon, and squad are required.

		$aid = $company.$platoon.$squad;

		return $aid;
	}

function get_CoC_up($userID,$term){
	//Status: Works
	//ToDo: Determine if any errors can occur and handle response message.
	//Function: Returns a table of the user's ($userID) Chain of Command.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());
				
		$OI = get_OI($userID);
		$aid = get_aid($userID,$term);
		$aidarray = str_split($aid,1);

		$find_CoC_stmt = 'SELECT billet, company, squad, abbrevRank, lastName, firstName, userID
			FROM billet_term_roster, users, ranktbl
			WHERE term ='.$term.'
				AND user = userID
				AND user_rank = rankID
				ORDER BY billet';
	
		$result = $conn->query($find_CoC_stmt);
		$output = "<table><tr> <th> Lvl </th> <th> Billet </th> <th> Name </th> </tr>";
		$lvl = 1;

		if($result->num_rows >0){

			while($row = $result->fetch_assoc()){
				if($row['firstName']!=''){ 
					$array2 = str_split($row['firstName'],1); 
				}
				else {
					$array2[0] = '';
				}
				$caten_name = $row['abbrevRank']." ".$row['lastName'].", ".$array2[0];

				if($row['billet'] == 101){ 
					$output = $output."<tr> <td> ".$lvl." </td> <td> NROTC CO </td> <td> ".$caten_name.".</td></tr>"; $lvl++;
				}
				
				elseif($row['billet']==102){
					$output = $output."<tr> <td> ".$lvl." </td> <td> NROTC XO </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif($row['billet']==103){
					$output = $output."<tr> <td> ".$lvl." </td> <td> NROTC CMDCS </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif(($row['billet']==111)&&($row['userID']==$OI)){
					$output = $output."<tr> <td> ".$lvl." </td> <td> OI </td> <td> ".$caten_name.".</td></tr>"; $lvl++;		
				}
				elseif($row['billet']==112){
					$output = $output."<tr> <td> ".$lvl." </td> <td> AMOI </td> <td> ".$caten_name.".</td></tr>"; $lvl++;		
				}
				elseif($row['billet']==113){
					$output = $output."<tr> <td> ".$lvl." </td> <td> AOI </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif($row['billet']==201){
					$output = $output."<tr> <td> ".$lvl." </td> <td> BN CO </td> <td> ".$caten_name.".</td></tr>"; $lvl++;		
				}
				elseif($row['billet']==202){
					$output = $output."<tr> <td> ".$lvl." </td> <td> BN XO </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif(($row['billet']==211)&&($aidarray[0]==$row['company'])){
					$output = $output."<tr> <td> ".$lvl." </td> <td> ".$aidarray[0]." CO CDR </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif(($row['billet']==212)&&($aidarray[0]==$row['company'])){
					$output = $output."<tr> <td> ".$lvl." </td> <td> ".$aidarray[0]." CO XO </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif(($row['billet']==221)&&($aidarray[0]==$row['company'])&&($aidarray[1]==$row['platoon'])){
					$output = $output."<tr> <td> ".$lvl." </td> <td> ".$aidarray[0].$aidarray[1]." PLT CDR </td> <td> ".$caten_name.".</td></tr>"; $lvl++;		
				}
				elseif(($row['billet']==221)&&($aidarray[0]==$row['company'])&&($aidarray[1]==$row['platoon'])){
					$output = $output."<tr> <td> ".$lvl." </td> <td> ".$aidarray[0].$aidarray[1]." PLT Sgt </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif(($row['billet']==221)&&($aidarray[0]==$row['company'])&&($aidarray[1]==$row['platoon'])&&($aidarray[2]==$row['squad'])){
					$output = $output."<tr> <td> ".$lvl." </td> <td> ".$aidarray[0].$aidarray[1].$aidarray[2]." Sqd Ldr </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
				}
				elseif($row['userID']==$userID){
					$output = $output."<tr> <td> ".$lvl." </td> <td> Member </td> <td> ".$caten_name.".</td></tr>"; $lvl++;	
					return $output;
				}
				else {}
			}//end of while
		}//end of if
		else{
			//Throw error here.
			echo "Error: Contact your administrator!";
		}
		//$output = $output."</table>";
		return $output;
	}

function get_OI($userID){
	//Status: Works
	//ToDo: Popup message to assign an OI to the user ($userID) if one has not been assigned or if drop date of OI is defined.
	//Function: Returns the userID (primary key of users Table) of the given user's ($userID) assigned OI.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

		$current_term = get_term(date("Y-m-d"));
		$OI;
		
		$find_OI_stmt = 'SELECT user, oi.username as OI_Name, oi.userID as OI, stud.userID as student
			FROM billet_term_roster, users as oi, users as stud
			WHERE term = '.$current_term.'
				AND stud.assigned_OI = rosterID
				AND user = oi.userID
				AND oi.dropDate = NULL
				AND stud.userID = '.$userID;
	
		$result = $conn->query($find_OI_stmt);

		if($result->num_rows >0){

			while($row = $result->fetch_assoc()){
				$OI = $row['OI'];
				return $OI;
			}
		}
		
		else{
			//Throw error here.
			return "-";
		}
	}

function get_user_cmd_billet($userID, $term){
	//Status: Works
	//ToDo: None
	//Function: Returns a string of the billet title of the given user ($userID) for a given term ($term).
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		
		//$billetID = get_user_billet($userID,$term);

		$stmt = 'SELECT billetName 
			FROM billet_term_roster, billets
			WHERE user = '.$userID.'
			    AND term ='.$term.'
			    AND billet = billetID
			    AND command = 1';

		$result = $conn->query($stmt);
		if($result->num_rows > 0){

			while($row = $result->fetch_assoc()) { $output = $row['billetName']; }
		}
		else{ $output = "None"; }
		return $output;
	}

function get_user_collateral_billet($userID, $term){
	//Status: Works
	//ToDo: None
	//Function: Returns a string of the collateral billet(s) held by the user ($userID) for a given term ($term).
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		
	//$billetID = get_user_billet($userID,$term);

	$stmt = 'SELECT billetName 
			FROM billet_term_roster, billets
			WHERE user = '.$userID.'
			    AND term ='.$term.'
			    AND billet = billetID
			    AND command = 0';

	$result = $conn->query($stmt);
	$num_rows = $result->num_rows;

	if($num_rows > 0){
		while($row = $result->fetch_assoc()){
			$billet_title = $billet_title.$row['billetName'];
			if($num_rows > 1){ $billet_title = $billet_title.', '; $num_rows--;} 
		}
	}
	else { $billet_title = "None"; }
	
	return $billet_title;
	}

function get_user_rank_name($userID){
	//Status: Works
	//ToDo: None
	//Function: Retuns a string of the ($userID)'s abbreviated rank last name, first and middle initials (ex: LDCR Last, F.M.)
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		
		$output;

		$stmt = 'SELECT abbrevRank, lastName, firstName, middleInitial
					FROM users, ranktbl
					WHERE userID = '.$userID.'
					    AND  user_rank = rankID';

		$result = $conn->query($stmt);

		if($result->num_rows > 0){
			
			while($row = $result->fetch_assoc()) {
				
				$split = str_split($row['firstName'], 1);

				$output = $row['abbrevRank']." ".$row['lastName'].", ".$split[0].".";
				
				if($row['middleInitial'] != ""){
					$output = $output.$row['middleInitial'].".";
				}
			}
		}

		return $output;
	}

function get_user_dob($userID){
	//Status: Works
	//ToDo: None
	//Function: Returns a date value of the ($userID)'s date of birth
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
	
	$output;

	$stmt = 'SELECT dob FROM users WHERE userID = '.$userID;

	$result = $conn->query($stmt);

	if($result->num_rows > 0){
		
		while($row = $result->fetch_assoc()) {
			$output = $row['dob'];
		}
	}

	return $output;
	}

function get_user_gender($userID){
	//Status: Works
	//ToDo: None
	//Function: Returns a string of the ($userID)'s gender
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$output;

		$stmt = 'SELECT sex.gender as sex FROM users as lookup, gender as sex WHERE userID = '.$userID.' AND genderID = lookup.gender';

		$result = $conn->query($stmt);

		if($result->num_rows > 0){
			
			while($row = $result->fetch_assoc()) {
				$output = $row['sex'];
			}
		}

		return $output;
	}

function get_personal_info($userID){
	//Status: Works
	//ToDo: None
	//Function: Retuns a table displaying the user's personal information.
	$term = get_term(date("Y-m-d"));
	$output = "<table>
			<tr><td> Name: ".get_user_rank_name($userID)."</td></tr>
			<tr><td> DOB: ".get_user_dob($userID)."</td></tr>
			<tr><td> Gender: ".get_user_gender($userID)."</td></tr>
			<tr><td> Company/Platoon/Squad: ".get_aid($userID,$term)."</td></tr>
			<tr><td> Command Billet: ".get_user_cmd_billet($userID,$term)."</td></tr>
			<tr><td> Collateral Billets: ".get_user_collateral_billet($userID,$term)."</td></tr>
		</table>";
	return $output;
	}

function get_current_courses($userID){
	//Status: Works
	//ToDo: None
	//Function: Retuns a table displaying the ($userID)'s current courses for the current term only
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$term = get_term(date("Y-m-d"));
		$output = "<table><tr>
				<td><th>CID</th></td>
				<td><th>Course Title</th></td>
				<td><th>Units</th></td>
				<td><th>Days</th></td>
				<td><th>Times</th> </td>
			</tr></table>";

		$stmt = 'SELECT courseID, courseTitle, units, mon, tues, wed, thurs, fri, sat, sun, timebegin, timeend
				FROM academics, course_entries 
				WHERE user = '.$userID.' 
					AND current_term ='.$term;
						
		$result = $conn->query($stmt);
		$num_courses = $result->num_rows;
		$total_units = 0;
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$total_units = $total_units+$row['units'];
				$days; 
				if($row['mon'] == 1) {$days = $days.'M';}
				if($row['tues'] == 1) {$days = $days.'Tu';}
				if($row['wed'] == 1) {$days = $days.'W';}
				if($row['thurs'] == 1) {$days = $days.'Th';}
				if($row['fri'] == 1) {$days = $days.'F';}
				if($row['sat'] == 1) {$days = $days.'Sa';}
				if($row['sun'] == 1) {$days = $days.'Su';}
				$output = $output."<tr>
					<td>".$row['courseID']."</td>
					<td>".$row['courseTitle']."</td>
					<td>".$row['units']."</td>
					<td>".$days."</td>
					<td>".$row['timebegin']."-".$row['timeend']."</td>
					</tr>";
			}
			$output = $output."</table>";
		}
		return $output;
	}

function new_academic_term($userID,$term,$grad_term,$major){
	//Status: Works
	//ToDo: None
	//Function: Creates a new academic term record for the ($userID) and retuns the academicID.
	//Note: You need this academicID to record courses.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		
		$stmt = "INSERT INTO academics (academicID, major, cum_gpa, current_term, grad_term, user) 
				VALUES (NULL, '".$major."', NULL, ".$term.", ".$grad_term.", ".$userID.")";
				
		if($conn->query($stmt) === TRUE){
			$result = $conn->insert_id;
		}
		else{
			$result = "Error: ".$stmt."<br><br>".$conn->error; 
		}
		
		return $result;
	}

function insert_course($userID,$term,$cid,$title,$units,$days,$timebegin,$timeend,$campus,$course_num){
	//Status: Works
	//ToDo: Need to call a Success/Failure validation popup.
	//Function: Creates a new academic term record for the ($userID).
	//Note: $course_num refers to the order that the courses are saved. Must be course1 through course8.
	
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$academicID = find_academic_term($userID,$term);
		
		$days = [0,0,0,0,0,0,0];
		$split = str_split($days,1);
		$commaval = count($split)-1;
		for($i = 0; $i < count($split); $i++){
			
			if($split[$i] == 'M'){
				$days[0] = 1;
			}
			elseif(($split[$i] == 'T') && ($split[$i+1] =='u')){
				$days[1] = 1;
				$i++;
			}
			elseif($split[$i] == 'W'){
				$days[2] = 1;
			}
			elseif(($split[$i] == 'T') && ($split[$i+1] =='h')){
				$days[3] = 1;
				$i++;
			}
			elseif($split[$i] == 'F'){
				$days[4] = 1;
			}
			elseif(($split[$i] == 'S') && ($split[$i+1] =='a')){
				$days[5] = 1;
				$i++;
			}
			elseif(($split[$i] == 'S') && ($split[$i+1] =='u')){
				$days[6] = 1;
				$i++;
			}
		}	

		$daystr = $days[0].', '.$days[1].', '.$days[2].', '.$days[3].', '.$days[4].', '.$days[5].', '.$days[6];
		
		$stmt = "INSERT INTO course_entries (course_entryID, courseID, courseTitle, units, timebegin, timeend, grade, mon, tues, wed, thurs, fri, sat, sun, campus) 
				VALUES (NULL, '".$cid."', '".$title."', ".$units.", '".$timebegin."', '".$timeend."', NULL, ".$daystr.", ".$campus.")";
				
		if($conn->query($stmt) === TRUE){
			$result = $conn->insert_id;
		}
		else{
			return "Error: ".$stmt."<br>".$conn->error; 
		}
		
		$result = $result.update_academic_term($academicID,$course_num,$result);
		return $result;
	}

function find_academic_term($userID,$term){
	//Status: Works
	//ToDo: None
	//Function: retrieves the academic term record for ($userID) and retuns the academicID.
	//Note: You need this academicID to record courses.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$stmt = "SELECT academicID FROM academics WHERE user = ".$userID." AND current_term = ".$term;
		$result = $conn->query($stmt);
		$row = $result->fetch_assoc();
		return $row['academicID'];
	}

function update_academic_term($academicID, $item_to_update, $value){
	//Status: Works
	//ToDo: None
	//Function: retrieves the academic term record for ($userID) and retuns the academicID.
	//Note: Options for $value are: major, cum_gpa, current_term, grad_term, course1,course2,course3,course4,course5,course6,course7,course8, and user
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$stmt = "UPDATE academics SET ".$item_to_update." = '".$value."' WHERE academicID = ".$academicID;
		if($conn->query($stmt) === TRUE){
			$result = "Success";
		}
		else{
			$result = "Error: ".$stmt."<br><br>".$conn->error; 
		}
		
		return $result;
	}

function set_OI($userID, $OI){
	//Status: Working
	//ToDo: Popup Success/Failure message.
	//Function: Updates the assigned OI ($OI) for a given user ($userID) with the OI's userID.
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$term = get_term(date("Y-m-d"));
		
		$stmt = 'SELECT rosterID FROM billet_term_roster WHERE user = '.$OI.' AND term ='.$term.' AND billet = 111';
		$result = $conn->query($stmt);
		if($conn->error) { return "Error: ".$OI." does not have a billet code of 111 (OI billet)."; }
		else{
			$row = $result->fetch_assoc();
		
			$rosterID = $row['rosterID'];
		
			if($result->num_rows > 0) {
				$OI = $row['rosterID'];
		
				$stmt = "UPDATE users SET assigned_OI = ".$OI." WHERE userID = ".$userID;
			
				if($conn->query($stmt) === TRUE){
					$result = "Success";
				}
				else{ $result = "Error: ".$stmt."<br><br>".$conn->error; }
		
				return $result;
			}
			else { return "Error: ".$OI." is not assigned the billet of OI for this term!";}
		}
	}

function insert_new_term($semester,$begin,$end){
	//Status: Works
	//ToDo: Popup Success/Failure message.
	//Function: Creates a new term record. 
		//get calendar year from begin date
		$cy = date_create($begin);
		$cy = date_format($cy,"Y");
		$begin = date("Y-m-d",strtotime($begin));
		$end = date("Y-m-d",strtotime($end));
		
		//get academic year from semester and calendar year
		if($semester == "Fall") {$ay = $cy+1;}
		else{ $ay = $cy; }
		
		//insert new term
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		$stmt = "INSERT INTO term (termID, calendaryear, begindate, enddate, academicyear, semester)
				VALUES (NULL, ".$cy.", '".$begin."', '".$end."', ".$ay.", '".$semester."')";

		if($conn->query($stmt)===TRUE){
			$result = $conn->insert_id;
		}
		else{
			return "Error: ".$stmt."<br>".$conn->error; 
		}
	}

function is_cmd_check($billetID){
	//Status: Works
	//ToDo: 
	//Function: Returns true or false to check if a billet is a command type billet. 
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
	$stmt = "SELECT * FROM billets WHERE command = 1 AND billetID =".$billetID;
	$result = $conn->query($stmt);
	if($result->num_rows > 0)
		{return 1;}
	else
		{return 0;}
	}

function assign_billet($userID,$term, $billetID,$company,$platoon,$squad){
	//Status: Works
	//ToDo: Popup Success/Failure messages.
	//Function: Assigns a billet to a user for the given term.
	//Note: If the user is being assigned a command billet, the previous command billet will be reassigned to the new billet.
		//If no previous command billet was assigned a new one will be assigned. 
		$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );
		
		$current_billets = get_all_user_billets($userID,$term);
		$billet_count = sizeof($current_billets);
		$cmd_billet = 0;
		$cmd_flag = is_cmd_check($billetID);
		echo $current_billets[0]."<br>";
		//change all AIDs to the comp/plat/sqd for this term and user
		if($billet_count > 0){
			//update aids
			for($i=0;$i<$billet_count;$i++){
				
				$stmt = "UPDATE billet_term_roster SET company ='".$company."', platoon =".$platoon.", squad =".$squad." WHERE term =".$term." AND user =".$userID." AND billet =".$current_billets[$i];
				 
				if($conn->query($stmt) === FALSE){ 
					return "Error: ".$stmt."<br><br>".$conn->error; 
				}
				
				//save any cmd billet to be changed below
				if($cmd_flag == 1){
					if(is_cmd_check($current_billets[$i])){
						echo $current_billets[$i]."<br>";
						$cmd_billet = $current_billets[$i]; 
						//echo $cmd_billet;
					}
				}
			}
		}

		//Update current cmd billet if any, user cannot have more than one cmd billet.
		if($cmd_flag == 1){
			$stmt = "UPDATE billet_term_roster SET billet =".$billetID." WHERE term =".$term." AND user =".$userID." AND billet =".$cmd_billet;
			if($conn->query($stmt) === TRUE){
				return "Successfully updated command billet from ".$cmd_billet." to ".$billetID;
			}
			else{ 
				return "Error: ".$stmt."<br><br>".$conn->error; 
			}
		}
		else{
			//insert new billet
			$stmt = "INSERT INTO billet_term_roster (rosterID, term, billet, company, platoon, squad, user)
					VALUES (NULL, ".$term.", ".$billetID.", ".$company.", ".$platoon.", ".$squad.", ".$userID.")";

			if($conn->query($stmt)===FALSE){
				return "Error: ".$stmt."<br>".$conn->error;
			}
			else{
				return "User billet successfully assigned: ".$conn->insert_id;
			}
		}	
	}

///TEST AREA
	//echo update_academic_term(2,"cum_gpa","3.0");
	//echo insert_academic_term(2,3,4,"Underwater Basket Weaving");
	//$cid = 'CS421'; $title = 'TheoryofComputing'; $days = 'MWF'; $tb = '16:00:00'; $te = '17:30:00';
	//echo insert_course(1,3,"CS111","Intro to C++",3,"TuTh","15:30:00","17:00:00",3,"course3");
	//echo is_cmd_check(9999);
	//echo assign_billet(4,3,602,"0","0","0");


/*
	function add_student($user_array){
		//Indices: 0-username, 1-firstName, 2-middleInitial, 3-lastName, 4-dob, 5-gender, 6-email, 7-residence, 8-street, 9-apt,10-city,11-state,12-zip,13-muster,14-phone,15-rank,16-joinDate,17-school,18-program,19-status,20-serviceOption,21-contract,22-OI
		$column_array = ['username','firstName','middleInitial','lastName','dob','gender','email','residence','street','apt','city','state','zip','muster','phone','rank','joinDate','school','program','status','service_option','contract','assigned_OI'];

		$column_array[0] = $user_array[1]."."$user_array[3];
		//Count other users with same name
		$count_stmt = "SELECT COUNT(*) FROM users HAVING username = "

		$insert_stmt = "INSERT INTO users (";
		$values_stmt = ") VALUES (";
		$comma_bool = false;

		for($i = 0; $i < 22, $i++){
			if($user_array[$i] != null){
				
				if( ($comma_bool)) {
					$insert_stmt = $insert_stmt.", ".$column_array[$i];
					$values_stmt = $values_stmt.", ".$user_array[$i];
				}
				elseif($user_array[$i] != null){
					$insert_stmt = $insert_stmt.$column_array[$i];
					$values_stmt = $values_stmt.$user_array[$i];
				}

				$comma_bool = true; 
			}
		}	
		$insert_stmt = $insert_stmt.$values_stmt;

		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
		
		//User validation
		if($conn->query($stmt) == TRUE){ echo "New user add sucessful."; }
		else{ echo "Error updating muster location: ". $conn->error; }

	}
	function add_staff(){}

	function update_phone($userID, $new_phone){
		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
		//Update Sql statement
		$stmt = 'UPDATE users SET phone = '.$new_phone.' WHERE users.userID ='.$userID;
		//User validation
		if($conn->query($stmt) == TRUE){ echo "Phone number update sucessful."; }
		else{ echo "Error updating phone number: ". $conn->error; }
	}

	function update_email($userID, $new_email){
		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
		//Update Sql statement
		$stmt = 'UPDATE users SET email = '.$new_email.' WHERE users.userID ='.$userID;
		//User validation
		if($conn->query($stmt) == TRUE){ echo "Email update sucessful."; }
		else{ echo "Error updating email: ". $conn->error; }
	}

	function update_address($userID,$new_street,$new_apt,$new_city,$new_residence){
		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }

		$setstmt = [];
		$setupdate = "";
		$count = 0;
		if($new_street != null) {$setstmt[$count] = "street = ".$new_street; $count++;}
		if($new_apt != null) {$setstmt[$count] = "apt = ".$new_apt; $count++;}
		if($new_city != null) {$setstmt[$count] = "city = ".$new_city; $count++;}
		if($new_residence != null) {$setstmt[$count] = "residence = ".$new_residence; }
		
		for($i = $count-1; $i > -1; $i--){
			$setupdate = $setupdate.$setstmt[$i].", ";
		}
		$setupdate = $setupdate.$setstmt[$count];

		//Update Sql statement
		$updatestmt = 'UPDATE users SET '.$setupdate.' WHERE users.userID ='.$userID;

		//User validation
		if($conn->query($stmt) == TRUE){ echo "Address update sucessful."; }
		else{ echo "Error updating address: ". $conn->error; }
	}

	function update_muster($userID,$new_muster){
		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
		//Update Sql statement
		$stmt = 'UPDATE users SET muster = '.$new_muster.' WHERE users.userID ='.$userID;
		//User validation
		if($conn->query($stmt) == TRUE){ echo "Muster location update sucessful."; }
		else{ echo "Error updating muster location: ". $conn->error; }
	}

	function update_password($userID,$new_password){
		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
		//Update Sql statement
		$stmt = 'UPDATE users SET password = '.$new_password.' WHERE users.userID ='.$userID;
		//User validation
		if($conn->query($stmt) == TRUE){ echo "Password update sucessful."; }
		else{ echo "Error updating password: ". $conn->error; }
	}

	function update_photo($userID,$new_photo){
		//Check connection
		if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
		//Update Sql statement
		$stmt = 'UPDATE users SET photo = '.$new_photo.' WHERE users.userID ='.$userID;
		//User validation
		if($conn->query($stmt) == TRUE){ echo "Photo update sucessful."; }
		else{ echo "Error updating photo: ". $conn->error; }
	}

	function set_new_event($event_title,$event_date,$event_duration,$event_type,$event_owner,$event_notes){
		$term = get_term($event_date);

		$stmt = 'INSERT INTO events (
			eventID, eventTitle,eventDate,eventDuration,term,eventType,eventOwner,eventNotes) 
		VALUES (
			NULL, '.$event_title.', '.$event_date.', 
			'.$event_duration.', '.$term.', '.$event_type.',
			 '.$event_owner.', '.$event_notes.')';

		if($conn->query($stmt) == TRUE){
			echo "Event successfully submitted";
		}
		else{
			echo "Error: ". $stmt . "<br>". $conn->error;
		}
	}

	function update_event(){}
	

	function get_event_roster($eventID){}
*/

function extended_personal_info($userID){
	// Gustavo's extended information necessity call function for personal information div.
		$term = get_term(date("Y-m-d"));
		return [get_aid($userID, $term),  get_user_cmd_billet($userID, $term),  get_user_collateral_billet($userID, $term)];
	} 

function extended_command_info($userID){
	// Gustavo's extended information necessity call function for command information div.


		global $conn;

		$term = get_term(date("Y-m-d"));

		$OI = get_OI($userID);	$aid = get_aid($userID,$term);  $aidarray = str_split($aid,1);
		
		$find_CoC_stmt = 'SELECT billet, company, squad, abbrevRank, lastName, firstName, userID
			FROM billet_term_roster, users, ranktbl
			WHERE term ='.$term.'
				AND user = userID
				AND user_rank = rankID
				ORDER BY billet';

		$result = $conn->query($find_CoC_stmt);   $output = [];

		if($result->num_rows >0){

			while($row = $result->fetch_assoc()){
				
				if($row['firstName']!=''){  $array2 = str_split($row['firstName'],1);  }  else { $array2[0] = ''; }
				$caten_name = $row['abbrevRank']." ".$row['lastName'].", ".$array2[0];

				if($row['billet'] == 101){ array_push($output, ["NROTC CO", $caten_name]); }
				
				elseif($row['billet']==102){ array_push($output, ["NROTC XO", $caten_name]); }

				elseif($row['billet']==103){ array_push($output, ["NROTC CMDCS", $caten_name]); }

				elseif(($row['billet']==111)&&($row['userID']==$OI)){ array_push($output, ["OI", $caten_name]); }

				elseif($row['billet']==112){ array_push($output, ["AMOI", $caten_name]); }

				elseif($row['billet']==113){ array_push($output, ["AOI", $caten_name]); }

				elseif($row['billet']==201){ array_push($output, ["BN CO", $caten_name]); }

				elseif($row['billet']==202){ array_push($output, ["BN XO", $caten_name]); }
				elseif(($row['billet']==211)&&($aidarray[0]==$row['company'])){ array_push($output, [$aidarray[0]." CO CDR", $caten_name]); }
				
				elseif(($row['billet']==212)&&($aidarray[0]==$row['company'])){ array_push($output, [$aidarray[0]." CO XO", $caten_name]); }
				
				elseif(($row['billet']==221)&&($aidarray[0]==$row['company'])&&($aidarray[1]==$row['platoon'])){
					array_push($output, [$aidarray[0].$aidarray[1]." PLT CDR", $caten_name]); 
				}

				elseif(($row['billet']==221)&&($aidarray[0]==$row['company'])&&($aidarray[1]==$row['platoon'])){ 
					array_push($output, [$aidarray[0].$aidarray[1]." PLT Sgt", $caten_name]);
				}

				elseif(($row['billet']==221)&&($aidarray[0]==$row['company'])&&($aidarray[1]==$row['platoon'])&&($aidarray[2]==$row['squad'])){ 
					array_push($output, [$aidarray[0].$aidarray[1].$aidarray[2]." Sqd Ldr", $caten_name]);
				}
				
				elseif($row['userID']==$userID){
					array_push($output, ["Member", $caten_name]);  return $output;
				}

				else {}

			}//end of while

		}//end of if
		
		else{
			//Throw error here.
			echo "Error: Contact your administrator!";
		}

		return $output;

	}

function extended_academic_info($userID){
	// Gustavo's extended information necessity call function for academic information div.

		global $conn;  $term = get_term(date("Y-m-d")); $output = [];

		$stmt = 'SELECT courseID, courseTitle, units, mon, tues, wed, thurs, fri, sat, sun, timebegin, timeend
				FROM academics, course_entries 
				WHERE user = '.$userID.' 
					AND current_term ='.$term;
						
		$result = $conn->query($stmt);

		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$days = ""; 
				if($row['mon'] == 1) {$days = $days.'M';}
				if($row['tues'] == 1) {$days = $days.'Tu';}
				if($row['wed'] == 1) {$days = $days.'W';}
				if($row['thurs'] == 1) {$days = $days.'Th';}
				if($row['fri'] == 1) {$days = $days.'F';}
				if($row['sat'] == 1) {$days = $days.'Sa';}
				if($row['sun'] == 1) {$days = $days.'Su';}
				
				array_push($output, [$row['courseID'], $row['courseTitle'], $row['units'], $days, $row['timebegin']."-".$row['timeend']]);

			}
		}

		return $output;

	}
	
?>
