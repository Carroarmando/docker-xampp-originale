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
$query = "select username from users where user_id = $user_id";
$result = $conn->query($query);
$username = $result->fetch_assoc()['username'];
$query = "select * from rooms";
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

    <ul id="rooms"></ul>

    <script>
    function get_rooms() 
    {
        fetch("get_rooms.php")
        .then(response => response.json())
        .then(data =>   
        {
            const rooms = document.getElementById("rooms");
            rooms.innerHTML = "";
            
            data.forEach(room => 
            {
                const li = document.createElement("li");
                li.innerHTML = `<a href="set_room.php?room_id=${room.room_id}">${room.nome}</a>`;
                rooms.appendChild(li);
            });
        })
        .catch(err => console.error("Errore:", err));
    }
    
    setInterval(get_rooms, 500);
    get_rooms();
</script>

    <a href="createRoom.html">Crea una nuova stanza</a>
</body>
</html>