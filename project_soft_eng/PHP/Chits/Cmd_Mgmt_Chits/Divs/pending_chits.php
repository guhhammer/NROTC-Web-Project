<?php 

	include_once("../../Database/config.php");
	include_once("../../Database/selector.php");
	
	function get_pending_chits($userID, &$status){

		$chitID = [];  $chitType = [];  $routingStatus = [];  $awAction = [];  $lastComment = [];

		//(new Selector())->getValues( [&$chitID, &$chitType, &$routingStatus, &$awAction, &$lastComment], ["", "", "", "", ""], 
		//								"table", [["userID", $userID]], $status );

		$rows = "";
		for($i = 0; $i < sizeof($chitID); $i++){
			$k = $i + 1;
			$rows = $rows.
			   ("<tr>".
					"<td><p id=\"action_".$k."\">".
						"[<button id=\"view_".$k."\" class=\"curr_term_b\">view</button>]".
				    	"/[<button id=\"edit_".$k."\" class=\"curr_term_b\">edit</button>]"."
				    </p></td>".
					"<td><p id=\"chitID_".$k."\">".$chitID[$k]."</p></td>".
					"<td><p id=\"chitType_".$k."\">".$chitType[$k]."</p></td>".
					"<td><p id=\"routingStatus_".$k."\">".$routingStatus[$k]."</p></td>".
					"<td><p id=\"awAction_".$k."\">".$awAction[$k]."</p></td>".
					"<td><p id=\"lastComment_".$k."\">".$lastComment[$k]."</p></td>".
				"</tr>");

		}

		return 
		(

			"<div id=\"pending_chits\">".		
				"<p id=\"title\">Awaiting My Action</p>".
				"<table>".
					"<tr id=\"header\">".
						"<td><p id=\"action_0\">Action</p></td>".
						"<td><p id=\"chitID_0\">Chit ID</p></td>".
						"<td><p id=\"chitType_0\">Chit Type</p></td>".
						"<td><p id=\"routingStatus_0\">Routing Status</p></td>".
						"<td><p id=\"awAction_0\">AW Action By</p></td>".
						"<td><p id=\"lastComment_0\">Last Comment</p></td>".
					"</tr>".
					
					"<tr>".    //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.
						"<td><p id=\"action_1\">".
							"[<button id=\"view_1"."\" class=\"curr_term_b\">view</button>]".
					    	"/[<button id=\"edit_1"."\" class=\"curr_term_b\">edit</button>]"."
					    </p></td>".
						"<td><p id=\"chitID_1\">20SP005</p></td>".
						"<td><p id=\"chitType_1\">Event Absence</p></td>".
						"<td><p id=\"routingStatus_1\">Pending</p></td>".
						"<td><p id=\"awAction_1\">Rank LName</p></td>".
						"<td><p id=\"lastComment_1\">Recommended</p></td>".
					"</tr>".  //EXCLUDE THIS WHEN PHP BRIDGE IS DONE.

					$rows.

				"</table>".
				"<br>".
			"</div>"

		);

	}

?>