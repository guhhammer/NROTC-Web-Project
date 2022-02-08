<?php 


/*

	THIS PHP WILL BE REMOVED AT THE FINAL VERSION.

*/
	
/*
Main Site - https://arcanist.games/

PhpMyAdmin - https://phpmyadmin.arcanist.games/

Jenkins - https://jenkins.arcanist.games/

MysqlHost: arcanist.games
Username: monty
Password: navy84576!
Database: navy
*/


/*
$head = "<html><head> </head> <body>";
$end = "</body></html>";


$servername = "phpmyadmin.arcanist.games";

$username = "monty";
$password = "navy84576!";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
// Check connection
if (!$conn) {
    die($head."Connection failed: " . mysqli_connect_error().$end);
}

echo $head."Connected successfully".$end;
*/




	include_once("Database/config.php");
	include_once("Database/selector.php");


	$selector = new Selector();


	$ok = "";
	//$selector->setValues("users", ["username"], ["not_jon"], [["userID", "2"]], $ok);

	$l = $selector->getValues([], "*", "users", [["userID", "2"]], $ok);


	foreach ($l as $ll) {
		echo $ll."  ";
	}

	echo $ok;


?>