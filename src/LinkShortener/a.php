<?php
    include('../includes/db.php');
    session_start();

    $query = "update links set visite = visite + 1 where original_link = '$link';"
    $result = $conn->query($query);

    header("Location: $link");
    exit;
    
?>