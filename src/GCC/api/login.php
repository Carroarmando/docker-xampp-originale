<?php
require_once("db/db.php");
require_once("json_response.php");
header('Content-Type: application/json; charset=utf-8');

// Routing richieste
if (!isset($_POST["action"])) 
{
    jsonResponse(["success" => false, "error" => "Parametro 'action' mancante"], 400);
    exit;
}

switch ($_POST["action"]) 
{
    case "register":
        if (!isset($_POST["username"], $_POST["email"], $_POST["pwd"])) 
        {
            jsonResponse(["success" => false, "error" => "Parametri mancanti per registrazione"], 400);
            exit;
        }
        register($_POST["username"], $_POST["email"], $_POST["pwd"]);
        break;

    case "login":
        if (!isset($_POST["email"], $_POST["password"])) 
        {
            jsonResponse(["success" => false, "error" => "Parametri mancanti per login"], 400);
            exit;
        }
        login($_POST["email"], $_POST["password"]);
        break;

    default:
        jsonResponse(["success" => false, "error" => "Azione non valida"], 400);
        exit;
}

// LOGIN SICURO
function login(string $email, string $pwd): void {
    global $conn;

    $stmt = $conn->prepare("
        SELECT u.user_id, u.username, u.email, u.deck_id, l.pwd 
        FROM users u
        JOIN login l ON u.email = l.email
        WHERE u.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    if ($row && password_verify($pwd, $row["pwd"])) 
    {
        unset($row["pwd"]);
        session_start();               // avvia sessione solo su login riuscito
        $_SESSION["user"] = $row;
        jsonResponse(["success" => true, "user" => $row]);
        exit;
    }

    jsonResponse(["success" => false, "error" => "Credenziali invalide"], 401);
    exit;
}

// REGISTRAZIONE SICURA
function register(string $username, string $email, string $pwd): void 
{
    global $conn;

    // 1) Hash password e inserimento in login
    $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO login (email, pwd) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $pwdHash);
    if (!$stmt->execute()) 
    {
        jsonResponse(["success" => false, "error" => "Email già registrata?"], 409);
        exit;
    }

    // 2) Crea un nuovo deck
    if (!$conn->query("INSERT INTO decks () VALUES ()")) 
    {
        jsonResponse(["success" => false, "error" => "Impossibile creare il mazzo"], 500);
        exit;
    }
    $deck_id = $conn->insert_id;

    // 3) Inserimento in users
    $stmt = $conn->prepare("INSERT INTO users (username, email, deck_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $email, $deck_id);
    if (!$stmt->execute()) 
    {
        // rollback login
        $conn->prepare("DELETE FROM login WHERE email = ?")
             ->bind_param("s", $email)
             ->execute();
        jsonResponse(["success" => false, "error" => "Errore creazione utente"], 500);
        exit;
    }

    // 4) Login automatico con sessione
    login($email, $pwd);
}
?>
