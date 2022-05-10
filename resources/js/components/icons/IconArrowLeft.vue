<template>
  <svg
    :style="({ width: dimention.width + 'px' }, { height: dimention.height + 'px' })"
    viewBox="0 0 24 24"
  >
    <path
      :fill="color"
      d="M21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5M7,12L12,17V14H16V10H12V7L7,12Z"
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
