<template>
  <div>
    <div class="burger-icon" :class="{ 'open': isOpen }" @click="toggleMenu">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
    </div>
    
    <div v-if="isOpen" class="overlay" @click="closeMenu"></div>

    <div :class="['menu-container', { 'open': isOpen }]">
      <ul class="menu-list">
        <li><a href="#" @click.prevent="openPopup('login')">Login/Create account</a></li>
        <li><a href="#" @click.prevent="openPopup('leaderboard')">Leaderboard</a></li>
        <li><a href="#" @click.prevent="openPopup('controls')">Controls</a></li>
        <li><a href="#" @click.prevent="openPopup('possibleBlocks')">Possible blocks</a></li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const isOpen = ref(false);
const emit = defineEmits(['open-popup']);

function toggleMenu() {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
}

function closeMenu() {
  isOpen.value = false;
  document.body.style.overflow = '';
}

/**
 * @description Odesílá událost s názvem pop-upu, který se má otevřít.
 * @param {string} popupName - Název pop-upu.
 */
function openPopup(popupName) {
  emit('open-popup', popupName);
  closeMenu();
}
</script>

<style scoped>
/* Styly pro ikonu hamburger menu */
.burger-icon {
  position: fixed;
  top: 20px;
  left: 30px;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 50px;
  height: 35px;
  cursor: pointer;
  z-index: 1001; /* Vždy nahoře */
}

.burger-icon:hover {
    background-color: black;
    padding: 8px;
    border-radius: 15px;
    transition: 0.3s;
}

.burger-icon div {
  width: 35px;
  height: 4px;
  background-color: white;
  transition: all 0.3s ease-in-out;
}

/* Styly pro animaci ikony při otevření */
.burger-icon.open .bar1 {
  transform: rotate(-45deg) translate(-9px, 6px);
}
.burger-icon.open .bar2 {
  opacity: 0;
}
.burger-icon.open .bar3 {
  transform: rotate(45deg) translate(-8px, -8px);
}

/* Styly pro kontejner menu */
.menu-container {
  position: fixed;
  top: 0;
  left: -300px; /* Skryto mimo obrazovku */
  width: 250px;
  height: 100%;
  background-color: #222;
  box-shadow: 2px 0 5px rgba(0,0,0,0.5);
  transition: left 0.3s ease-in-out;
  z-index: 1000;
  padding-top: 60px;
}

/* Otevřený stav menu */
.menu-container.open {
  left: 0;
}

/* Styly pro seznam odkazů */
.menu-list {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.menu-list li {
  padding: 15px 20px;
  border-bottom: 1px solid #444;
}

.menu-list a {
  color: white;
  text-decoration: none;
  font-size: 1.2em;
  display: block;
}

.menu-list li:hover {
    background-color: #535353;
    transition: 0.3s;
}

/* Překryv pozadí */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
}
</style>