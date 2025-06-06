<?php
session_start();
require_once("db/db.php");
require_once("json_response.php");
header('Content-Type: application/json; charset=utf-8');

// 1) Solo GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    jsonResponse(
        ["success" => false, "error" => "Metodo non supportato. Metodi supportati: GET"],
        405
    );
    exit;
}

// 2) Leggi e normalizza type (se presente)
$type = strtolower($_GET['type'] ?? '');

// 3) Prepara la query in base al tipo
switch ($type) {
    case 'os': // card_id card_name open_source type
        $sql = "SELECT 
                os.OS_id    AS card_id,
                os.name     AS card_name,
                os.open_source,
                'OS'        AS type
                FROM OS os
        ";
        break;

    case 'characters': // card_id card_name power type
        $sql = "SELECT 
                c.character_id AS card_id,
                c.name         AS card_name,
                c.power        AS power,
                'character'    AS type
                FROM characters c
        ";
        break;

    case 'scripts': // card_id card_name power library_id language_name type
        $sql = "SELECT 
                s.script_id     AS card_id,
                s.name          AS card_name,
                s.power         AS power,
                s.library_id    AS library_id,
                s.language_name AS language_name,
                'script'        AS type
                FROM scripts s
        ";
        break;

    case 'libraries': // card_id card_name language_name type
        $sql = "SELECT 
                l.library_id AS card_id,
                l.name       AS card_name,
                l.language_name,
                'library'    AS type
                FROM libraries l
        ";
        break;

    default:
        jsonResponse(["success" => false, "error" => "Tipo non valido. Valori ammessi: os, character, script, library"], 422);
        exit;
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    jsonResponse(["success" => false, "error" => "Errore di preparazione query"], 500);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

jsonResponse(["success" => true, "cards" => $rows]);
exit;
