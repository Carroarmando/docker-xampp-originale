<?php
session_start();
require_once("db/db.php");
require_once("json_response.php");
header('Content-Type: application/json; charset=utf-8');

// Salva un singolo tipo di carte nel mazzo
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse(["success" => false, "error" => "Metodo non supportato. Metodi supportati: POST"], 405);
    exit;
}

// Autenticazione e recupero deck_id
if (empty($_SESSION['user']['deck_id'])) {
    jsonResponse(["success" => false, "error" => "Deck non trovato in sessione"], 400);
    exit;
}
$deck_id = $_SESSION['user']['deck_id'];

// Decodifica JSON
$body = json_decode(file_get_contents('php://input'), true);
$type = strtolower($body['type'] ?? '');
$cards = $body['cards'] ?? null;

if (!$type || !is_array($cards)) {
    jsonResponse(["success" => false, "error" => "Parametri 'type' o 'cards' mancanti o non validi"], 400);
    exit;
}

// Mappa tipo a tabella e colonna PK
$map = [
    'os'        => ['table' => 'OS_in',        'col' => 'OS_id'],
    'characters' => ['table' => 'character_in', 'col' => 'character_id'],
    'scripts'    => ['table' => 'script_in',    'col' => 'script_id'],
    'libraries'   => ['table' => 'library_in',   'col' => 'library_id'],
];

if (!isset($map[$type])) {
    jsonResponse(["success" => false, "error" => "Tipo di mazzo non valido"], 422);
    exit;
}
$table = $map[$type]['table']; $col = $map[$type]['col'];

// Elimina vecchie associazioni per questo tipo
$stmt = $conn->prepare("DELETE FROM `$table` WHERE deck_id = ?");
$stmt->bind_param("i", $deck_id);
if (!$stmt->execute()) {
    jsonResponse(["success" => false, "error" => "Errore eliminazione vecchie carte"], 500);
    exit;
}

// Prepara INSERT
$sql = "INSERT INTO `$table` (deck_id, $col) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    jsonResponse(["success" => false, "error" => "Errore preparazione query"], 500);
    exit;
}

// Inserisci nuove carte
foreach ($cards as $card_id) {
    if (!is_int($card_id)) continue; // salta valori non validi
    $stmt->bind_param("ii", $deck_id, $card_id);
    if (!$stmt->execute()) {
        jsonResponse(["success" => false, "error" => "Errore durante il salvataggio del deck"], 500);
        exit;
    }
}

jsonResponse(["success" => true]);
exit;
?>
