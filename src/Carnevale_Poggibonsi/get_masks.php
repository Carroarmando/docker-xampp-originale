<?php
include("includes/db.php");
session_start();

// Verifica che l'utente sia loggato
if (!isset($_SESSION['user_id'])) {
    die("Errore: nessun utente loggato");
}

$user_id = $_SESSION['user_id'];

// Recupera la maschera selezionata dall'utente
$query = "SELECT mask_id FROM users WHERE user_id = $user_id";
$result = $conn->query($query);
$user_mask_id = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_mask_id = $row['mask_id'];
}

$query = "  SELECT masks.mask_id, masks.name, COUNT(users.user_id) AS count 
            FROM masks 
            LEFT JOIN users ON masks.mask_id = users.mask_id 
            GROUP BY masks.mask_id, masks.name";
$result = $conn->query($query);

$masks = [];

while ($row = $result->fetch_assoc()) {
    $row['is_selected'] = ($row['mask_id'] == $user_mask_id);  // Aggiungi un campo per sapere se è la maschera scelta
    $masks[] = $row;
}

header('Content-Type: application/json');
echo json_encode($masks);
?>
