<?php 

	include_once("../../Database/config.php");
	include_once("../../Database/selector.php");
	
	function get_current_term($userID, &$status){

		$date = [];  $event = [];  $score = [];  $notes = [];

		//(new Selector())->getValues( [&$date, &$event, &$score, &$notes], ["", "", "", ""], "table", [["userID", $userID]], $status );
		
		$rows = "";
		for($i = 0; $i < sizeof($date); $i++){
			$k = $i + 1;
			$rows = $rows.
			   ("<tr>".
					"<td><p id=\"date_".$k."\">".$date[$k]."</p></td>".
					"<td><p id=\"event_".$k."\">".$event[$k]."</p></td>".
					"<td><p id=\"score_".$k."\">".$score[$k]."</p></td>".
					"<td><p id=\"notes_".$k."\">".$notes[$k]."</p></td>".
				"</tr>");
		}

		return
		(

			"<div class=\"training-parent\"id=\"curr_term\">".		
				//"<p id=\"title\">Current Term</p>".
				"<h1>Current Term</h1>".
				"<table>".
					"<tr id=\"header\">".
						"<td><p id=\"date_0\">Date</p></td>".
						"<td><p id=\"event_0\">Event</p></td>".
						"<td><p id=\"score_0\">Score</p></td>".
						"<td><p id=\"notes_0\">Notes</p></td>".
					"</tr>".

					"<tr>".//EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"date_1\">01 Jan 20</p></td>".
						"<td><p id=\"event_1\">PFT</p></td>".
						"<td><p id=\"score_1\">300</p></td>".
						"<td><p id=\"notes_1\">PU 25 / CR 120 / Run 17:45</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.

					$rows.

				"</table>".
				"<br>".
			"</div>"
			
		);

	}

?>
