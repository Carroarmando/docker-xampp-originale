<?php 
include_once "includes/db.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET"): ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accedi</title>
</head>
<body>
    <form method="post" action="accedi.php">
        <h1>Accedi</h1>
        Email: <input type="text" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit" name="action" value="accedi">Accedi</button>
    </form>
    <p>Non hai un account? <a href="registrati.php">Registrati</a></p>
</body>
</html>

<?php
elseif ($_SERVER["REQUEST_METHOD"] == "POST"):
    if (isset($_POST["action"]) && $_POST["action"] == "accedi" &&
        isset($_POST["email"]) && isset($_POST["password"])) 
    {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
    
        // Usare prepared statement per evitare SQL injection
        $stmt = $conn->prepare("SELECT *
                                FROM login 
                                JOIN users ON login.email = users.email 
                                WHERE login.email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) 
        {
            // Verifica la password con hash
            if (password_verify($password, $row["pwd"])) 
            {
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];
                header("Location: dashboard.php");
                exit();
            } 
            else 
            {
                // Password errata
                header("Location: accedi.php");
                exit();
            }
        } 
        else 
        {
            // Utente non trovato
            header("Location: accedi.php");
            exit();
        }
    } 
    else
        echo "Dati mancanti o azione non valida.";
endif;
?>
