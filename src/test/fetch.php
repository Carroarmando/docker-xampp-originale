<!DOCTYPE html>
<html lang="it">
    <div id="container"></div>


    <script>
        let previousData = null; // Variabile per salvare i dati precedenti

        function aggiornaLink() 
        {
            fetch("../api/data.php")
                .then(response => response.json())
                .then(data => 
                {
                    // Se i dati sono uguali a quelli precedenti, non fare nulla
                    if (JSON.stringify(data) === JSON.stringify(previousData))
                        return;

                    // Salva i nuovi dati
                    previousData = data;

                    const div = document.getElementById('container');
                    div.innerHTML = "";
                    data.forEach(dato => 
                    {
                        const innerDiv = document.createElement("div");
                        innerDiv.innerHTML = dato.nome + " " + dato.cognome + " " + dato.email;
                        div.appendChild(innerDiv);
                    })
                })
                .catch(err => console.error("Errore:", err));
        }

        setInterval(aggiornaLink, 500);
        aggiornaLink();
    </script>
</html>