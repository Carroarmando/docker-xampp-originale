<?php
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];

    $query = "insert into users (nome, cognome, email) values ('$nome', '$cognome', '$email')";
    
    if($conn->query($query))
        echo "success";
    else
        echo "error";
} 

?>