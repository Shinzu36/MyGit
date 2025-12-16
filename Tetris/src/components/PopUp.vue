<template>
  <div v-if="isVisible" class="popup-overlay" @click.self="close">
    <div class="popup-container">
      <div class="popup-header">
        <slot name="header">
          <h2>Pop-Up</h2>
        </slot>
        <button @click="close" class="close-button">&times;</button>
      </div>
      <div class="popup-content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  isVisible: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close']);

/**
 * @description Zavře pop-up a odešle událost 'close' rodičovské komponentě.
 */
function close() {
  emit('close');
}
</script>

<style scoped>
/* Překryv (overlay) pro ztmavení pozadí */
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
  transition: opacity 0.3s ease;
}

/* Kontejner pop-upu */
.popup-container {
  background: #333;
  color: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  width: 90%;
  max-width: 800px;
  transform: scale(0.95);
  transition: transform 0.3s ease;
  text-align: center;
}

.popup-overlay.show .popup-container {
  transform: scale(1);
}

.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #444;
  padding-bottom: 10px;
  margin-bottom: 15px;
}

.close-button {
  background: none;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
  padding: 0;
}
</style>