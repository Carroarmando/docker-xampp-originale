<?php
include("includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    die("pirla");
} 
elseif ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $code = $_POST["code"];
    $pwd = $_POST["password"];

    if($_POST["action"] == "login")
    {
        $query = "select * from users where codice_fiscale = '$code' and pwd = '$pwd'";
        $result = $conn->query($query);
    
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["code"] = $row["codice_fiscale"];
            header("Location: masks.php");
        }
        else
        {
            die("utente non trovato");
        }
    }
}
?>