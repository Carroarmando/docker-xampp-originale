<?php

session_start();

// Cambia 'tuapassword' con qualcosa di tuo
$password = "a";

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] !== $password) {
    header('WWW-Authenticate: Basic realm="Area Riservata"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Accesso negato.';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="carica_file.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileDaCaricare">
        <input type="submit" value="Upload">
    </form>

</body>
</html>';
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['fileDaCaricare']) && $_FILES['fileDaCaricare']['error'] === 0) {

        $nomeOriginale = $_FILES['fileDaCaricare']['name'];
        $nomePulito = basename($nomeOriginale); // ⛑️ pulizia
        $pathTemp = $_FILES['fileDaCaricare']['tmp_name'];
        $destinazione = "files/" . $nomePulito;

        if (move_uploaded_file($pathTemp, $destinazione)) {
            header("Location: carica_file.php");
        } else {
            echo "Errore durante lo spostamento del file.";
        }
    } else {
        echo "Errore nell'upload: " . $_FILES['fileDaCaricare']['error'];
    }
}
if (true){
    
}