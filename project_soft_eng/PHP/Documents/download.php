<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

//REF: Validate that user should have access to this file
$fileid = $_REQUEST['id'];

//File Statements
$filestmt = $conn->prepare('SELECT `data`,`name` FROM documents_files WHERE id=?');
$filestmt->bind_param("i", $fileid);

$filestmt->execute();
$result = $filestmt->get_result();

while($row = $result->fetch_assoc()) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $row['name'] . '"'); 
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');

    echo $row['data'];
    die;
}

echo 'You do not have access to this';
