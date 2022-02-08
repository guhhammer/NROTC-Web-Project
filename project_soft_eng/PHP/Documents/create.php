<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

//REF: Validate that user should have access to this folder
$name = $_REQUEST['name'];
$parent = $_REQUEST['parent'];

//Create Folder Statements
$filestmt = $conn->prepare('INSERT INTO documents_folders (`name`,`parent`) VALUES (?, ?)');
$filestmt->bind_param("si", $name, $parent);

$filestmt->execute();

echo json_encode(['result'=>'ok']);
