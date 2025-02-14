<?php
    include('../includes/db.php');
    session_start();

    $query = "update links set visite = visite + 1 where original_link = 'https://www.youtube.com/watch?v=V8iis67xpm4';";
    $result = $conn->query($query);

    header("Location: https://www.youtube.com/watch?v=V8iis67xpm4");
    exit;
    
?>