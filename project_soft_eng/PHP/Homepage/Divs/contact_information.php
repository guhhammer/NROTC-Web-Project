<?php
 
	function get_contact_information($phone_value, $email_value, $resident, $street_dorm_value, 
						$city_value, $state_value, $zip_value, $apt_bld_value, $mpp_value_name){

		return 
		(

			"<div id=\"contact_info\" class=\"home_div\">".
				"<p id=\"title\" class=\"title_c\">Contact Information</p>".
	            "<table align=\"center\">".	
					"<tr>".
						"<td><p id=\"phone\">Phone:</p></td>"."<td><p id=\"phone_value\">".$phone_value."</p></td>".
						"<td><button id=\"contact_click_phone\" class=\"pop_up_click_initial_button\">(edit)</button></td>".
					"</tr>".
				
					"<tr>".
						"<td><p id=\"email\">Email:</p></td>"."<td><p id=\"email_value\">".$email_value."</p></td>".
						"<td><button id=\"contact_click_email\" class=\"pop_up_click_initial_button\">(edit)</button></td>".
					"</tr>".

					"<tr>".
						"<td><p id=\"physical_residence\">Physical Residence:</p></td>"."<td><p id=\"physical_residence_value\">".$resident."</p></td>".	
						"<td><button id=\"contact_click_ph_res\" class=\"pop_up_click_initial_button\">(edit)</button></td>".
					"</tr>".
						
					((strtolower($resident) == "off-campus")  ?
						(

						"<tr id=\"off_campus_1\">"."<td><p id=\"street_dorm\">Street/Dorm #:</p></td>"."<td><p id=\"street_dorm_value\">".$street_dorm_value."</p></td>"."<td><p></p></td>"."</tr>".
			
						"<tr id=\"off_campus_2\">"."<td><p id=\"apt_bld\">Apt/Building:</p></td>"."<td><p id=\"apt_bld_value\">".$apt_bld_value."</p></td>"."<td><p></p></td>"."</tr>".
			
						"<tr id=\"off_campus_3\">"."<td><p id=\"city\">City:</p></td>"."<td><p id=\"city_value\">".$city_value."</p></td>"."<td><p></p></td>"."</tr>".
			
						"<tr id=\"off_campus_4\">"."<td><p id=\"state\">State:</p></td>"."<td><p id=\"state_value\">".$state_value."</p></td>"."<td><p></p></td>"."</tr>".
			
						"<tr id=\"off_campus_5\">"."<td><p id=\"zip\">Zip:</p></td>"."<td><p id=\"zip_value\">".$zip_value."</p></td>"."<td><p></p></td>"."</tr>"
			
						)
							: ""
					).

					"<tr>".
						"<td><p id=\"mpp\">Muster Point Preference:</p></td>"."<td><p id=\"mpp_value\">".$mpp_value_name."</p></td>".
						"<td><button id=\"contact_click_mpp\" class=\"pop_up_click_initial_button\">(edit)</button></td>".
					"</tr>".
				"</table>".
			"</div>"

		);

	}

?>