<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

$id = $_COOKIE['id'];

$stmt = $conn->prepare('SELECT `messageId` as `id`,`from`,CONCAT(`abbrevRank`, " ", `lastName`) AS `fromName`,`date`,`subject`,`message` FROM `messages` INNER JOIN users ON users.userID = `from` INNER JOIN ranktbl ON `users`.`user_rank` = ranktbl.`rankID` WHERE `to` = ? ORDER BY `messageId` DESC');
$stmt->bind_param("i", $id);

$stmt->execute();
$result = $stmt->get_result();

$results = [];
while($row = $result->fetch_assoc()) {
    $results[] = $row;
}
echo json_encode($results);
