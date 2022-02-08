<?php 

	include_once("../../Database/config.php");
	include_once("../../Database/selector.php");
	
	function get_previous_terms($userID, &$status){

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
						"<td><p id=\"date_0\">Date</p></td>".
						"<td><p id=\"event_0\">Event</p></td>".
						"<td><p id=\"score_0\">Score</p></td>".
						"<td><p id=\"notes_0\">Notes</p></td>".
					"</tr>".

					"<tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"date_1\">01 Jan 20</p></td>".
						"<td><p id=\"event_1\">PFT</p></td>".
						"<td><p id=\"score_1\">300</p></td>".
						"<td><p id=\"notes_1\">PU 25 / CR 120 / Run 17:45</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.


					"<tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"date_2\">xx xxx xx</p></td>".
						"<td><p id=\"event_2\">x*</p></td>".
						"<td><p id=\"score_2\">x*</p></td>".
						"<td><p id=\"notes_2\">x*</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.

					$rows.

				"</table>".
			"</div>"
		
		);

	}

?>
