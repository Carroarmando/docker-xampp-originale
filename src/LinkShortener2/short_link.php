<?php
include("includes/db.php");
session_start();

if (!isset($_SESSION['user_id'])) 
{
    header("Location: accedi.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $user_id = $_SESSION["user_id"];
    $link = $_POST["link"];

    $query = "insert into links (original_link, user_id) values ('$link', $user_id)";
    $result = $conn->query($query);
    $link_id = $mysqli->insert_id;
    
    $shorted_link = "https://3000-idx-docker-xampp-1736234929524.cluster-6yqpn75caneccvva7hjo4uejgk.cloudworkstations.dev/LinkShortener2/redirect.php?l=$link_id";
    
    if($result)
        echo "success";
    else
        echo "error";
} 

?>