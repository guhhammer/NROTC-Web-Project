<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

$stmt = $conn->prepare('SELECT `userId` as `id`,CONCAT(`abbrevRank`, " ", `lastName`) AS `name` FROM `users` INNER JOIN ranktbl ON `users`.`user_rank` = ranktbl.`rankID` ORDER BY `lastName` DESC');

$stmt->execute();
$result = $stmt->get_result();

$results = [];
while($row = $result->fetch_assoc()) {
    $results[] = $row;
}
echo json_encode($results);
