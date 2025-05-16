<?php
session_start();
include("includes/db.php");

// Verifica che l'utente sia loggato e che il nome della stanza sia impostato
if (!isset($_SESSION['user_id']) || !isset($_SESSION['room_name'])) 
{
    header("Location: accedi.html");
    exit;
}

$room_name = $_SESSION['room_name'];
?>

<html>
    <link rel="stylesheet" type="text/css" href="css/room.css">
<head>
    <title>Chatroom - <?php echo $room_name; ?></title>
</head>

<body>
    <h1>Benvenuto su <?php echo $room_name; ?></h1>

    <div id="chat"></div>

    <script>
        let old_data = "";
        function aggiornaChat() 
        {
            fetch("get_messages.php")
            .then(response => response.json())
            .then(data =>   
            {
                if (JSON.stringify(old_data) != JSON.stringify(data))
                {
                    old_data = data;

                    const chat = document.getElementById("chat");
                    chat.innerHTML = ""; // Svuota la chat

                    // Aggiungi ogni messaggio
                    data.forEach(msg => 
                    {
                        const msgDiv = document.createElement("div");
                        msgDiv.innerHTML = `<strong>${msg.username}</strong>: ${msg.message} <small>(${msg.time})</small>`;
                        chat.appendChild(msgDiv);
                    });
                }
            })
            .catch(err => console.error("Errore:", err));
        }
        
        setInterval(aggiornaChat, 500);
        aggiornaChat();
    </script>
<br>
    <form id="sendMessageForm" method="post" action="send_message.php">
        <input id="message" type="text" name="message" placeholder="Scrivi un messaggio..." required>
        <button type="submit">Invia</button>
    </form>
    
    <script>
        const form = document.getElementById("sendMessageForm");

        form.addEventListener("submit", function(event) 
        {
            event.preventDefault();

            fetch("send_message.php", {
                                        method: "POST",
                                        body: new FormData(form),
                                      })
            .then(response => response.text())
            .then(data =>   {
                                console.log(data);
                                document.getElementById("message").value = "";
                            })
            .catch(err => console.error("Errore:", err));
        });
    </script>
</body>
</html>