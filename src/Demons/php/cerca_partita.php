<?php
session_start();
require 'includes/db.php'; // connessione $conn

if (!isset($_SESSION['user_id'])) {
    header("Location: accedi.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Setta l’utente come disponibile
if(!$_SESSION["play"])
{
    $conn->query("UPDATE users SET available = 1 WHERE user_id = $user_id");
    $_SESSION["play"] = true;
}
else
{
    $query = "SELECT available FROM users WHERE user_id = $user_id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    if ($row && $row["available"] == 0)
    {
        $query = "SELECT game_id from partecipa where user_id = $user_id";
        $game_id = $conn->query($query)->fetch_assoc()["game_id"];
        $_SESSION["game_id"] = $game_id;
        while (true)
        {
            $query = "SELECT user_id from partecipa where game_id = $game_id and user_id != $user_id";
            $result = $conn->query($query);
            if($row = $result->fetch_assoc())
            {
                $_SESSION["opponent_id"] = $row["user_id"];
                break;
            }
            sleep(1);
        }
        header("Location: game.php");
        exit();
    }
}

// 2. Cerca un altro utente disponibile (diverso da te)
$query = "SELECT user_id FROM users WHERE available = 1 AND user_id != $user_id LIMIT 1";
$result = $conn->query($query);

if ($row = $result->fetch_assoc()) 
{
    $opponent_id = $row['user_id'];

    // 3. Aggiorna entrambi a non disponibili
    $conn->query("UPDATE users SET available = 0 WHERE user_id IN ($user_id, $opponent_id)");

    // 4. Crea la partita
    $conn->query("INSERT INTO games () VALUES ()");
    $game_id = $conn->insert_id;

    $query = "INSERT into partecipa (game_id, user_id) values ($game_id, $user_id), ($game_id, $opponent_id)";
    $conn->query($query);
} 

// Nessun avversario trovato, rimani qui e fai refresh ogni 5s
echo "In attesa di un avversario...";
echo '<script>setTimeout(() => location.reload(), 1000);</script>';