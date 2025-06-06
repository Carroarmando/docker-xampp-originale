<?php
session_start();
header("Content-Type: application/json");
if (isset($_SESSION['user'])) 
{
    $data = $_SESSION["user"];
    jsonResponse(["success" => true, "user" => $data]);
}
else
{
    jsonResponse(["success" => false, "error" => "Sessione non attiva. Effettua il login."], 401);
}
?>