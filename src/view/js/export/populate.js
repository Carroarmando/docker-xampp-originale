console.log("populate");

import { query } from './query.js';

export function populate(data)
{
    console.log("populate");
    console.log(data);
    if (data.length > 0) 
    {
        const table = document.getElementById('table');
        table.innerHTML = '';

        const thead = document.createElement('thead');
        const tr = document.createElement('tr');

        const keys = Object.keys(data[0]);
        keys.forEach(key => 
        {
            const th = document.createElement('th');  // Usa <th> per l'intestazione della tabella
            th.textContent = key;
            tr.appendChild(th);
        });
        const th = document.createElement('th');
        th.textContent = "";
        tr.appendChild(th);

        thead.appendChild(tr);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        data.forEach(element => 
        {
            const row = document.createElement('tr');

            keys.forEach(key => 
            {
                const td = document.createElement('td');
                td.textContent = element[key];
                row.appendChild(td);
            });
            // Crea il bottone per ogni riga
            const td = document.createElement("td");
            const button = document.createElement("button");
            button.textContent = "Elimina";
            button.onclick = function () 
            {
                console.log(`${element.nome} ${element.cognome} eliminato.`);

                query(`delete from users where email = '${element.email}'`);
            };
            td.appendChild(button);
            row.appendChild(td);

            tbody.appendChild(row);
        });
        table.appendChild(tbody);
    }
}