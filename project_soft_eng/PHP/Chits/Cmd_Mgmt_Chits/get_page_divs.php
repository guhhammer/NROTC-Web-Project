<?php

	include("../../Database/config.php");
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

	$userID = $_POST['id'];
	$id = $_COOKIE['id'];
	$divs['confirm'] = "not ok";  
	$divs['all'] = ""; 
	$divs['pending_chits'] = ""; 
	$divs['completed_chits'] = "";

	//CHITS AW My Action	
	//todo: add links to edit and view
	$stmt = 'SELECT DISTINCT chitID, type, routing_status, aw.username as awUser, actions.action, c.username as cUser, comments, max(commentID) 
			FROM chits, users as u, users as c, users as aw, chit_types, chit_comments, actions, chit_routing_statuses 
			WHERE chitType = typeID
			    AND chit_comments.action = actionID 
			    AND aw.userID = '.$id.' 
			    AND chitID = fk_chitID
			    AND c.userID = com_user 
			    AND routingStatus = rsID 
			    AND last = 1 
			    AND rsID = 1 
			GROUP BY commentID';

	$result = $conn->query($stmt);
	
	$rows = "";
	$rows = $rows."<h1>Chits Awaiting My Action</h1><table><tr><th>Action</th><th>Chit ID</th><th>Chit Type</th><th>Status</th><th>AW Action By</th><th>Last Action</th><th>Last Action By</th><th>Last Comment</th></tr>";

	while(($row = $result->fetch_assoc() )!= null ) {
		$rows = $rows. "<tr>
			<td>insert action links here</td>
			<td>". $row['chitID']."</td>
			<td>". $row['type']."</td>
			<td>". $row['routing_status']."</td>
			<td>". $row['awUser']."</td>
			<td>". $row['action']."</td>
			<td>". $row['cUser']."</td>
			<td>". $row['comments']."</td>
			</tr>";
	}

	$rows = $rows."</table>";
	$divs["pending_chits"] = $rows;

	//Subordinate Chits  
	//todo: add links to view
	$stmt = 'SELECT DISTINCT chitID, type, routing_status, aw.username as awUser, actions.action, c.username as cUser, comments, max(commentID) 
			FROM chits, users as u, users as c, users as aw, chit_types, chit_comments, actions, chit_routing_statuses 
			WHERE chitType = typeID
			    AND chit_comments.action = actionID 
			    AND aw.userID = '.$id.' 
			    AND chitID = fk_chitID
			    AND c.userID = com_user 
			    AND routingStatus = rsID 
			    AND last = 1 
			    AND rsID > 1 
			GROUP BY commentID';

	$result = $conn->query($stmt);
	
	$rows = "";
	$rows = $rows."<h1>Completed Chits Under My Command</h1><table><tr><th>Action</th><th>Chit ID</th><th>Chit Type</th><th>Status</th><th>AW Action By</th><th>Last Action</th><th>Last Action By</th><th>Last Comment</th></tr>";

	while(($row = $result->fetch_assoc() )!= null ) {
		$rows = $rows. "<tr>
			<td>insert action links here</td><td>". $row["chitID"]."</td><td>". $row["type"]."</td><td>". $row["routing_status"]."</td><td>". $row["awUser"]."</td><td>". $row["action"]."</td><td>". $row["cUser"]."</td><td>". $row["comments"]."</td></tr>";
	}

	$rows = $rows."</table>";
	$divs["completed_chits"] = $rows;
	
	$divs["all"] = $divs["pending_chits"].$divs["completed_chits"];

	$conn->close();
	$divs["confirm"] = "ok";
	echo json_encode($divs);

?>
