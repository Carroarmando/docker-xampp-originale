<?php
session_start();
require_once("db/db.php");
require_once("json_response.php");
header('Content-Type: application/json; charset=utf-8');

// controllo autenticazione
if (empty($_SESSION['user'])) {
    jsonResponse(['success'=>false,'error'=>'Utente non autenticato'],401);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    jsonResponse(["success" => false, "error" => "Metodo non supportato. Metodi supportati: GET"], 405);
    exit;
}

$type = strtolower($_GET["type"] ?? '');
if (!$type) {
    jsonResponse(["success" => false, "error" => "Parametro 'type' mancante"], 400);
    exit;
}

$deck_id = $_SESSION['user']['deck_id'] ?? null;
if (!$deck_id) {
    jsonResponse(["success" => false, "error" => "Nessun mazzo selezionato"], 400);
    exit;
}

switch ($type) {
    case 'os':
        $sql = "SELECT o.OS_id AS card_id, o.name AS name, 'os' AS type
                FROM OS_in oi
                JOIN OS o ON oi.OS_id = o.OS_id
                WHERE oi.deck_id = ?
        ";
        break;
    case 'characters':
        $sql = "SELECT c.character_id AS card_id, c.name AS name, 'character' AS type
                FROM character_in ci
                JOIN characters c ON ci.character_id = c.character_id
                WHERE ci.deck_id = ?
        ";
        break;
    case 'scripts':
        $sql = "SELECT s.script_id AS card_id, s.name AS name, 'script' AS type
                FROM script_in si
                JOIN scripts s ON si.script_id = s.script_id
                WHERE si.deck_id = ?
        ";
        break;
    case 'libraries':
        $sql = "SELECT l.library_id AS card_id, l.name AS name, 'library' AS type
                FROM library_in li
                JOIN libraries l ON li.library_id = l.library_id
                WHERE li.deck_id = ?
        ";
        break;
    default:
        jsonResponse(["success" => false, "error" => "Tipo di mazzo non valido"], 422);
        exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $deck_id);
$stmt->execute();
$result = $stmt->get_result();

$cards = [];
while ($row = $result->fetch_assoc()) {
    $cards[] = $row;
}

jsonResponse(["success" => true, "data" => $cards]);
exit;

// torna array con i campi: card_id, name, type
?>
