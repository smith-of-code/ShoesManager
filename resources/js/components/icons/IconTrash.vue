<template>
  <svg
    :style="
      ({ width: dimention.width + 'px' }, { height: dimention.height + 'px' })
    "
    viewBox="0 0 24 24"
  >
    <path
      :fill="color"
      d="M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M9,8H11V17H9V8M13,8H15V17H13V8Z"
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
