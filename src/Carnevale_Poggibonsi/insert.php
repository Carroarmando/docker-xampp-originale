<?php
include("includes/db.php");
session_start();

function randomCodiceFiscale() {
    // Genera 6 lettere casuali per il nome
    $name = '';
    for ($i = 0; $i < 6; $i++) {
        $name .= chr(rand(65, 90));
    }
    
    // Genera una data di nascita casuale (tra il 1950 e il 2005)
    $year = rand(1950, 2005);
    $month = rand(1, 12);
    // Per semplificare limitiamo il giorno a un valore tra 1 e 28
    $day = rand(1, 28);
    
    // Anno in formato a 2 cifre (es. 95 per 1995)
    $yearCode = substr($year, -2);
    
    // Mappatura del mese: da numero a lettera
    $monthsMap = [
        1  => 'A',
        2  => 'B',
        3  => 'C',
        4  => 'D',
        5  => 'E',
        6  => 'H',
        7  => 'L',
        8  => 'M',
        9  => 'P',
        10 => 'R',
        11 => 'S',
        12 => 'T'
    ];
    $monthCode = $monthsMap[$month];
    
    // Randomizziamo il genere: 0 = maschio, 1 = femmina.
    // Se femmina il giorno viene incrementato di 40 (come nel codice fiscale reale)
    $gender = rand(0, 1);
    if ($gender == 1) {
        $dayCode = str_pad($day + 40, 2, "0", STR_PAD_LEFT);
    } else {
        $dayCode = str_pad($day, 2, "0", STR_PAD_LEFT);
    }
    
    // Codice del comune: una lettera seguita da 3 cifre casuali
    $location = chr(rand(65, 90)) . str_pad(rand(0, 999), 3, "0", STR_PAD_LEFT);
    
    // Carattere di controllo: lettera casuale
    $control = chr(rand(65, 90));
    
    // Costruzione del codice fiscale completo
    // Formato: 6 lettere (nome) + 2 cifre (anno) + 1 lettera (mese) + 2 cifre (giorno) + 4 (comune) + 1 (controllo)
    $cf = $name . $yearCode . $monthCode . $dayCode . $location . $control;
    
    return $cf;
}

// Funzione per estrarre la data di nascita (password) dal codice fiscale
// Assumiamo che il codice fiscale abbia la data in posizione 7-11 (indice 6-10 in PHP)
// e che l'anno sia sempre del secolo 1900.
function extractPasswordFromCF($cf) {
    // Estrae l'anno (2 cifre)
    $yearCode = substr($cf, 6, 2);
    $year = '19' . $yearCode;
    
    // Estrae la lettera del mese e la converte nel numero corrispondente
    $monthLetter = substr($cf, 8, 1);
    $monthsMap = [
        'A' => '01',
        'B' => '02',
        'C' => '03',
        'D' => '04',
        'E' => '05',
        'H' => '06',
        'L' => '07',
        'M' => '08',
        'P' => '09',
        'R' => '10',
        'S' => '11',
        'T' => '12'
    ];
    $month = isset($monthsMap[$monthLetter]) ? $monthsMap[$monthLetter] : '01';
    
    // Estrae il giorno (2 cifre)
    $dayCode = substr($cf, 9, 2);
    $dayNum = intval($dayCode);
    // Se il giorno è maggiore di 40, significa che il soggetto è di sesso femminile
    if ($dayNum > 40) {
        $dayNum -= 40;
    }
    $day = str_pad($dayNum, 2, "0", STR_PAD_LEFT);
    
    // Restituisce la data di nascita in formato yyyymmdd
    return $year . $month . $day;
}

// Funzione per randomizzare la "mask" tra 1 e 10, con il 30% dei casi impostata a NULL
function randomMask() {
    // Genera un numero casuale tra 1 e 100; se il valore è ≤ 30 restituisce NULL
    if (rand(1, 100) <= 30) {
        return null;
    } else {
        return rand(1, 10);
    }
}

for ($i = 0; $i < 50; $i++) 
{
    $cf = randomCodiceFiscale();
    $password = extractPasswordFromCF($cf);
    $mask = randomMask();
    
    if ($mask === null) {
        $query = "INSERT INTO users (codice_fiscale, pwd, mask_id) VALUES ('$cf', '$password', NULL)";
    } else {
        $query = "INSERT INTO users (codice_fiscale, pwd, mask_id) VALUES ('$cf', '$password', $mask)";
    }
    
    $result = $conn->query($query);
}
?>