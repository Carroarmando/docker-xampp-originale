<?php
include_once("../../includes/db.php");

$type = $_GET["type"] ?? null;
$id = $_GET["id"] ?? null;

if (!$id || !$type) {
    http_response_code(400);
    exit("Dati mancanti.");
}

// ✅ Mappa sicura dei nomi logici a tabelle e colonne reali
$mapping = [
    "candle" => ["table" => "candles", "column" => "candle_id"],
    "demon" => ["table" => "demons", "column" => "demon_id"],
    "neighbor" => ["table" => "neighbors", "column" => "neighbor_id"]
];

// ✅ Verifica se il tipo è valido
if (!isset($mapping[$type])) {
    http_response_code(400);
    exit("Tipo non valido.");
}

$table = $mapping[$type]["table"];
$column = $mapping[$type]["column"];

// ⚠️ Query costruita in modo sicuro con nome dinamico ma controllato
$query = "SELECT img FROM $table WHERE $column = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    exit("Nessuna immagine trovata.");
}

$stmt->bind_result($img);
$stmt->fetch();

header("Content-Type: image/png");
echo $img;

$stmt->close();
$conn->close();
?>
