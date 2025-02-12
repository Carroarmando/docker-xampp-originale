<?php

    $host = 'db';
    $dbname = 'root_db';
    $user = 'user';
    $password = 'user';

    try
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo("connessione effettuata");
    }
    catch (PDOException $e)
    {
        echo "connection error: " . $e->getMessage();
    }
    
?>