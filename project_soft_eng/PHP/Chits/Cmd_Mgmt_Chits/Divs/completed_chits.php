<?php 


	include_once("../../Database/config.php");
	include_once("../../Database/selector.php");
	
	function get_completed_chits($userID, &$status){

		$chitID = [];  $originator = [];  $aid = [];  $chitType = [];  $event = [];  $begin = [];  $end = [];

		//(new Selector())->getValues( [&$chitID, &$originator, &$aid, &$chitType, &$event, &$begin, &$end], ["", "", "", "", "", "", ""], 
		//								"table", [["userID", $userID]], $status );

		$rows = "";
		for($i = 0; $i < sizeof($chitID); $i++){
			$k = $i + 1;
			$rows = $rows.
			   ("<tr>".
					"<td><p id=\"action_".$k."\">"."[<button id=\"view_".$k."\" class=\"curr_term_b\">view</button>]"."</p></td>".
					"<td><p id=\"chitID_".$k."\">".$chitID[$k]."</p></td>".
					"<td><p id=\"originator_".$k."\">".$originator[$k]."</p></td>".
					"<td><p id=\"aid_".$k."\">".$aid[$k]."</p></td>".
					"<td><p id=\"chitType_".$k."\">".$chitType[$k]."</p></td>".
					"<td><p id=\"event_".$k."\">".$event[$k]."</p></td>".
					"<td><p id=\"begin_".$k."\">".$begin[$k]."</p></td>".
					"<td><p id=\"end_".$k."\">".$end[$k]."</p></td>".
				"</tr>");

		}
				
		return 
		(

			"<div id=\"completed_chits\">".		
				"<p id=\"title\">Active Subordinate Chits</p>".
				"<table>".
					"<tr id=\"header\">".
						"<td><p id=\"action_0\">Action</p></td>".
						"<td><p id=\"chitID_0\">Chit ID</p></td>".
						"<td><p id=\"originator_0\">Originator</p></td>".
						"<td><p id=\"aid_0\">AID</p></td>".
						"<td><p id=\"chitType_0\">Chit Type</p></td>".
						"<td><p id=\"event_0\">Event</p></td>".
						"<td><p id=\"begin_0\">Begin</p></td>".
						"<td><p id=\"end_0\">End</p></td>".
					"</tr>".
					
					"<tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"action_1\">"."[<button id=\"view_1"."\" class=\"curr_term_b\">view</button>]"."</p></td>".
						"<td><p id=\"chitID_1\">20SP003</p></td>".
						"<td><p id=\"originator_1\">Rank LName</p></td>".
						"<td><p id=\"aid_1\">A00</p></td>".
						"<td><p id=\"chitType_1\">Miss PT</p></td>".
						"<td><p id=\"event_1\">PT</p></td>".
						"<td><p id=\"begin_1\">0545 08 Mar 20</p></td>".
						"<td><p id=\"end_1\">0700 08 Mar 20</p></td>".
					"</tr>".   //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.

					"<tr>".     //EXCLUDE THIS WHEN PHP BRIDGE IS DONE
						"<td><p id=\"action_2\">"."[<button id=\"view_1"."\" class=\"curr_term_b\">view</button>]"."</p></td>".
						"<td><p id=\"chitID_2\">20SP005</p></td>".
						"<td><p id=\"originator_2\">Rank LName</p></td>".
						"<td><p id=\"aid_2\">B12</p></td>".
						"<td><p id=\"chitType_2\">Leave of Absence</p></td>".
						"<td><p id=\"event_2\">N/A</p></td>".
						"<td><p id=\"begin_2\">0800 08 Mar 20</p></td>".
						"<td><p id=\"end_2\">0700 12 Mar 20</p></td>".
					"</tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE

					$rows.

				"</table>".
			"</div>"

		);

	}

?>