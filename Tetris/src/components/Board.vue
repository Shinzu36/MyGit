<template>
  <div class="game-container">
    <BurgerMenu @open-popup="openPopup" />
    <div class="left-panel">
      <h2>NEXT BLOCK</h2>
      <div class="next-block-preview">
        <div v-for="(row, i) in nextBlock" :key="i" class="row">
          <Block v-for="(cell, j) in row" :key="j" :cellValue="cell" />
        </div>
      </div>
    </div>
    
    <div class="board-wrapper">
      <div v-if="gameState !== 'playing'" class="game-overlay">
        <div v-if="gameState === 'ready'" class="overlay-content">
          <h1>Tetris</h1>
          <button @click="startGame" :disabled="!user">Play</button>
          <p v-if="!user" class="login-prompt">Please log in first</p>
        </div>
        <div v-if="gameState === 'countdown'" class="overlay-content">
          <p class="countdown">{{ countdownValue }}</p>
        </div>
        <div v-if="gameState === 'paused'" class="overlay-content">
          <h2>Pause</h2>
          <button @click="resumeGame">Continue</button>
        </div>
        <div v-if="gameState === 'gameOver'" class="overlay-content">
          <h2>Game Over</h2>
          <p>Final score: {{ score }}</p>
          <button @click="resetGame">Play again</button>
        </div>
      </div>
      <div class="board">
        <div v-for="(row, i) in displayBoard" :key="i" class="row">
          <Block v-for="(cell, j) in row" :key="j" :cellValue="cell" />
        </div>
      </div>
    </div>
    
    <div class="right-panel">
      <div v-if="user">
        <h2>PLAYER</h2>
        <p class="player-name">{{ user.name }}</p>
      </div>
      <h2>SCORE</h2>
      <p class="score">{{ score }}</p>
      <div v-if="comboMultiplier > 1" class="combo-display">
        <h3>COMBO</h3>
        <p class="combo-multiplier">x{{ comboMultiplier }}</p>
      </div>
      <button v-if="gameState === 'playing'" @click="pauseGame" class="pause-button">Pause</button>
      <button v-if="user" @click="logout" class="logout-button">Log out</button>
    </div>
  </div>

  <PopUp :isVisible="currentPopup !== null" @close="closePopup">
      <template v-slot:header>
        <h2 v-if="currentPopup === 'login'">Login / Registration</h2>
        <h2 v-if="currentPopup === 'leaderboard'">Leaderboard</h2>
        <h2 v-if="currentPopup === 'controls'">Controls</h2>
        <h2 v-if="currentPopup === 'possibleBlocks'">Possible Blocks</h2>
      </template>
      
      <div v-if="currentPopup === 'login'" class="popup-content">
        <div class="form-card">
          <p v-if="authMessage" class="auth-message">{{ authMessage }}</p>
          <p v-if="authError" class="error-message">{{ authError }}</p>
          
          <form @submit.prevent="handleAuthSubmit">
            <div class="input-group">
              <label for="username">Name</label>
              <input type="text" id="username" v-model="displayName" required />
            </div>
            <button type="submit">{{ isLoginMode ? 'Log in' : 'Register' }}</button>
          </form>
          
          <p class="toggle-mode" @click="toggleAuthMode">
            {{ isLoginMode ? 'Dont have an account yet? Register.' : 'Already have an account? Log in.' }}
          </p>
        </div>
      </div>
      
      <div v-if="currentPopup === 'leaderboard'" class="popup-content leaderboard">
        <ol>
          <li v-for="entry in users" :key="entry.id">
            <span>{{ entry.name }}</span>
            <span>{{ entry.score }}</span>
          </li>
        </ol>
        <p v-if="users.length === 0">No Results.</p>
      </div>

      <div v-if="currentPopup === 'controls'" class="popup-content controls">
        <img src="../assets/controls.png" alt="controls" class="controls">
      </div>
      
      <div v-if="currentPopup === 'possibleBlocks'" class="popup-content">
        <img src="../assets/blocks.png" alt="blocks">
      </div>
  </PopUp>
  <audio ref="backgroundMusic" loop>
    <source src="../assets/tetris_theme.mp3" type="audio/mp3">
  </audio>
</template>

