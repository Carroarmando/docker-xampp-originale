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
    <title>Carnevale di Poggibonsi - Home</title>
</head>
<body>
    <h1>Accesso effettuato come: <?php echo $_SESSION['code']; ?></h1>
    <h3>Maschere:</h3>

    <ul id="masks"></ul>

    <script>
        let previousData = null; // Variabile per salvare i dati precedenti
        
        function setMask(mask_id) 
        {
            fetch(`set_mask.php?mask_id=${mask_id}`, 
            {
                method: "GET",
            })
            .then(response => response.text())
            .then(data => 
            {
                console.log(data);
            })
            .catch(err => console.error("Errore:", err));
        }

        function get_masks() {
            fetch("get_masks.php")
                .then(response => response.json())
                .then(data => {
                    // Se i dati sono uguali a quelli precedenti, non fare nulla
                    if (JSON.stringify(data) === JSON.stringify(previousData)) {
                        return;
                    }

                    // Salva i nuovi dati
                    previousData = data;

                    const masks = document.getElementById("masks");
                    masks.innerHTML = "";

                    data.forEach(mask => {
                        const li = document.createElement("li");  // Crea l'elemento <li>
                        const link = document.createElement("a");  // Crea l'elemento <a>
                        link.href = "#";

                        let selected = mask.is_selected ? "(tu)" : "";
                        link.textContent = `${mask.name}: ${mask.count} ${selected}`;


                        // Aggiungi un listener di click al link
                        link.addEventListener("click", (event) => {
                            event.preventDefault();
                            setMask(mask.mask_id);
                        });

                        li.appendChild(link);  // Aggiungi il link dentro il <li>
                        masks.appendChild(li);  // Aggiungi il <li> all'ul
                    });
                })
                .catch(err => console.error("Errore:", err));
        }

        setInterval(get_masks, 500);
        get_masks();
    </script>
</body>
</html>