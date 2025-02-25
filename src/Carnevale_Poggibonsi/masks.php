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
        function get_masks() 
        {
            fetch("get_masks.php")
            .then(response => response.json())
            .then(data =>   
            {
                const masks = document.getElementById("masks");
                masks.innerHTML = "";
                
                data.forEach(mask => 
                {
                    const li = document.createElement("li");
                    li.innerHTML = `<a href="set_mask.php?mask_id=${mask.mask_id}">${mask.name}:</a> ${mask.count}`;
                    masks.appendChild(li);
                });
            })
            .catch(err => console.error("Errore:", err));
        }
        
        setInterval(get_masks, 500);
        get_masks();
    </script>
</body>
</html>