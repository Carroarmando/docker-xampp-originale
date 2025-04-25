<?php
session_start();
include("includes/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    gare:<br>
    <ul id="lista"></ul><br>
    classifica:<br>
    <ul id="classifica"></ul>

    <script>
        let ID_gara = -1;
        const lista = document.getElementById("lista");
        lista.innerHTML = "";
        data = await fetch("api/gare.php");
        data = await data.json();
        data.forEach(gara => 
        {
            const li = document.createElement("li");
            li.innerHTML = gara.ID_gara;
            li.addEventListener("click", function() 
            {
                cambia_id(this.innerHTML);
            });
            lista.appendChild(li);
        });

        function cambia_id(id) {ID_gara = id}
    </script>
    <script>
        async function aggiorna()
        {
            const classifica = document.getElementById("classifica");
            classifica.innerHTML = "";
            data = await fetch("api/classifica.php?id=" + ID_gara);
            data = await data.json();
            data.forEach(partecipante => 
            {
                const li = document.createElement("li");
                li.innerHTML = partecipante.nome;
                classifica.appendChild(li);
            });
        }

        setInterval(aggiorna, 500);
    </script>
    <?php if($_SESSION["admin"]): ?>
        <form method="post" action="carica_file.php">
            <input type="file" name="file">
            <button type="submit">carica</button>
        </form>
    <?php endif; ?>
</body>
</html>