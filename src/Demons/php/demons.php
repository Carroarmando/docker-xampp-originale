<link rel="stylesheet" href="../css/demons.css">
<div id="game-board">

  <!-- Giocatore Top -->
  <div id="player-top" class="player-area">
    <div class="bought-row">
    </div>
    <div class="demon-row">
    </div>
    <div class="player-info">
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
      <div>Anime: 5</div>
    </div>
  </div>

</div>

<script src="../js/creaCarta.js"></script>
<script src="../js/load.js"></script>
