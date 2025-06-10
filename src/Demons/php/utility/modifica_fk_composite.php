<?php
require 'includes/db.php'; // connessione $conn
$table = $_GET['table'] ?? null;

if (!$table) {
    die("❌ Specificare una tabella con ?table=nome_tabella");
}

// Prendi tutte le FK della tabella
$query = "
    SELECT 
        kcu.CONSTRAINT_NAME,
        kcu.COLUMN_NAME,
        kcu.REFERENCED_TABLE_NAME,
        kcu.REFERENCED_COLUMN_NAME
    FROM information_schema.KEY_COLUMN_USAGE kcu
    JOIN information_schema.REFERENTIAL_CONSTRAINTS rc
        ON kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME
    WHERE 
        kcu.TABLE_SCHEMA = DATABASE() AND 
        kcu.TABLE_NAME = '$table'
    ORDER BY kcu.CONSTRAINT_NAME, kcu.ORDINAL_POSITION;
";

$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    die("ℹ️ Nessuna foreign key trovata nella tabella '$table'.");
}

$constraints = [];

// Raggruppa per CONSTRAINT_NAME
while ($row = $result->fetch_assoc()) {
    $name = $row['CONSTRAINT_NAME'];
    $constraints[$name]['columns'][] = $row['COLUMN_NAME'];
    $constraints[$name]['ref_table'] = $row['REFERENCED_TABLE_NAME'];
    $constraints[$name]['ref_columns'][] = $row['REFERENCED_COLUMN_NAME'];
}

foreach ($constraints as $name => $data) {
    $columns = implode('`, `', $data['columns']);
    $ref_columns = implode('`, `', $data['ref_columns']);
    $ref_table = $data['ref_table'];
    $newName = "fk_{$table}_" . implode('_', $data['columns']);

    echo "🔧 Modifico constraint `$name`: ($columns) → $ref_table($ref_columns)<br>";

    // 1. Drop
    if (!$conn->query("ALTER TABLE `$table` DROP FOREIGN KEY `$name`")) {
        echo "❌ Errore nel DROP: " . $conn->error . "<br>";
        continue;
    }

    // 2. Add con ON DELETE CASCADE
    $sql = "
        ALTER TABLE `$table` 
        ADD CONSTRAINT `$newName`
        FOREIGN KEY (`$columns`) 
        REFERENCES `$ref_table`(`$ref_columns`)
        ON DELETE CASCADE
    ";

    if ($conn->query($sql)) {
        echo "✅ Ricreata con ON DELETE CASCADE<br>";
    } else {
        echo "❌ Errore nel CREATE: " . $conn->error . "<br>";
    }
}

$conn->close();