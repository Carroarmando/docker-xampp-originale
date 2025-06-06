<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrazione</title>
        <style>
            body { font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            form { display: flex; flex-direction: column; width: 300px; }
            input { margin-bottom: 1rem; padding: 0.5rem; font-size: 1rem; }
            button { padding: 0.75rem; font-size: 1rem; cursor: pointer; }
            #message { margin-top: 1rem; color: #d00; height: 1.2rem; }
        </style>
    </head>
    <body>
        <form id="signup_form">
            <h1>Registrati</h1>
            <label>
                Username
                <input type="text" name="username" required>
            </label>
            <label>
                Email
                <input type="email" name="email" required>
            </label>
            <label>
                Password
                <input type="password" name="pwd" required>
            </label>
            <button type="submit" name="action" value="register">Registrati</button>
        </form>
        <p id="message"></p>
        <p>Hai già un account? <a href="login.php">Accedi</a></p>

        <script>
            const form = document.getElementById('signup_form');
            const messageEl = document.getElementById('message');

            form.addEventListener('submit', async (e) => 
            {
                e.preventDefault();
                messageEl.textContent = '';

                try 
                {
                    const formData = new FormData(form);
                    formData.append('action', 'register');

                    const response = await fetch('../../api/login.php', 
                    {
                        method: 'POST',
                        headers: { 'Accept': 'application/json' },
                        body: formData
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