<?php

	include_once("../../Database/config.php");
	require_once("../../function_calls.php");

//	echo $userID;
	$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName() );

	$userID = $_COOKIE['id'];
	//$userID = $_POST['id'];
	$output = [];

	//Retrieve all pending chits for the individual user
	$pend_chit_stmt = "SELECT chitID, type, routing_status, nextCoC FROM chit_types, chits, chit_routing_statuses WHERE user = '".$userID."' AND routingStatus = rsID AND routingStatus = 1 AND chitType = typeID";
	
	$count = 0;

	$result1 = $conn->query($pend_chit_stmt);
	if($result1->num_rows > 0){
		$i = 0; $row = [];
		while($row1 = $result1->fetch_assoc()) {

			$last_commentID_stmt = "SELECT MAX(commentID) FROM chit_comments, chits WHERE chitID = ".$row1['chitID'];
			$result2 = $conn->query($last_commentID_stmt);

			if($result2->num_rows > 0){
				$j =0;
				while($row2 = $result2->fetch_assoc()){
					$commID = $row2['MAX(commentID)'];

					$last_comments_stmt = "SELECT com_user, action_title, comments FROM chit_comments, actions WHERE action = actionID AND commentID = ".$commID;

					$result3 = $conn->query($last_comments_stmt);
					if($result3->num_rows > 0){
						$k=0;
						while($row3 = $result3->fetch_assoc()){
							
							$com_user = get_user_rank_name($row3['com_user']);
							$next_user = get_user_rank_name($row1['nextCoC']);
							$row['pi_chitID'] = $row1['chitID'];
							$row['pi_chit_type'] = $row1['type'];
							$row['pi_status'] = $row1['routing_status'];
							$row['pi_next_CoC'] = $next_user;
							$row['pi_comment_by'] = $com_user;
							$row['pi_last_action'] = $row3['action_title'];
							$row['pi_last_comment'] = $row3['comments'];
							
							$output [$count] = $row;
							$count++;
							
							$i++;
							$j++;
							$k++;
						}
					}
				}
			}
		}
	}

//Retrieve all completed chits for the individual user
	$pend_chit_stmt = "SELECT chitID, type, routing_status, nextCoC FROM chit_types, chits, chit_routing_statuses WHERE user = '".$userID."' AND routingStatus = rsID AND routingStatus > 1 AND chitType = typeID";
//	

	$result1 = $conn->query($pend_chit_stmt);
	if($result1->num_rows > 0){
		$i = 0;$row = [];
		while($row1 = $result1->fetch_assoc()) {

			$last_commentID_stmt = "SELECT MAX(commentID) FROM chit_comments, chits WHERE chitID = ".$row1['chitID'];
			$result2 = $conn->query($last_commentID_stmt);

			if($result2->num_rows > 0){
				$j =0;
				while($row2 = $result2->fetch_assoc()){
					$commID = $row2['MAX(commentID)'];

					$last_comments_stmt = "SELECT com_user, action_title, comments FROM chit_comments, actions WHERE action = actionID AND commentID = ".$commID;

					$result3 = $conn->query($last_comments_stmt);
					if($result3->num_rows > 0){
						$k=0;
						while($row3 = $result3->fetch_assoc()){
							
							$com_user = get_user_rank_name($row3['com_user']);
							$next_user = get_user_rank_name($row1['nextCoC']);
							$row['pi_chitID'] = $row1['chitID'];
							$row['pi_chit_type'] = $row1['type'];
							$row['pi_status'] = $row1['routing_status'];
							$row['pi_next_CoC'] = $next_user;
							$row['pi_comment_by'] = $com_user;
							$row['pi_last_action'] = $row3['action_title'];
							$row['pi_last_comment'] = $row3['comments'];
							
							$output [$count] = $row;
							$count++;
							$i++;
							$j++;
							$k++;
						}
					}
				}
			}
		}
	}
	//echo $output;
	echo json_encode($output);
?>