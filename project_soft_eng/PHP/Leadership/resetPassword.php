<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

//REF: Validate that user should have access to do this, also should do "the thing" to the password, but problems, like the rest of this
$id = $_REQUEST['id'];
$password = $_REQUEST['password'];

//Create Statements
//This statement makes me really sad, but it wasn't my fault
$filestmt = $conn->prepare('UPDATE `users` SET `password`=? WHERE `userID`=?');
$filestmt->bind_param("si", $password, $id);

$filestmt->execute();

echo json_encode(['result'=>'ok']);