<script setup>
// Kód JavaScriptu zůstává beze změny, logika je již správně oddělena.
import { ref, onMounted, onUnmounted, computed } from "vue";
import Block from "./Block.vue";
import BurgerMenu from "./BurgerMenu.vue";
import PopUp from "./PopUp.vue";
import { supabase } from '../main.js';

// --- STAV UŽIVATELE A AUTENTIZACE (POZNÁMKA: AUTENTIZACE JE SIMULOVANÁ) ---
const backgroundMusic = ref(null);
const user = ref(null);
const users = ref([]);
const isLoginMode = ref(true);
const displayName = ref(''); // Již nepotřebujeme email ani password
const authError = ref('');
const authMessage = ref('');

// --- KONSTANTY A STAV HRY ---
const currentPopup = ref(null);
const rows = 20;
const columns = 10;
const T = [[0, 1, 0, 0], [1, 1, 1, 0], [0, 0, 0, 0]];
const J = [[2, 0, 0, 0], [2, 2, 2, 0], [0, 0, 0, 0]];
const L = [[0, 0, 3, 0], [3, 3, 3, 0], [0, 0, 0, 0]];
const S = [[0, 4, 4, 0], [4, 4, 0, 0], [0, 0, 0, 0]];
const Z = [[5, 5, 0, 0], [0, 5, 5, 0], [0, 0, 0, 0]];
const O = [[6, 6, 0, 0], [6, 6, 0, 0]];
const I = [[0, 0, 0, 0], [7, 7, 7, 7], [0, 0, 0, 0], [0, 0, 0, 0]];
const blocks = [T, J, L, S, Z, O, I];
const board = ref([]);
const currentBlock = ref(null);
const nextBlock = ref(null);
const currentX = ref(0);
const currentY = ref(0);
let gameInterval = null;
let currentInterval = 1000;
const gameState = ref('ready');
const countdownValue = ref(3);
const score = ref(0);
const blocksSinceLastClear = ref(4);
const comboMultiplier = ref(1);
let lastScoreUpdate = 0;

const displayBoard = computed(() => {
  const newBoard = JSON.parse(JSON.stringify(board.value));
  if (currentBlock.value) {
    for (let i = 0; i < currentBlock.value.length; i++) {
      for (let j = 0; j < currentBlock.value[i].length; j++) {
        if (currentBlock.value[i][j] > 0) {
          const y = currentY.value + i;
          const x = currentX.value + j;
          if (newBoard[y] && newBoard[y][x] !== undefined) {
             newBoard[y][x] = currentBlock.value[i][j];
          }
        }
      }
    }
  }
  return newBoard;
});

/**
 * @description Zavře aktuálně zobrazený pop-up.
 */
function closePopup() {
  currentPopup.value = null;
}
/**
 * @description Otevře pop-up s daným názvem.
 * @param {string} popupName - Název pop-upu, který se má zobrazit.
 */
function openPopup(popupName) {
  currentPopup.value = popupName;
}

function toggleAuthMode() {
  isLoginMode.value = !isLoginMode.value;
  authError.value = '';  // Volitelné: vymaže chybu při přepnutí
  authMessage.value = ''; // Volitelné: vymaže zprávu při přepnutí
}
// --- NOVÉ ZJEDNODUŠENÉ SUPABASE FUNKCE BEZ AUTH ---
const handleAuthSubmit = async () => {
  authError.value = '';
  authMessage.value = '';

  try {
    if (!displayName.value) {
      throw new Error('Jméno nesmí být prázdné.');
    }

    // Krok 1: Kontrola, zda uživatel již existuje (podle jména)
    // ZMĚNA ZDE: .single() -> .maybeSingle()
    const { data: existingUser, error: selectError } = await supabase
      .from('users')
      .select('name, score')
      .eq('name', displayName.value)
      .maybeSingle(); // Očekáváme 0 nebo 1 výsledek, což je správně

    // Jakákoli chyba zde je nyní skutečný problém (např. síťová chyba, RLS),
    // protože 'žádný uživatel nenalezen' už není považováno za chybu.
    if (selectError) {
      throw selectError;
    }
    
    if (isLoginMode.value) {
      // LOGIKA PRO PŘIHLÁŠENÍ
      if (!existingUser) {
        authError.value = 'Uživatel s tímto jménem neexistuje.';
        return;
      }
      user.value = {
        name: existingUser.name
      };
      authMessage.value = 'Přihlášení proběhlo úspěšně!';
    } else {
      // LOGIKA PRO REGISTRACI
      if (existingUser) {
        authError.value = 'Uživatel s tímto jménem již existuje.';
        return;
      }

      const { error: insertError } = await supabase
        .from('users')
        .insert({
          name: displayName.value,
          score: 0,
        });

      if (insertError) throw insertError;

      user.value = {
        name: displayName.value
      };
      authMessage.value = 'Registrace proběhla úspěšně! Můžete hrát.';
    }

    setTimeout(() => {
      closePopup();
    }, 1500);

  } catch (error) {
    authError.value = error.message || 'Chyba při zpracování. Zkuste to znovu.';
  }
};

