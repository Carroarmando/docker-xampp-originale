<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Componi il tuo mazzo</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<h1>Componi il tuo mazzo</h1>

<div class="container">
    <div class="deck-column" id="os">
        <h2>OS (max 6)</h2>
        <div class="available"></div>
        <hr>
        <h3>Selezionate</h3>
        <div class="selected-cards"></div>
    </div>

    <div class="deck-column" id="characters">
        <h2>Character (max 15)</h2>
        <div class="available"></div>
        <hr>
        <h3>Selezionate</h3>
        <div class="selected-cards"></div>
    </div>

    <div class="deck-column" id="scripts">
        <h2>Script (max 30)</h2>
        <div class="available"></div>
        <hr>
        <h3>Selezionate</h3>
        <div class="selected-cards"></div>
    </div>

    <div class="deck-column" id="libraries">
        <h2>Library (max 15)</h2>
        <div class="available"></div>
        <hr>
        <h3>Selezionate</h3>
        <div class="selected-cards"></div>
    </div>
</div>

<div style="text-align: center; margin-top: 30px;">
    <button onclick="saveAll()">💾 Salva tutto</button>
</div>

<div style="text-align: center; margin-top: 30px;">
    <button onclick="play()">Gioca</button>
</div>

<script>
const deckLimits = {
    os: 6,
    characters: 15,
    scripts: 30,
    libraries: 30
};

const decks = {
    os: [],
    characters: [],
    scripts: [],
    libraries: []
};

const availableCardsDict = {
    os: {},
    characters: {},
    scripts: {},
    libraries: {}
};

const types = ['os','characters','scripts','libraries'];

async function init() {
    await Promise.all(types.map(type => loadType(type)));
}

async function loadType(type) {
    const resAvailable = await fetch(`../../api/cards.php?type=${type}`);
    const jsonAvail = await resAvailable.json();
    if (!jsonAvail.success) return;
    availableCardsDict[type] = {};
    jsonAvail.cards.forEach(card => availableCardsDict[type][card.card_id] = card);

    const resSelected = await fetch(`../../api/card_in.php?type=${type}`);
    const jsonSel = await resSelected.json();
    if (!jsonSel.success) return;
    decks[type] = jsonSel.data.map(saved => availableCardsDict[type][saved.card_id]).filter(Boolean);
    
    renderAvailable(type);
    renderSelected(type);
}

function renderAvailable(type) {
    const container = document.querySelector(`#${type} .available`);
    container.innerHTML = '';
    Object.values(availableCardsDict[type]).forEach(card => {
        if (decks[type].some(c => c.card_id === card.card_id)) return;
        const div = document.createElement('div');
        div.className = 'card';
        div.innerText = type === 'libraries' ? `${card.card_name} (${card.language_name})` : card.card_name;
        div.onclick = () => toggleCard(card, type);
        container.appendChild(div);
    });
}

function renderSelected(type) {
    const container = document.querySelector(`#${type} .selected-cards`);
    container.innerHTML = '';
    decks[type].forEach((card, idx) => {
        const div = document.createElement('div');
        div.className = 'card selected';
        div.innerText = type === 'libraries' ? `${card.card_name} (${card.language_name})` : card.card_name;
        div.onclick = () => toggleCard(card, type);
        container.appendChild(div);
    });
}

function toggleCard(card, type) {
    const deck = decks[type];
    const idx = deck.findIndex(c => c.card_id === card.card_id);
    if (idx >= 0) deck.splice(idx,1);
    else {
        if (deck.length >= deckLimits[type]) {
            alert(`Limite ${type} raggiunto (${deckLimits[type]})`);
            return;
        }
        deck.push(card);
    }
    renderAvailable(type);
    renderSelected(type);
}

async function saveAll() {
    for (const type of types) {
        const payload = { type, cards: decks[type].map(c => c.card_id) };
        const res = await fetch(`../../api/save_deck.php`, {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        if (!json.success) {
            alert(`Errore salvataggio ${type}: ${json.error}`);
            return;
        }
    }
    alert('Mazzi salvati con successo!');
}

document.addEventListener('DOMContentLoaded', init);
</script>

</body>
</html>
