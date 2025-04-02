<?php
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $query = $_POST["query"];
    $result = $conn->query($query);
    
    $data = [];
    
    if ($result->num_rows > 0)
        while ($row = $result->fetch_assoc())
            $data[] = $row;
    
    echo json_encode($data);
} 

?>