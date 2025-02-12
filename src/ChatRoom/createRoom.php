<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) 
{
    header("Location: accedi.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['room_name']) 
{
    $user_id = $_SESSION['user_id'];
    $room_name = $_POST['room_name'];
    
    $query = "select room_id from rooms order by room_id asc";
    $result = $conn->query($query);

    $room_ids = [];
    while ($row = $result->fetch_assoc()) 
        $room_ids[] = $row['room_id'];
    
    $primoLibero = 1;
    foreach ($room_ids as $room_id) 
    {
        if ($room_id != $primoLibero) 
            break;
        $primoLibero++;
    }

    $room_id = $primoLibero;
    
    $query = "insert into rooms (nome, user_id, room_id) values ('$room_name', $user_id, $room_id)";
    $result = $conn->query($query);
    
    if ($result) 
    {
        $query = "insert into user_in (user_id, room_id) values ($user_id, $room_id)";
        ob_start();
        if ($conn->query($query)) {
            echo "Inserimento in user_in avvenuto con successo! $user_id, $room_id";
        } else {
            echo "Errore nell'inserimento in user_in: " . $conn->error;
        }
        header("Location: rooms.php");
        ob_end_flush();
        exit;
    } 
    else 
    {
        echo "Errore nell'inserimento in user_in: " . $conn->error;
    }
}
?>