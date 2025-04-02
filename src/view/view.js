console.log("Script caricato");

async function fetchData() 
{
    const url = "api/data.php"

    try 
    {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }
    catch(err)
    {
        console.error("Errore:", err);
        return [];
    }
}

let previousData = [];
async function populate()
{
    if(!clicked)
        return;

    const data = await fetchData();
    
    
    if (JSON.stringify(data) === JSON.stringify(previousData)) 
        return;          //se i dati sono uguali non fa niente
    previousData = data; //altrimenti salva i nuovi
    
    const table = document.getElementById('table');
    table.innerHTML = '';

    const thead = document.createElement('thead');
    const tr = document.createElement('tr');

    const d1 = document.createElement('td');
    const d2 = document.createElement('td');
    const d3 = document.createElement('td');
    const d4 = document.createElement('td');
    d1.textContent = "Nome";
    d2.textContent = "Cognome";
    d3.textContent = "Email";
    d4.textContent = "";
    tr.appendChild(d1);
    tr.appendChild(d2);
    tr.appendChild(d3);
    tr.appendChild(d4);

    thead.appendChild(tr);
    table.appendChild(thead);
    
    const tbody = document.createElement('tbody');
    data.forEach(element => 
    {
        const row = document.createElement('tr');

        const d1 = document.createElement('td');
        const d2 = document.createElement('td');
        const d3 = document.createElement('td');
        d1.textContent = element.nome;
        d2.textContent = element.cognome;
        d3.textContent = element.email;
        row.appendChild(d1);
        row.appendChild(d2);
        row.appendChild(d3);
        
        // Crea il bottone per ogni riga
        const d4 = document.createElement("td");
        const button = document.createElement("button");
        button.textContent = "Elimina";
        button.onclick = function () 
        {
            console.log(`${element.nome} ${element.cognome} eliminato.`);

            const formData = new FormData();
            formData.append("email", element.email);
            fetch("api/delete.php", 
            {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(err => console.error("Errore:", err));
        };
        d4.appendChild(button);
        row.appendChild(d4);

        tbody.appendChild(row);
    });
    table.appendChild(tbody);
}

setInterval(populate, 500);

let clicked = false;
async function handleClick()
{
    console.log("click");
    clicked = true;
}

const button_load = document.getElementById("load_data");
button_load.addEventListener("click", handleClick);