async function getusers() {
  const { data, error } = await supabase.from('users').select('*').order('score', { ascending: false }).limit(10);
  if (data) users.value = data;
  if (error) console.error("Error fetching scores:", error);
}

async function saveScore() {
  if (!user.value || score.value <= 0) return;

  try {
    const { data: userData, error: fetchError } = await supabase
      .from('users')
      .select('score')
      .eq('name', user.value.name)
      .single();

    if (fetchError && fetchError.code === 'PGRST116') {
      const { error: insertError } = await supabase
        .from('users')
        .insert({ 
          name: user.value.name,
          score: score.value,
        });

      if (insertError) {
        console.error('Chyba při vkládání nového záznamu:', insertError.message);
        throw insertError;
      } return;
    } 
    const existingScore = userData.score;
    
    if (score.value > existingScore) {
      const { error: updateError } = await supabase
        .from('users')
        .update({ score: score.value })
        .eq('name', user.value.name);

      if (updateError) {
        throw updateError;
      }
    }
  } catch (error) {
    console.error('🚨 Vyskytla se neočekávaná chyba:', error.message);
  }
}

function logout() { 
    user.value = null;
    gameState.value = 'ready';
}
// Původní funkce resetGame a gameOver musí zůstat.
async function gameOver() {
  clearInterval(gameInterval);
  await saveScore();
  gameState.value = 'gameOver';
}

function emptyBoard() {
  board.value = Array.from({ length: rows }, () => Array(columns).fill(0));
}

function updateGameSpeed() {
    const scoreDiff = score.value - lastScoreUpdate;
    if (scoreDiff >= 1000) {
        lastScoreUpdate = score.value;
        const speedDecrease = 50;
        const minSpeed = 100;
        if (currentInterval > minSpeed) {
            currentInterval = Math.max(minSpeed, currentInterval - speedDecrease);
            clearInterval(gameInterval);
            gameInterval = setInterval(gameLoop, currentInterval);
            console.log("Rychlost hry zrychlena na: ", currentInterval, "ms");
        }
    }
}

function spawnNewBlock() {
  if (!nextBlock.value) {
      currentBlock.value = blocks[Math.floor(Math.random() * blocks.length)];
      nextBlock.value = blocks[Math.floor(Math.random() * blocks.length)];
  } else {
      currentBlock.value = nextBlock.value;
      nextBlock.value = blocks[Math.floor(Math.random() * blocks.length)];
  }
  
  currentX.value = Math.floor((columns - currentBlock.value[0].length) / 2);
  currentY.value = 0;
  
  if (!isValidPosition(currentBlock.value, currentX.value, currentY.value)) {
    clearInterval(gameInterval);
    saveScore();
    gameState.value = 'gameOver';
    
  }
}

function clearLines() {
  let clearedLinesCount = 0;
  for (let y = rows - 1; y >= 0; y--) {
    if (!board.value[y].includes(0)) {
      clearedLinesCount++;
      board.value.splice(y, 1);
      board.value.unshift(Array(columns).fill(0));
      y++;
    }
  }
  return clearedLinesCount;
}

function lockBlock() {
  if (!currentBlock.value) return;

  for (let i = 0; i < currentBlock.value.length; i++) {
    for (let j = 0; j < currentBlock.value[i].length; j++) {
      if (currentBlock.value[i][j] > 0) {
        board.value[currentY.value + i][currentX.value + j] = currentBlock.value[i][j];
      }
    }
  }
  
  const clearedLines = clearLines();

  if (clearedLines > 0) {
    if (blocksSinceLastClear.value <= 3) {
      comboMultiplier.value++;
    } else {
      comboMultiplier.value = 1;
    }

    let basePoints = 0;
    switch (clearedLines) {
        case 1: basePoints = 100; break;
        case 2: basePoints = 300; break;
        case 3: basePoints = 500; break;
        case 4: basePoints = 800; break;
    }
    
    score.value += basePoints * comboMultiplier.value;
    blocksSinceLastClear.value = 0;
    updateGameSpeed();
  } else {
    blocksSinceLastClear.value++;
    if (blocksSinceLastClear.value > 3) {
      comboMultiplier.value = 1;
    }
  }
  
  spawnNewBlock();
}

