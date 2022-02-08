<?php 

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

$id = $_COOKIE['id'];
function get_completed_chits($userID, &$status) {
	$stmt = $conn->prepare('SELECT DISTINCT chitID, type, routing_status, aw.username, actions.action, c.username, comments, max(commentID) 
			FROM chits, users as u, users as c, users as aw, chit_types, chit_comments, actions, chit_routing_statuses 
			WHERE chitType = typeID 
				AND user = ?
			    AND u.userID = ?
			    AND chit_comments.action = actionID 
			    AND aw.userID = awAction 
			    AND chitID = fk_chitID
			    AND c.userID = com_user 
			    AND routingStatus = rsID 
			    AND last = 1 
			    AND rsID > 1 
			GROUP BY commentID');
	$stmt->bind_param("ii", $id, $id);

	$stmt->execute();
	$result = $stmt->get_result();

	$results = [];
	while($row = $result->fetch_assoc()) {

	    $results[] = $row;
	}

	return $results;
	//echo json_encode($results);
}
?>
<!--/*
include_once("../../Database/config.php");
include_once("../../Database/selector.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());



function get_completed_chits($userID, &$status) {
	$userID = 1;
	//Created sql statement template
	$sql = "SELECT DISTINCT chitID, type, routing_status, aw.username, actions.action, c.username, comments, max(commentID) 
		FROM chits, users as u, users as c, users as aw, chit_types, chit_comments, actions, chit_routing_statuses 
		WHERE chitType = typeID 
			AND user = ?
		    AND u.userID = ?
		    AND chit_comments.action = actionID 
		    AND aw.userID = awAction 
		    AND chitID = fk_chitID
		    AND c.userID = com_user 
		    AND routingStatus = rsID 
		    AND last = 1 
		    AND rsID > 1 
		GROUP BY commentID;";
		
	//Create a prepared statement
	$stmt = mysqli_stmt_init($conn);
	
	//Prepare the prepared statement
	if(!mysqli_stmt_prepare($stmt, $sql)) { }
	else
	{
		mysqli_stmt_prepare($stmt, $sql);

		//Bind parameters to the placeholder
		$stmt->bind_param("ii", $userID, $userID);
		
		//Run parameters inside database
		mysqli_stmt_execute($stmt);
		
		$result = mysqli_stmt_get_result($stmt);

		$i = 0;
		while($row = mysqli_fetch_assoc($result))
		{
			$chitID[$i] = $row['chitID'];
			$chitType[$i] = $row['type'];  
			$routingStatus[$i] = $row['routing_status'];
			$awAction[$i] = $row['aw.username'];
			$lastAction[$i] = $row['actions.action'];
			$lastCommenter[$i] = $row['c.username'];
			$lastComment[$i] = $row['comments'];
			$i++;
		}
	}
	
	$table_str = '<p id=\"title\">Completed Chits</p>
					<table>
						<tr id=\"header\"> 
							<td> <p id=\"chitID_0\">Chit ID</p> </td> 
							<td><p id=\"chitType_0\">Chit Type</p></td>
							<td><p id=\"routingStatus_0\">Routing Status</p></td>
							<td><p id=\"awAction_0\">AW Action By</p></td>
							<td><p id=\"lastAction_0\">Last Action</p></td>
							<td><p id=\"lastComment_0\">Last Comment By</p></td>
							<td><p id=\"lastComment_0\">Last Comment</p></td>
						</tr>';

	for($i = 0; $i < sizeof($chitID); $i++){
		$k = $i + 1;
		$table_str = $table_str.
						"<tr>
							<td><p id=\"chitID_".$k."\">".$chitID[$i]."</p></td>
							<td><p id=\"chitType_".$k."\">".$chitType[$i]."</p></td>
							<td><p id=\"routingStatus_".$k."\">".$routingStatus[$i]."</p></td>
							<td><p id=\"awAction_".$k."\">".$awAction[$i]."</p></td>
							<td><p id=\"lastAction_".$k."\">".$lastAction[$i]."</p></td>
							<td><p id=\"lastCommenter_".$k."\">".$lastCommenter[$i]."</p></td>
							<td><p id=\"lastComment_".$k."\">".$lastComment[$i]."</p></td>
						</tr>";
	}

	$table_str = $table_str.'</table> <br> <br>';


	/*$rows = "";
	for($i = 0; $i < sizeof($chitID); $i++){
		$k = $i + 1;
		$rows = $rows.
		   ("<tr>".
				"<td><p id=\"chitID_".$k."\">".$chitID[$i]."</p></td>".
				"<td><p id=\"chitType_".$k."\">".$chitType[$i]."</p></td>".
				"<td><p id=\"routingStatus_".$k."\">".$routingStatus[$i]."</p></td>".
				"<td><p id=\"awAction_".$k."\">".$awAction[$i]."</p></td>".
				"<td><p id=\"lastAction_".$k."\">".$lastAction[$i]."</p></td>".
				"<td><p id=\"lastCommenter_".$k."\">".$lastCommenter[$i]."</p></td>".
				"<td><p id=\"lastComment_".$k."\">".$lastComment[$i]."</p></td>".
			"</tr>");
	}*/
	return(
		  "<div id=\"completed_chits\">".
/*			 	"<p id=\"title\">Completed Chits</p>".
			 	"<table>".
					"<tr id=\"header\">".
						"<td><p id=\"chitID_0\">Chit ID</p></td>".
						"<td><p id=\"chitType_0\">Chit Type</p></td>".
						"<td><p id=\"routingStatus_0\">Routing Status</p></td>".
						"<td><p id=\"awAction_0\">AW Action By</p></td>".
						"<td><p id=\"lastAction_0\">Last Action</p></td>".
						"<td><p id=\"lastComment_0\">Last Comment By</p></td>".
						"<td><p id=\"lastComment_0\">Last Comment</p></td>".
					"</tr>".
				$rows.
*/			$table_str.
		//	"</table><br><br>".
		"</div>"
	);

		

/*< "<td>".
	<p id=\"action_".$k."\">".
						"[<button id=\"view_".$k."\" class=\"curr_term_b\">view</button>]".
				    	"/[<button id=\"cancel_".$k."\" class=\"curr_term_b\">edit</button>]"."
				    </p></td>".

				    "<td><p id=\"action_0\">Action</p></td>".

-->*/				    

}?>
