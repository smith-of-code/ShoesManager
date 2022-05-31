<template>
  <div class="container about__container">
    <h1 class="home__title">О приложении</h1>
    <div v-for="page in pages" :key="pageNumber.value">
      <example :info="page" />
    </div>
    <div class="about__button">
      <p @click="previos">
        <IconArrowLeft :width="40" :height="40" :color="`#883CDA`" />
      </p>
      <p @click="pageCount">Нажмите для продолжения</p>
      <p @click="pageCount">
        <IconArrowRight :width="40" :height="40" :color="`#883CDA`" />
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import example from "../components/components/Example.vue";
import shirvint from "../components/images/Shirvint.png";
import mainScreen from "../components/images/MainScreen.png";
import shoesCard from "../components/images/ShoesCard.png";
import listing from "../components/images/Listing.png";
import recomend from "../components/images/Recomendation.png";
import IconArrowLeft from "../components/icons/IconArrowLeft.vue";
import IconArrowRight from "../components/icons/IconArrowRight.vue";

const data = ref([
  {
    header: "Почему вам необходимо это приложение?",
    miniheader: "Цитата",
    text: "Склероз, это когда ты зыбываешь, куда положил бумажку, на которой написал, что не забыть... Александр Ширвинт",
    picture: shirvint,
  },
  {
    header: "Что оно делает?",
    miniheader: "В любой момент советует какую обувь надеть",
    text: "Необходимо только ввести данные обуви в приложение и вы всегда будете знать, что одеть в зависимости от погоды, времни суток и дня недели",
    picture: mainScreen,
  },
  {
    header: "Как ввести данные обуви?",
    miniheader: "В разделе Карточка обуви ... ",
    text: "присвойте название обуви, загрузите фотографию, выбирите...",
    picture: shoesCard,
  },
  {
    header: "Как посмотреть весь список моей обуви?",
    miniheader: "В разделе Моя коллекция можно ... ",
    text: "С помощью разных настроек можно вывести на экран только интересующие вас пары обуви...",
    picture: listing,
  },
  {
    header: "Как узначть, что сейчас надеть?",
    miniheader: "В разделе Рекомендации будут показаны все варианты ... ",
    text: "Алгоритм рекомендации построен на ...",
    picture: recomend,
  },
]);

const pageNumber = ref(1);
//массив-прослойка для отображения листинга из одного элемента массива
//требуется, чтобы автоматически обновлялся компонент example с новыми значениями
const pages = ref([{}]);
//начальное присваивание стартовой страницы
pages.value[0] = data.value[0];

function pageCount() {
  if (pageNumber.value > 4) return;
  pageNumber.value++;
  pages.value[0] = data.value[pageNumber.value - 1];
}

function previos() {
  if (pageNumber.value <= 1) return;
  pageNumber.value--;
  pages.value[0] = data.value[pageNumber.value - 1];
}
</script>

<style scoped>
</style>
