<?php 

	function get_command_information($chain_of_command_arr){

		$chain_to_string = "<tr><td><p id=\"lvl_0\">Lvl</p></td><td><p id=\"bil_0\">Bilet</p></td><td><p id=\"name_0\">Name</p></td></tr>";
		
		$level = 0;
		for($i = 0; $i < sizeof($chain_of_command_arr); $i++){
			$level = $i+1;
			$chain_to_string = $chain_to_string.
							   ("<tr><td><p id=\"lvl_".$level."\">".$level."</p></td>".
								"<td><p id=\"bil_".$level."\">". $chain_of_command_arr[$i][0] .", </p></td>".
								"<td><p id=\"name_".$level."\">".$chain_of_command_arr[$i][1]."</p></td></tr>");
		}

		return 
		(

			"<div id=\"command_info\" class=\"home_div\">".
				"<p id=\"title\" class=\"title_c\">Command Information</p>".
				"<p id=\"chain\">Chain of Command:</p>".
				"<table align=\"center\">".$chain_to_string."</table>".
			"</div>"

		);

	}

?>