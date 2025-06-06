<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="..\css\login.css">
    </head>
    <body>
        <form id="login_form">
            <h1>Accedi</h1>
            <label>
                Email
                <input type="email" name="email" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <input type="hidden" name="action" value="login">
            <button type="submit" name="action" value="login">Accedi</button>
        </form>
        <p id="message"></p>
        <p>Non hai un account? <a href="signup.php">Registrati</a></p>

        <script>
            const form = document.getElementById('login_form');
            const messageEl = document.getElementById('message');
        
            form.addEventListener('submit', async (e) => 
            {
                e.preventDefault();
                messageEl.textContent = '';
                
                try 
                {
                    const response = await fetch('../../api/login.php', 
                    {
                        method: 'POST',
                        headers: { 'Accept': 'application/json' },
                        body: new FormData(form)
                    });

                    const data = await response.json();

                    if (data.success) 
                    {
                        window.location.href = 'dashboard.php';
                    } 
                    else 
                    {
                        messageEl.textContent = data.error || 'Errore durante la registrazione';
                    }
                    } 
                    catch (err) 
                    {
                    console.error('Fetch error:', err);
                    messageEl.textContent = 'Errore di rete. Riprova.';
                    }
            });
        </script>
    </body>
</html>
