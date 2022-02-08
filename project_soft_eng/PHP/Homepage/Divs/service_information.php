<?php 
	
	function get_service_information($program_value, $prog_st_value, $rank_value, $serv_op_value, $contract_value){

		return
		(

			"<div id=\"service_info\" class=\"home_div\">".
				"<p id=\"title\" class=\"title_c\">Service Information</p>".
				"<table align=\"center\">".
					"<tr>".
						"<td><p id=\"program\">Program:</p></td>"."<td><p id=\"program_value\">".$program_value."</p></td>".
						"<td><p id=\"prog_st\">Program Status:</p></td>"."<td><p id=\"prog_st_value\">".$prog_st_value."</p></td>".
					"</tr>".
					"<tr>".
						"<td><p id=\"rank\">Rank:</p></td>"."<td><p id=\"rank_value\">".$rank_value."</p></td>".
						"<td><p id=\"serv_op\">Service Option:</p></td>"."<td><p id=\"serv_op_value\">".$serv_op_value."</p></td>".
					"</tr>".
					"<tr>".
						"<td><p id=\"contract\">Contract:</p></td>"."<td><p id=\"contract_value\">".$contract_value."</p></td>".
						"<td><p></p></td>"."<td><p></p></td>".
					"</tr>".
				"</table>".
			"</div>"

		);

	}

?>