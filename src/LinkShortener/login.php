<?php
include("includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    die("pirla");
} 
elseif ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST["email"];
    $pw = $_POST["password"];

    if($_POST["action"] == "login")
    {
        $query = "select * from login where email = '$email' and pwd = '$pw'";
        $result = $conn->query($query);
    
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            
            $query = "select * from users where email = '$email'";
            $result = $conn->query($query);
            
            if($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $email;
                header("Location: links.php");
            }
        }
        else
        {
            die("utente non trovato");
        }

    }
    else if ($_POST["action"] == "register")
    {
        $query = "insert into login (email, pwd) values ('$email', '$pw')";
        $result = $conn->query($query);
        if($result)
        {
            $username = $_POST['username'];
            $query = "insert into users (email, username) values ('$email', '$username')";
            $result = $conn->query($query);
        
            if(!$result)
            {
                $query = "delete from login where email = '$email'";
                $result = $conn->query($query);
                die("errore");
            }
            else
            {
                header("Location: accedi.html");
            }
        }
        else
            die("errore");
    }
}
?>