function moveDown() {
  if (isValidPosition(currentBlock.value, currentX.value, currentY.value + 1)) {
    currentY.value++;
  } else {
    lockBlock();
  }
}

function dropBlock() {
  if (!currentBlock.value) return;
  while (isValidPosition(currentBlock.value, currentX.value, currentY.value + 1)) {
    currentY.value++;
  }
  lockBlock();
}

function isValidPosition(block, x, y) {
  for (let i = 0; i < block.length; i++) {
    for (let j = 0; j < block[i].length; j++) {
      if (block[i][j] > 0) {
        const boardX = x + j;
        const boardY = y + i;
        if (boardX < 0 || boardX >= columns || boardY >= rows || (board.value[boardY] && board.value[boardY][boardX] > 0)) {
          return false;
        }
      }
    }
  }
  return true;
}

function moveLeft() {
  if (isValidPosition(currentBlock.value, currentX.value - 1, currentY.value)) {
    currentX.value--;
  }
}

function moveRight() {
  if (isValidPosition(currentBlock.value, currentX.value + 1, currentY.value)) {
    currentX.value++;
  }
}

function rotate(direction) {
  if (!currentBlock.value) return;
  const originalBlock = currentBlock.value;
  const n = originalBlock.length;
  const rotatedBlock = Array.from({ length: n }, () => Array(n).fill(0));

  for (let i = 0; i < n; i++) {
    for (let j = 0; j < n; j++) {
      if (direction === 'clockwise') {
        rotatedBlock[j][n - 1 - i] = originalBlock[i][j];
      } else {
        rotatedBlock[n - 1 - j][i] = originalBlock[i][j];
      }
    }
  }
  if (isValidPosition(rotatedBlock, currentX.value, currentY.value)) {
    currentBlock.value = rotatedBlock;
  }
}

function handleKeyDown(event) {
  if (gameState.value === 'playing') {
    switch (event.key) {
      case "ArrowLeft": event.preventDefault(); moveLeft(); break;
      case "ArrowRight": event.preventDefault(); moveRight(); break;
      case "ArrowUp": event.preventDefault(); rotate('clockwise'); break;
      case "ArrowDown": event.preventDefault(); moveDown(); break;
      case " ": event.preventDefault(); dropBlock(); break;
    }
  }
  
  if (event.key === "Escape") {
    event.preventDefault();
    if (gameState.value === 'playing') pauseGame();
    else if (gameState.value === 'paused') resumeGame();
  }
}

const gameLoop = () => {
  moveDown();
};

function startGame() {
  gameState.value = 'countdown';
  countdownValue.value = 3;
  const countdownInterval = setInterval(() => {
    countdownValue.value--;
    if (countdownValue.value === 0) {
      clearInterval(countdownInterval);
      gameState.value = 'playing';
      spawnNewBlock();
      gameInterval = setInterval(gameLoop, currentInterval);
    }
  }, 1000);
  if (backgroundMusic.value) {
    backgroundMusic.value.play().catch(error => {
      console.error("Chyba při přehrávání hudby:", error);
    });
  }
}

function pauseGame() {
  if (gameState.value !== 'playing') return;
  clearInterval(gameInterval);
  gameState.value = 'paused';
  if (backgroundMusic.value) {
    backgroundMusic.value.pause();
  }
}

function resumeGame() {
  if (gameState.value !== 'paused') return;
  gameState.value = 'countdown';
  countdownValue.value = 3;
   const countdownInterval = setInterval(() => {
    countdownValue.value--;
    if (countdownValue.value === 0) {
      clearInterval(countdownInterval);
      gameState.value = 'playing';
      gameInterval = setInterval(gameLoop, currentInterval);
    }
  }, 1000);
  if (backgroundMusic.value) {
    backgroundMusic.value.play();
  }
}

