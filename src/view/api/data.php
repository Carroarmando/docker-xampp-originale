<?php
    include("../includes/db.php");
    header('Content-Type: application/json');
    
    $query = "select * from users";
    $result = $conn->query($query);
    
    $data = [];
    
    if ($result->num_rows > 0)
        while ($row = $result->fetch_assoc())
            $data[] = $row;
    
    echo json_encode($data);

?>