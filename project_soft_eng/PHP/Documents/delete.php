<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

//REF: Validate that user should have access to this file
$fileid = $_REQUEST['id'];

//File Statements
$filestmt = $conn->prepare('DELETE FROM documents_files WHERE id=?');
$filestmt->bind_param("i", $fileid);

$filestmt->execute();

echo json_encode(['result'=>'ok']);
