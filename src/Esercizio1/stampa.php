<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nome = $_POST['fname'];
    $cognome = $_POST['lname'];
    $username = $_POST['uname'];
    $email = $_POST['mail'];
    $residenza = $_POST['residenza'];
    $genere = $_POST['genere'];

    echo $nome . "<br>"; 
    echo $cognome . "<br>"; 
    echo $username . "<br>";
    echo $email . "<br>";
    echo $residenza . "<br>";
    echo $genere . "<br>";
}
