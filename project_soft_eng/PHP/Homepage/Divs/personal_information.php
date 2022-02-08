<?php 

	function get_personal_information($rank_value, $lastname, $firstname, $middleInitial, $dob_value, $gender_type, $cps_value, $ccmdb_value, $ccltb_value){

		return 
		(
			
			"<div id=\"personal_info\" class=\"home_div\">".	
				"<p id=\"title\" class=\"title_c\">Personal Information</p>".
				"<table align=\"center\">".
					
					"<tr>"."<td><p id=\"rank_lname\">".$rank_value." ".$lastname.","."</p></td>"."<td><p id=\"rank_fname\">".$firstname.
											" ".$middleInitial."</p></td>"."</tr>".

					"<tr>"."<td><p id=\"dob\">DOB:</p></td>"."<td><p id=\"dob_value\">".$dob_value."</p></td>"."</tr>".
					
					"<tr>"."<td><p id=\"gender\">GENDER:</p></td>"."<td><p id=\"gender_value\">".$gender_type."</p></td>"."</tr>".

					"<tr>"."<td><p id=\"cps\">COMP / PIT / Sqd:</p></td>"."<td><p id=\"cps_value\">".$cps_value."</p></td>"."</tr>".
					
					"<tr>"."<td><p id=\"ccmdb\">Current Command Billet:</p></td>"."<td><p id=\"ccmdb_value\">".$ccmdb_value."</p></td>"."</tr>".

					"<tr>"."<td><p id=\"ccltb\">Current Collateral Billet:</p></td>"."<td><p id=\"ccltb_value\">".$ccltb_value."</p></td>"."</tr>".

				"</table>".
			"</div>"

		);

	}

?>