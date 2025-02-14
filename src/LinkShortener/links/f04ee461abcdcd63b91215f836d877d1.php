<?php
    include('../includes/db.php');
    session_start();

    $query = "update links set visite = visite + 1 where original_link = 'adsa';";
    $result = $conn->query($query);

    header("Location: adsa");
    exit;
?>