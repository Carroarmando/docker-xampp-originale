<?php
session_start();
include("includes/db.php");

// Verifica che l'utente sia loggato
if (!isset($_SESSION['user_id'])) 
{
    header("Location: accedi.html");
    exit;
}

// Ottieni il nome utente e le stanze dell'utente
$user_id = $_SESSION['user_id'];
$query = "select rooms.room_id, nome from user_in join rooms on user_in.room_id = rooms.room_id where user_in.user_id = '$user_id'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Chatroom - Home</title>
</head>
<body>
    <h1>Benvenuto, <?php echo $_SESSION['username']; ?></h1>
    <h3>Stanze a cui appartieni:</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="set_room.php?room_id=<?php echo $row['room_id']; ?>"><?php echo $row['nome']; ?></a>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="createRoom.html">Crea una nuova stanza</a>
</body>
</html>
