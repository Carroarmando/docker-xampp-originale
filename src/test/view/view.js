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

async function populate()
{
    const data = await fetchData();
    const table = document.getElementById('table');
    table.innerHTML = '';

    const thead = document.createElement('thead');
    const tr = document.createElement('tr');

    const d1 = document.createElement('td');
    const d2 = document.createElement('td');
    const d3 = document.createElement('td');
    d1.textContent = "Nome";
    d2.textContent = "Cognome";
    d3.textContent = "Email";
    tr.appendChild(d1);
    tr.appendChild(d2);
    tr.appendChild(d3);

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

        tbody.appendChild(row);
    });
    table.appendChild(tbody);
}