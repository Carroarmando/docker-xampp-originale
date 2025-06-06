<link rel="stylesheet" href="demons.css">
<div id="game-board">

  <!-- Giocatore Top -->
  <div id="player-top" class="player-area">
    <div class="bought-row">
    </div>
    <div class="demon-row">
    </div>
    <div class="player-info">
      <div>🕯️ Candela: 3, 4, 5</div>
      <div>Anime: 5</div>
    </div>
  </div>

  <!-- Mazzi laterali a metà altezza -->
  <div id="side-decks">
    <div id="demon-deck" class="card deck">🜏 Mazzo Demoni</div>
    <div id="discard-pile" class="card deck">♻️ Mazzo Scarti</div>
  </div>

  <!-- Centro: vicinato + mazzo sacrificio -->
  <div id="center-area">
    <div id="neighborhood">
      <div class="card">Ragazzo 1</div>
      <div class="card">Ragazzo 2</div>
      <div class="card">Ragazzo 3</div>
      <div class="card">Ragazzo 4</div>
      <div class="card">Ragazzo 5</div>
    </div>
    <div id="sacrifice-deck" class="card deck">🜏 Mazzo Sacrificio</div>
  </div>

  <!-- Giocatore Bottom -->
  <div id="player-bottom" class="player-area">
    <div class="demon-row">
    </div>
    <div class="bought-row">
    </div>
    <div class="player-info">
      <div>🕯️ Candela: 4, 5, 6</div>
      <div>Anime: 5</div>
    </div>
  </div>

</div>

<script>
  function creaCarta(classNames, inner, onClickCallback) {
    const div = document.createElement('div');
    classNames.split(' ').forEach(c => div.classList.add(c));
    div.innerHTML = inner;

    if (typeof onClickCallback === 'function') {
      div.addEventListener('click', () => onClickCallback(inner));
    }

    return div;
  }

</script>

<script>
  const boughtRowTop = document.querySelector('#player-top .bought-row');
  const divCartaTop1 = creaCarta("card", "ct1", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divCartaTop2 = creaCarta("card", "ct2", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divCartaTop3 = creaCarta("card", "ct3", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  boughtRowTop.appendChild(divCartaTop1);
  boughtRowTop.appendChild(divCartaTop2);
  boughtRowTop.appendChild(divCartaTop3);

  const boughtRowBottom = document.querySelector('#player-bottom .bought-row');
  const divCartaBottom1 = creaCarta("card", "cb1", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divCartaBottom2 = creaCarta("card", "cb2", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divCartaBottom3 = creaCarta("card", "cb3", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  boughtRowBottom.appendChild(divCartaBottom1);
  boughtRowBottom.appendChild(divCartaBottom2);
  boughtRowBottom.appendChild(divCartaBottom3);

  const demonRowTop = document.querySelector('#player-top .demon-row');
  const divDemonTop1 = creaCarta("card demon", "dt1", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divDemonTop2 = creaCarta("card demon", "dt2", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divDemonTop3 = creaCarta("card demon", "dt3", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  demonRowTop.appendChild(divDemonTop1);
  demonRowTop.appendChild(divDemonTop2);
  demonRowTop.appendChild(divDemonTop3);
  
  const demonRowBottom = document.querySelector('#player-bottom .demon-row');
  const divDemonBottom1 = creaCarta("card demon", "db1", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divDemonBottom2 = creaCarta("card demon", "db2", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  const divDemonBottom3 = creaCarta("card demon", "db3", function(carta) { console.log(`Hai cliccato su: ${carta}`); });
  demonRowBottom.appendChild(divDemonBottom1);
  demonRowBottom.appendChild(divDemonBottom2);
  demonRowBottom.appendChild(divDemonBottom3);
</script>
