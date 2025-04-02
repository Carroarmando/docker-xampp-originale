<?php
    session_start();

    if (!isset($_SESSION["i"]))
        $_SESSION["i"] = 0;
    else
        $_SESSION["i"]++;

    echo $_SESSION["i"]; // Stampa il valore
?>

<!-- Dopo 2 secondi, reindirizza con JavaScript -->
<script>
    setTimeout(() => {
        window.location.href = "header.php";
    }, 1000);
</script>