function resetGame() {
  emptyBoard();
  score.value = 0;
  comboMultiplier.value = 1;
  blocksSinceLastClear.value = 4;
  currentInterval = 1000;
  lastScoreUpdate = 0;
  currentBlock.value = null;
  nextBlock.value = null;
  startGame();
}

// --- ONMOUNTED ---
onMounted(() => {
  supabase.auth.onAuthStateChange((_event, session) => {
    user.value = session?.user ?? null;
  });
  getusers();
  supabase.channel('public:users').on('postgres_changes', { event: '*', schema: 'public', table: 'users' }, getusers).subscribe();
  emptyBoard();
  window.addEventListener("keydown", handleKeyDown);
});
onUnmounted(() => {
  clearInterval(gameInterval);
  window.removeEventListener("keydown", handleKeyDown);
});
</script>

<style scoped>
.game-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 30px;
  font-family: 'Arial', sans-serif;
}

.board-wrapper {
  position: relative;
}

.board {
  display: grid;
  grid-template-columns: repeat(v-bind(columns), 30px);
  background: #111;
  border: 5px solid #333;
  width: max-content;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.game-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: white;
  z-index: 10;
}

.overlay-content h1 {
  font-size: 3em;
  margin-bottom: 10px;
}
.overlay-content h2 {
  font-size: 2.5em;
  margin-bottom: 20px;
}
.overlay-content p {
  font-size: 1.5em;
  margin-bottom: 20px;
}
.overlay-content button {
  padding: 10px 20px;
  margin-bottom: 20px;
  font-size: 1.2em;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.overlay-content button:hover {
  background-color: #45a049;
}
.countdown {
  font-size: 4em;
  font-weight: bold;
}

.row {
  display: contents;
}

.left-panel, .right-panel {
  width: 150px;
  background-color: #222;
  color: #eee;
  padding: 20px;
  border-radius: 10px;
  border: 3px solid #333;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.left-panel h2, .right-panel h2 {
  margin: 0 0 10px 0;
  font-size: 1.2em;
  color: #aaa;
}

.score .player-name {
  font-size: 1.5em; 
  font-weight: bold; 
  color: #4CAF50; 
  margin: 0; 
  word-wrap: break-word; 
}

.player-name { color: #3498db; }

.combo-display {
  background-color: #333;
  padding: 10px;
  border-radius: 5px;
}

.combo-display h3 {
    margin: 0 0 5px 0;
    color: #ffc107;
}

.combo-multiplier {
    font-size: 1.8em;
    font-weight: bold;
    color: #ff9800;
    margin: 0;
}

.pause-button, .logout-button {
  padding: 10px;
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.logout-button { 
  background-color: #607D8B;
}

.pause-button:hover {
  background-color: #d32f2f;
}

.next-block-preview {
  display: grid;
  grid-template-columns: repeat(4, 30px);
  grid-template-rows: repeat(2, 30px);
  margin-left: -12px;
  padding: 5px;
  background-color: #333;
  border-radius: 5px;
  width: max-content;
}

.controls {
    width: 760px;
}
.form-card { 
  width: 100%; 
  text-align: center; 
  color: #eee; 
}
.input-group { 
  margin-bottom: 15px; 
  text-align: left; 
}
.input-group label { 
  display: block; 
  margin-bottom: 5px; 
  color: #aaa; 
}
.input-group input { 
  width: 100%; 
  padding: 10px; 
  background: #333; 
  border: 1px solid #555; 
  border-radius: 5px; 
  color: #eee; 
  box-sizing: border-box; 
}
.form-card button { 
  width: 100%; 
  padding: 10px; 
  background-color: #4CAF50; 
  color: white; 
  border: none; 
  border-radius: 5px; 
  cursor: pointer; 
  font-size: 1em; 
}
.toggle-mode { 
  margin-top: 15px; 
  cursor: pointer; 
  text-decoration: underline; 
  color: #aaa; 
  font-size: 0.9em; 
}
.error-message { 
  color: #f44336; 
  margin-bottom: 15px; 
}
.auth-message { 
  color: #4CAF50; 
  margin-bottom: 15px; 
}
.leaderboard ol { 
  list-style-type: decimal; 
  padding-left: 20px; 
  margin: 0; 
}
.leaderboard li { 
  display: flex; 
  justify-content: space-between; 
  margin-bottom: 5px; 
}
</style>