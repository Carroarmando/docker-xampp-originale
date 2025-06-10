function Alea(seed) 
{
    function Mash() {
        var n = 0xefc8249d;
        var mash = function(data) {
            data = data.toString();
            for (var i = 0; i < data.length; i++) {
                n += data.charCodeAt(i);
                var h = 0.02519603282416938 * n;
                n = h >>> 0;
                h -= n;
                h *= n;
                n = h >>> 0;
                h -= n;
                n += h * 0x100000000; // 2^32
            }
            return (n >>> 0) * 2.3283064365386963e-10; // 2^-32
        };
        return mash;
    }

    var mash = Mash();
    var s0 = mash(' ');
    var s1 = mash(' ');
    var s2 = mash(' ');
    s0 -= mash(seed);
    if (s0 < 0) s0 += 1;
    s1 -= mash(seed);
    if (s1 < 0) s1 += 1;
    s2 -= mash(seed);
    if (s2 < 0) s2 += 1;

    return function() {
        var t = 2091639 * s0 + 2.3283064365386963e-10 * 0;
        s0 = s1;
        s1 = s2;
        s2 = t - (0 | t);
        return s2;
    };
} //randon seedato

function mescolaMazzo(mazzo, seed)
{
    const rng = new Alea(seed);
    const aux = JSON.parse(JSON.stringify(mazzo));
    for (let i = aux.length - 1; i > 0; i--) 
    {
        const j = Math.floor(rng() * (i + 1));
        [aux[i], aux[j]] = [aux[j], aux[i]];
    }
    return aux;
}

function creaCarta(classNames, imgSrc, tooltipText = "") 
{
    const container = document.createElement('div');
    container.classList.add('card-tooltip-container');

    const div = document.createElement('div');
    classNames.split(' ').forEach(c => div.classList.add(c));

    const img = document.createElement('img');
    img.src = imgSrc;
    img.alt = tooltipText || "Carta";

    div.appendChild(img);

    if (tooltipText)
        container.title = tooltipText;

    container.appendChild(div);
    return container;
}

function load_img(type, id) 
{
    switch (type)
    {
        case "demon":
            if (id > 0 && id <= 20)
                return `../php/api/get/img.php?type=demon&id=${id}`;
            else
                return "";
        case "candle":
            if (id > 0 && id <= 5)
                return `../php/api/get/img.php?type=candle&id=${id}`;
            else
                return "";
        case "neighbor":
            if (id > 0 && id <= 38)
                return `../php/api/get/img.php?type=neighbor&id=${id}`;
            else
                return "";
        default:
            return "";
    }
}

async function mostra_carte()
{
    // tua candela
    fetch(`../php/api/get/user_candle.php?user_id=${user_id}&game_id=${game_id}`)
    .then(res => res.json())
    .then(candle => 
    {
        const candleBottom = creaCarta("card candle", load_img("candle", candle.candle_id), "Raccogli 1 anima");
        boughtRowBottom.appendChild(candleBottom);
    });

    // tuoi demoni
    fetch(`../php/api/get/user_demons.php?user_id=${user_id}&game_id=${game_id}`)
    .then(res => res.json())
    .then(lista => 
    {
        lista.forEach(has_demon =>
        {  
            fetch(`../php/api/get/demon.php?demon_id=${has_demon.demon_id}`)
            .then(res => res.json())
            .then(demon => 
            {
                const demonCard = creaCarta("card demon", load_img("demon", demon.demon_id), demon.summoned ? "demone evocato\n" : "demone non evocato\n" + demon.name + "\n" + demon.effect);
                demonRowBottom.appendChild(demonCard);
            });
        });
    });

    // candela avversario
    fetch(`../php/api/get/user_candle.php?user_id=${opponent_id}&game_id=${game_id}`)
    .then(res => res.json())
    .then(candle => 
    {
        const candleTop = creaCarta("card candle", load_img("candle", candle.candle_id), "Raccogli 1 anima");
        boughtRowTop.appendChild(candleTop);
    });
    
    // demoni avversario
    fetch(`../php/api/get/user_demons.php?user_id=${opponent_id}&game_id=${game_id}&summoned=1`)
    .then(res => res.json())
    .then(lista => 
    {
        lista.forEach(has_demon =>
        {  
            fetch(`../php/api/get/demon.php?demon_id=${has_demon.demon_id}`)
            .then(res => res.json())
            .then(demon => 
            {
                const demonCard = creaCarta("card demon", demon.summoned ? load_img("demon", demon.demon_id) : "../img/retro_demoni.png", demon.summoned ? ("demone evocato\n" + demon.name + "\n" + demon.effect) : "demone non evocato\n");
                demonRowTop.appendChild(demonCard);
            });
        });
    });
    
    // Prendi 5 carte dal mazzo sacrificio (neighborhood)
    const neighborhoodCards = await get_neighbor(5);
    
    // Pulisci eventuali carte già presenti (se serve)
    centerNeighborhood.innerHTML = "";
    
    // Crea le 5 carte nel div centrale usando creaNeighbor
    neighborhoodCards.forEach((card_id) => 
    {
        fetch(`../php/api/get/neighbor.php?neighbor_id=${card_id}`)
        .then(res => res.json())
        .then(neighbor => 
        {
            const neighborCard = creaCarta("card neighbor", `../php/api/get/img.php?type=neighbor&id=${card_id}`, neighbor.effect);
            centerNeighborhood.appendChild(neighborCard);
        })
    });
}