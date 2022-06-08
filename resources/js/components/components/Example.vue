<template>
  <div class="ramka">
    <div class="ramka__left">
      <img class="picture" :src="screenInfo.info.picture" alt="picture" />
    </div>
    <div class="ramka__right">
      <div class="ramka__text ramka__text_bg collection__title">
        {{ screenInfo.info.header }}
      </div>
      <div class="ramka__text ramka__text_md collection__title">
        {{ screenInfo.info.miniheader }}
      </div>
      <div class="ramka__text ramka__text_sm collection__title">
        {{ screenInfo.info.text }}
      </div>
    </div>
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
  flex: 100%;
  flex-direction: row;
  height: 60vh;
  max-width: 1050px;
  margin-bottom: 1rem;
  margin-left: 0.5rem;
}

.ramka__left {
  display: flex;
  flex: 100%;
  min-width: 450px;
  max-width: 650px;
}
.ramka__right {
  display: flex;
  flex: 35%;
  flex-direction: column;
  justify-content: space-between;
  margin: 0 0.5rem;
}
.ramka__text {
  justify-content: left;
}
.ramka__text_bg {
  font-size: 1.2rem;
  color: #883cda;
}
.ramka__text_md {
  font-size: 1rem;
}
.ramka__text_sm {
  font-size: 0.8rem;
}
.picture {
  width: 100%;
}
</style>
