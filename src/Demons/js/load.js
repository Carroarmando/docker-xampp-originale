const boughtRowTop = document.querySelector('#player-top .bought-row');
const boughtRowBottom = document.querySelector('#player-bottom .bought-row');
const demonRowTop = document.querySelector('#player-top .demon-row');
const demonRowBottom = document.querySelector('#player-bottom .demon-row');

//const divCartaTop1 = creaCarta("card", "percorso immagine carta", function(carta) { funzione da eseguire al click }, "testo tooltip");         //creazione di carte e demoni
//const divDemonTop1 = creaCarta("card demon", "percorso immagine carta", function(carta) { funzione da eseguire al click }, "testo tooltip");

const candles = [["candel0", 3, 4, 5], ["candel1", 5, 6], ["candel2", 6, 8], ["candel3", 8, 9], ["candel4", 9, 10, 11]];

i = /*Math.floor(Math.random() * 5);*/ 1;
candle1 = candles[i];
candles.splice(i, 1)
i = Math.floor(Math.random() * 4);
candle2 = candles[i];
candles.splice(i, 1)

const candleTop = creaCarta("card candle", "../img/" + candle1[0] + ".png", () => console.log("Candela Top cliccata"), "Raccogli un'anima");
candleTop.setAttribute('data-values', JSON.stringify(candle1.slice(1)));
boughtRowTop.appendChild(candleTop);

const candleBottom = creaCarta("card candle", "../img/" + candle2[0] + ".png", () => console.log("Candela Bottom cliccata"), "Raccogli un'anima");
candleBottom.setAttribute('data-values', JSON.stringify(candle2.slice(1)));
boughtRowBottom.appendChild(candleBottom);