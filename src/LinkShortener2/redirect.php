<?php
    include('includes/db.php');
    session_start();
    
    $l = $_GET["l"];

    $query = "update links set visite = visite + 1 where link_id = $l";
    $result = $conn->query($query);

    $query = "select original_link from links where link_id = $l;";
    $result = $conn->query($query);
    if($result)
    {
        $original_link = ($row = $result->fetch_assoc()) ? $row['original_link'] : false;
        if($original_link)
            header("Location: $original_link");
        echo "link non trovato";
    }    
?>