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
$room_id = $_SESSION['room_id'];

$invite_link = "https://3000-idx-docker-xampp-1736234929524.cluster-6yqpn75caneccvva7hjo4uejgk.cloudworkstations.dev/ChatRoom/join.php?room_id=" . $room_id;
?>

<html>
    <link rel="stylesheet" type="text/css" href="css/room.css">
<head>
    <title>Chatroom - <?php echo $room_name; ?></title>
    <style>
        /* Stile per il popup */
        .popup {
            display: none; /* Nascosto di default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
        }

        /* Sfondo scuro dietro al popup */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Pulsanti */
        .popup button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Benvenuto su <?php echo $room_name; ?></h1>

    <div id="chat">
    </div>

    <script>
        function aggiornaChat() 
        {
            fetch("get_messages.php")
            .then(response => response.json())
            .then(data =>   {
                                const chat = document.getElementById("chat");
                                chat.innerHTML = ""; // Svuota la chat

                                // Aggiungi ogni messaggio
                                data.forEach(msg => {
                                                        const msgDiv = document.createElement("div");
                                                        msgDiv.innerHTML = `<strong>${msg.username}</strong>: ${msg.message} <small>(${msg.time})</small>`;
                                                        chat.appendChild(msgDiv);
                                                    });
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

    <!-- Bottone per il popup -->
    <button onclick="showPopup()">Crea link di invito</button>

    <!-- Sfondo scuro -->
    <div id="popupOverlay" class="popup-overlay" onclick="hidePopup()"></div>

    <!-- Popup -->
    <div id="popup" class="popup">
        <p>Condividi questo link per invitare qualcuno nella stanza:</p>
        <input type="text" id="inviteLink" readonly value="<?php echo $invite_link; ?>">
        <button onclick="copyLink()">Copia link</button>
        <button onclick="hidePopup()">Chiudi</button>
    </div>

    <script>
        // Mostra il popup
        function showPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popupOverlay').style.display = 'block';
        }

        // Nascondi il popup
        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popupOverlay').style.display = 'none';
        }

        // Copia il link nella clipboard
        function copyLink() {
            const link = document.getElementById('inviteLink');
            link.select();
            link.setSelectionRange(0, 99999); // Per compatibilità con mobile
            document.execCommand('copy');
            alert('Link copiato negli appunti!');
        }
    </script>
</body>
</html>