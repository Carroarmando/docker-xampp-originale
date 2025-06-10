<?php
session_start();
include_once "includes/db.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: accedi.php");
    exit();
}
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];

unset($_SESSION["game_id"]);
unset($_SESSION["play"]);
unset($_SESSION["opponent_id"]);
$query = "UPDATE users SET available = 0 WHERE user_id = $user_id";
$conn->query($query);
$query = "DELETE from partecipa where user_id = $user_id";
$conn->query($query);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #0d0d0d;
            color: #f0f0f0;
            text-align: center;
            padding: 50px;
        }
        .btn {
            padding: 15px 30px;
            margin: 15px;
            background-color: #e63946;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }
        .btn:hover {
            background-color: #ff4d5a;
        }
        .box {
            background-color: #1a1a1a;
            border-radius: 12px;
            padding: 30px;
            margin-top: 30px;
            display: inline-block;
            max-width: 600px;
        }
    </style>
</head>
<body>

    <h1>Benvenuto, <?= htmlspecialchars($username) ?> 👋</h1>

    <button class="btn" onclick="window.location.href='api/start_new_game.php'">🎮 Inizia una nuova partita</button>
    <button class="btn" onclick="window.location.href='api/logout.php'">🚪 Logout</button>

    <div class="box">
        <h2>Come si gioca?</h2>
        <p>
            Inizi con 1 candela, 3 demoni coperti e 5 anime.<br>
            Acquista ragazzi con 3 anime dal vicinato.<br>
            Scarta 3 ragazzi per evocare un demone.<br>
            Vinci evocando 3 demoni e ottenendo 10 anime! 🔥
        </p>
    </div>

</body>
</html>
