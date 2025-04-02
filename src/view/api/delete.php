<?php
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = $_POST["email"];

    $query = "delete from users where email = '$email'";
    
    if($conn->query($query))
        echo "success";
    else
        echo "error";
} 

?>