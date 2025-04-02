<?php
session_start();
include("includes/db.php");

// Verifica che l'utente sia loggato
if (!isset($_SESSION['user_id'])) 
{
    header("Location: accedi.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>LinkShortener - Home</title>
    <link rel="stylesheet" href="css/links.css">
</head>

<body>
    <h1>Benvenuto, <?php echo $_SESSION['username']; ?></h1>
    <h3>I tuoi link:</h3>
    <div class="container">
        <div id="original_links" class="column"></div>
        <div id="shorted_links" class="column"></div>
    </div>


    <script>
        let previousData = null; // Variabile per salvare i dati precedenti

        function aggiornaLink() 
        {
            fetch("get_links.php")
                .then(response => response.json())
                .then(data => 
                {
                    // Se i dati sono uguali a quelli precedenti, non fare nulla
                    if (JSON.stringify(data) === JSON.stringify(previousData)) 
                    {
                        return;
                    }

                    // Salva i nuovi dati
                    previousData = data;

                    // Aggiorna la pagina solo se i dati sono cambiati
                    const original_links = document.getElementById("original_links");
                    original_links.innerHTML = "";

                    const shorted_links = document.getElementById("shorted_links");
                    shorted_links.innerHTML = "";

                    data.forEach(link => 
                    {
                        const original_link_Div = document.createElement("div");
                        original_link_Div.textContent = link.original_link;
                        original_links.appendChild(original_link_Div);

                        const shorted_link_Div = document.createElement("div");
                        shorted_link_Div.textContent = link.shorted_link;
                        shorted_links.appendChild(shorted_link_Div);
                    });
                })
                .catch(err => console.error("Errore:", err));
        }

        setInterval(aggiornaLink, 500);
        aggiornaLink();

    </script>

<br><br>
    <form id="new_link_form" method="post" action="short_link.php">
        <input id="link" type="text" name="link" placeholder="Metti qui il link" required>
        <button type="submit">Invia</button>
    </form>
    
    <script>
        const form = document.getElementById("new_link_form");

        form.addEventListener("submit", function(event) 
        {
            event.preventDefault();

            fetch("short_link.php", {
                                        method: "POST",
                                        body: new FormData(form),
                                      })
            .then(response => response.text())
            .then(data =>   {
                                console.log(data);
                                document.getElementById("link").value = "";
                            })
            .catch(err => console.error("Errore:", err));
        });
    </script>
</html>