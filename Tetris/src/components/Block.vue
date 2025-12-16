<template>
  <div class="cell" :class="cellClass"></div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  cellValue: {
    type: Number,
    required: true,
  },
});

const cellClass = computed(() => {
  switch (props.cellValue) {
    case 1:
      return "T";
    case 2:
      return "J";
    case 3:
      return "L";
    case 4:
      return "S";
    case 5:
      return "Z";
    case 6:
      return "O";
    case 7:
      return "I";
    default:
      return "";
  }
});
</script>

<style scoped>
.cell {
  width: 30px;
  height: 30px;
  border: 1px solid #333;
}
.T {
  background-color: purple;
}
.J {
  background-color: blue;
}
.L {
  background-color: orange;
}
.S {
  background-color: limegreen;
}
.Z {
  background-color: red;
}
.O {
  background-color: yellow;
}
.I {
  background-color: cyan;
}
</style>