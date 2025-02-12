<?php

$host = 'db';
$dbname = 'ChatRoom';
$user = 'user';
$password = 'user';
$port = 3306;

// Suggested code may be subject to a license. Learn more: ~LicenseLog:328459787.
$conn = new mysqli($host, $user, $password, $dbname, $port);
    
if($conn->connect_error)
{
    die("connection error: " . $conn->connect_error);
}
