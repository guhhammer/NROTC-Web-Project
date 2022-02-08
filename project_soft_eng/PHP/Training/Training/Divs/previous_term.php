<?php 

	include_once("../../Database/config.php");
	include_once("../../Database/selector.php");
	
	function get_previous_terms($userID, &$status){

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

			"<div class=\"training-parent\" id=\"prev_terms\">".
				//"<p id=\"title\">Previous Terms</p>".
				"<h1>Previous Terms</h1>".

				"<!--DATE RANGE -->".
				"<label for=\"from_date\">From:</label>".
				"<input type=\"date\" id=\"from_date\" name=\"from_date\">".
				"<label for=\"to_date\">To:</label>".
				"<input type=\"date\" id=\"to_date\" name=\"to_date\"><br><br>".

				"<table>".
					"<tr id=\"header\">".
						"<td><p id=\"permission_0\">Permission</p></td>".
						"<td><p id=\"date_0\">Date</p></td>".
						"<td><p id=\"event_0\">Event</p></td>".
						"<td><p id=\"owner_0\">Event Owner</p></td>".
						"<td><p id=\"notes_0\">Notes</p></td>".
					"</tr>".

					"<tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"permission_1\">[<button id=\"view_1\" class=\"curr_term_b\">view</button>]</p></td>".
						"<td><p id=\"date_1\">01 Jan 20</p></td>".
						"<td><p id=\"event_1\">PFT</p></td>".
						"<td><p id=\"owner_1\">Name1</p></td>".
						"<td><p id=\"notes_1\">MCRD PFT Start Point at 0545</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.


					"<tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"permission_2\">[<button id=\"view_2\" class=\"curr_term_b\">view</button>]</p></td>".
						"<td><p id=\"date_2\">xx xxx xx</p></td>".
						"<td><p id=\"event_2\">x*</p></td>".
						"<td><p id=\"owner_2\">x*</p></td>".
						"<td><p id=\"notes_2\">x*</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.

					$rows.

				"</table>".
			"</div>"
		
		);

	}

?>
