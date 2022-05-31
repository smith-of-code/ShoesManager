<template>
  <!--  <div class="ramka">
    <h2>{{ screenInfo.info.header }}</h2>
    <h4>{{ screenInfo.info.miniheader }}</h4>
    <p>{{ screenInfo.info.text }}</p>
    <img class="picture" :src="screenInfo.info.picture" alt="picture" />
  </div> -->
  <div class="about__info">
    <h2>{{ screenInfo.info.header }}</h2>
    <h4>{{ screenInfo.info.miniheader }}</h4>
    <p>{{ screenInfo.info.text }}</p>
  </div>
  <div class="about__img">
    <img class="picture" :src="screenInfo.info.picture" alt="picture" />
  </div>
</template>

<script setup>
const screenInfo = defineProps({
  info: {
    header: {
      type: String,
      default: "заголовок по умолчанию",
    },
    miniheader: {
      type: String,
      default: "подзаголовок по умолчанию",
    },
    text: {
      type: String,
      default: "текст по умолчанию",
    },
    picture: {
      type: Object,
    },
  },
});
</script>

<style scoped>
.ramka {
  display: flex;
  flex-direction: column;
  border: 2px solid slateblue;
  background-color: beige;
  height: 60vh;
  width: 60vw;
}
h4 {
  margin: 0;
}
.picture {
  height: 25vh;
  object-fit: contain;
  align-self: flex-start;
}
</style>
