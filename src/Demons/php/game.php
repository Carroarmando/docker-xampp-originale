<?php session_start(); ?>

<link rel="stylesheet" href="../css/game.css">
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

<script>
  const game_id = <?= json_encode($_SESSION['game_id']) ?>;
  const user_id = <?= json_encode($_SESSION['user_id']) ?>;
  const opponent_id = <?= json_encode($_SESSION["opponent_id"]) ?>;
  
  let i = (user_id < opponent_id) ^ (game_id % 2 === 0);
  
  const boughtRowTop = document.querySelector('#player-top .bought-row');
  const boughtRowBottom = document.querySelector('#player-bottom .bought-row');
  const demonRowTop = document.querySelector('#player-top .demon-row');
  const demonRowBottom = document.querySelector('#player-bottom .demon-row');
  const centerNeighborhood = document.querySelector('#center-area #neighborhood');
</script>
<script src="../js/mazzi.js"></script>
<script src="../js/functions.js"></script>

<script src="../js/load.js"></script>
<script>
  mostra_carte();
</script>
