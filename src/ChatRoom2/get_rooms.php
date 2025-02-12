<?php
include("includes/db.php");
session_start();

$query = "select * from rooms";
$result = $conn->query($query);

$rooms = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($rooms);
?>