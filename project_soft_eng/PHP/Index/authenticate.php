<?php 
	
	include("../Database/config.php");

	$username = $_POST["username"];
	$password = $_POST["password"];

	$authentication['connection'] = "not ok";
	$authentication['username_found'] = "not ok";
	$authentication['match'] = "not ok";
	$authentication['id'] = "";

	$connection = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

	if (!$connection) { } // Connection not established.
	else{

		$authentication['connection'] = "ok";

		$sql = "SELECT userID, password FROM users WHERE username='$username'";
		
		$result = $connection->query($sql);

		if ($result->num_rows > 0) {
			
			$authentication['username_found'] = "ok";
		    
		    while($row = $result->fetch_assoc()) {
			    
			    if($row["password"] === $password){
			    	$authentication['match'] = "ok";
			    	$authentication['id'] = $row["userID"]."";
			    	break;
			    }

			}

		} 

		$connection->close();

	}

	echo json_encode($authentication);

?>