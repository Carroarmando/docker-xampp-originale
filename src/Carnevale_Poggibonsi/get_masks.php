<?php
include("includes/db.php");
session_start();

$query = "select name, count(*) as count, mask_id as count from users natural join masks group by name";
$result = $conn->query($query);

$masks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $masks[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($masks);
?>