<?php
require_once "admin_connect.php";

$sql = "SELECT id, title, start_date AS start, end_date AS end FROM events";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>
