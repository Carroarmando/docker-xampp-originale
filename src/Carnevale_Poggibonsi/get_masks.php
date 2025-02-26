<?php
include("includes/db.php");
session_start();

$query = "  SELECT masks.mask_id, masks.name, COUNT(users.user_id) AS count 
            FROM masks 
            LEFT JOIN users ON masks.mask_id = users.mask_id 
            GROUP BY masks.mask_id, masks.name";

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