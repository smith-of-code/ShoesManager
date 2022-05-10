<template>
  <svg
    :style="({ width: dimention.width + 'px' }, { height: dimention.height + 'px' })"
    viewBox="0 0 24 24"
  >
    <path
      :fill="color"
      d="M3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19M17,12L12,7V10H8V14H12V17L17,12Z"
    />
  </svg>
</template>
<script setup>
const dimention = defineProps({
  width: {
    Number,
    default: 20,
  },
  height: {
    Number,
    default: 20,
  },
  color: {
    String,
    default: "#FF0000",
  },
});
</script>
