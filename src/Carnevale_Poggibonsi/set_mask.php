<?php
include("includes/db.php");
session_start();

// Verifica che l'utente sia loggato e che il nome della stanza sia impostato
if (!isset($_SESSION['user_id'])) 
{
    header("Location: accedi.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    $user_id = $_SESSION["user_id"];
    $mask_id = $_GET["mask_id"];

    $query = "select count(*) as count from users where mask_id = $mask_id";
    $result = $conn->query($query);

    if($result->fetch_assoc()["count"] < 50)
    {
        $query = "update users set mask_id = $mask_id where user_id = $user_id";
        $result = $conn->query($query);
    }
    
    header("Location: masks.php");
} 

?>