const body = document.getElementsByTagName("body");

function Stampadati() 
{
    const nome = document.getElementById("fname").value.trim(); // trim toglie tutti gli spazi
    const cognome = document.getElementById("lname").value.trim();
    const username = document.getElementById("uname").value.trim();
    const email = document.getElementById("mail").value.trim();
    const residenza = document.getElementById("residenza").value.trim();
    const genere = document.querySelector('input[name="genere"]:checked');
    const dataNascita = document.getElementById("dataNascita").value.trim();

    // Controllo dei campi
    if (!(ControlloDati(nome, cognome, username, email, residenza, genere, dataNascita))) 
        return;

    // Inserisce i dati nel paragrafo con id "dati"
   /*  console.log(document.getElementsByName("registrazione"));
    console.log(nome.value);  */

    // Inserisce i dati nel paragrafo con id "dati"
    document.getElementById("dati").innerHTML =
    "Contenuto: nome e cognome: " + nome + " " + cognome + " - Username: " + username + " - Email: " + email + " - Residenza: " + residenza + " - Genere: " + (genere ? genere.value : " ")  + " - Data di nascità: " + dataNascita;
}

function ControlloDati(nome, cognome, username, email, residenza, genere, dataNascita)
{
    if (!nome || !cognome || !username || !email || !residenza || !genere || !dataNascita) 
    {
        alert("Dati incompleti. Si prega di compilare tutti i campi.");
        return false;
    }
    return true;
}