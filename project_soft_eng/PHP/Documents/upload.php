<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

//REF: Validate that user should have access to this folder
$name = $_POST['name'];
//REF: Server should set correct timezone probably
$date = date('Y-m-d H:i:s');

//Decode DataURI string
$data = $_POST['data'];
$data = str_replace(' ', '+', $data);
$data = substr($data, strpos($data, ',') + 1);
$data = base64_decode($data);

$folder = $_POST['folder'];
$uploadedby = $_COOKIE['id'];// oh my...

//Create File Statements
$filestmt = $conn->prepare('INSERT INTO documents_files (`name`,`date`,`data`,`folder`,`uploadedby`) VALUES (?, ?, ?, ?, ?)');
$filestmt->bind_param("sssii", $name, $date, $data, $folder, $uploadedby);

$filestmt->execute();

echo json_encode(['result'=>'ok']);
