<?php 

	function get_user_information($username_value){

		return 
		(
			
			"<div id=\"user_info\" class=\"home_div\">".
				"<p id=\"title\" class=\"title_c\">User Information</p>".
				"<table align=\"center\">".
					"<tr>".
						"<td style=\"width: 50%;\"><p id=\"username\">Username:</p></td>"."<td style=\"width: 50%;\"><p id=\"username_value\">".$username_value."</p></td>".
					"</tr>".
					"<tr>".
						"<td colspan=\"2\" style=\"width: 100%;\">".
						"<table><tr><td><button id=\"password_click\" class=\"pop_up_click_initial_button\">Click here</button></td><td><p>to change password</p></td></tr></table>".
						"</td>".
					"</tr>".
				"</table>".
			"</div>"

		);

	}

?>