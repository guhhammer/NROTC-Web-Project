<?php

include("../Database/config.php");
$conn = new mysqli(getDatabaseServerAddress(), getDatabaseUsername(), getDatabasePassword(), getDatabaseName());

//REF: Validate Logged in user

//Query for events in specified range
$start = explode('T', $_GET['start'])[0];
$end = explode('T', $_GET['end'])[0];

$stmt = $conn->prepare('SELECT `eventTitle` as `title`,`eventDate` as `start`,`eventDate` as `end` FROM events WHERE `eventDate` >= ? AND `eventDate` <= ?');
$stmt->bind_param("ss", $start, $end);

$stmt->execute();
$result = $stmt->get_result();

$results = [];
while($row = $result->fetch_assoc()) {
    $results[] = $row;
}
echo json_encode($results);
