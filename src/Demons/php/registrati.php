<?php 
include_once "includes/db.php";
if ($_SERVER["REQUEST_METHOD"] == "GET"): ?>

<meta charset="utf8mb4_general_ci">
<form method="post" action="registrati.php">
    <h2>Registrati</h2>
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="text" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    
    <button type="submit" name="action" value="register">Registrati</button>
</form>
<p>Hai già un account? <a href="accedi.php">Accedi</a></p>

<?php
elseif ($_SERVER["REQUEST_METHOD"] == "POST"):
    if (isset($_POST["action"]) && $_POST["action"] == "register" &&
        isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["username"])) 
    {
        $email = trim($_POST["email"]);
        $username = trim($_POST["username"]);
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); // Hash sicuro
    
        // Preparazione del primo insert
        $stmt = $conn->prepare("INSERT INTO login (email, pwd) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
    
        if ($stmt->execute()) 
        {
            // Se va bene, faccio anche l'inserimento nella tabella users
            $stmt = $conn->prepare("INSERT INTO users (email, username) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $username);
    
            if ($stmt->execute()) 
            {
                header("Location: accedi.php");
                exit();
            } 
            else 
            {
                // Rollback manuale (senza transazioni)
                $stmt = $conn->prepare("DELETE FROM login WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                echo "Errore durante la registrazione (users).";
            }
        } 
        else
            echo "Errore durante la registrazione (login).";
    } 
    else
        echo "Dati mancanti o azione non valida.";
    
endif;
?>
