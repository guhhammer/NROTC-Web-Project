<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

$from = $_COOKIE['id'];
$to = $_POST['to'];
$date = date('Y-m-d H:i:s');
$subject = $_POST['subject'];
$message = $_POST['message'];

$stmt = $conn->prepare('INSERT INTO `messages` (`from`, `to`, `date`, `subject`, `message`) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param("iisss", $from, $to, $date, $subject, $message);

$stmt->execute();

echo json_encode(['result'=>'ok']);
