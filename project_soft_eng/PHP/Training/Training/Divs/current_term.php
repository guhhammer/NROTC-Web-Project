<?php 

	include_once("../../Database/config.php");
	include_once("../../Database/selector.php");
	
	function get_current_term($userID, &$status){

		$date = [];  $event = [];  $owner = [];  $notes = [];

		//(new Selector())->getValues( [&$date, &$event, &$owner, &$notes], ["", "", "", ""], "table", [["userID", $userID]], $status );
		
		$rows = "";
		for($i = 0; $i < sizeof($date); $i++){
			$k = $i + 1;
			$rows = $rows.
			   ("<tr>".
					"<td>".
						"<p id=\"permission_".$k."\">".
							"[<button id=\"view_".$k."\" class=\"curr_term_b\">view</button>]".
					    	"/[<button id=\"edit_".$k."\" class=\"curr_term_b\">edit</button>]".
					    "</p>".
					"</td>".
					"<td><p id=\"date_".$k."\">".$date[$k]."</p></td>".
					"<td><p id=\"event_".$k."\">".$event[$k]."</p></td>".
					"<td><p id=\"owner_".$k."\">".$owner[$k]."</p></td>".
					"<td><p id=\"notes_".$k."\">".$notes[$k]."</p></td>".
				"</tr>");
		}

		return
		(

			"<div class=\"training-parent\" id=\"curr_term\">".		
				//"<p id=\"title\">Current Term</p>".
				"<h1>Current Term</h1>".
				"<table>".
					"<tr id=\"header\">".
						"<td><p id=\"permission_0\">Permission</p></td>".
						"<td><p id=\"date_0\">Date</p></td>".
						"<td><p id=\"event_0\">Event</p></td>".
						"<td><p id=\"owner_0\">Event Owner</p></td>".
						"<td><p id=\"notes_0\">Notes</p></td>".
					"</tr>".

					"<tr>".//EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"permission_1\">[<button id=\"view_1\" class=\"curr_term_b\">view</button>]".
						                          "/[<button id=\"view_1\" class=\"curr_term_b\">edit</button>]</p></td>".
						"<td><p id=\"date_1\">01 Jan 20</p></td>".
						"<td><p id=\"event_1\">PFT</p></td>".
						"<td><p id=\"owner_1\">Name1</p></td>".
						"<td><p id=\"notes_1\">MCRD PFT Start Point at 0545</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.

					$rows.

				"</table>".
				"<br>".
			"</div>"
			
		);

	}

?>
