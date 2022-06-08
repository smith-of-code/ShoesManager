<template>
  <div class="collection_container about__container">
    <h1 class="collection_header">Как работать с приложением?</h1>
    <div class="slot" v-for="page in pages" :key="pageNumber.value">
      <example :info="page" />
    </div>
    <div class="button">
      <p @click="previos">
        <IconArrowLeft :width="40" :height="40" :color="`#883CDA`" />
      </p>
      <div @click="pageCount" class="button_text">Нажмите для продолжения</div>
      <p @click="pageCount">
        <IconArrowRight :width="40" :height="40" :color="`#883CDA`" />
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import example from "../components/components/Example.vue";
import IconArrowLeft from "../components/icons/IconArrowLeft.vue";
import IconArrowRight from "../components/icons/IconArrowRight.vue";

const data = ref([
  {
    header: "Вводим данные каждой обуви для последующего хранения и использования",
    miniheader: `В разделе "Карточка обуви" необходимо заполнить поле название обуви, загрузить изображение пары, выбрать назначение обуви, погодные условия и температуру ношения.`,
    text: `Выбираем назначение обуви путем нажатия одной из иконок назначения. Можно выбрать все или ни одну. Повтороное нажатие отменяет выбор. Пояснения, что означает иконка, слева на рисунке. Выбрать погодные условия аналогично назначению. Задать температуру ношения от и до. Нажать кнопку сохранения данных.`,
    picture: "storage/images/crdlist.png",
  },
  {
    header: "Просмотр списка сохраненной обуви и фильтрация списка по параметрам",
    miniheader: `В разделе "Моя коллекция" можно посмотреть список сохраненных карточек обуви. С помощью фильтра оставить на экране для промостра то, что вас интересует. Можно нажать иконку редактировнаия и внести изменения в карточку обуви. Можно удалить карточку.`,
    text:
      "Фильтровать список можно по названию, достаточно ввести одну букву. По температуре, двигая ползунок температуры ношения. По назначению и погодным условиям, нажимая на соотвествующие иконки. Повтороное нажатие на иконку отменяет выбор.",
    picture: "storage/images/collectionlist.png",
  },
  {
    header: `Узначть, что сейчас одеть можно на странице "Рекомендации"`,
    miniheader: `Необходимо убедиться в правильном автоматическом определении текущего местоположения. От этого зависит точность прогноза погоды. Если текущее положение определено с ошибкой, нажать кнопку "определить".`,
    text:
      "Алгоритм рекомендует три варианта выбора: а) обувь подходит по температуре; б)обувь подходит по температуре и погодным условиям, например, можно носить в дождь; в)помимо вышеперечисленного обувь соотвествует выходному или праздничному дню и текущему времени суток, например, вечером в субботу обувь для торжестевнного мероприятия.",
    picture: "storage/images/recomend.png",
  },
]);

const pageNumber = ref(1);
//массив-прослойка для отображения листинга из одного элемента массива
//требуется, чтобы автоматически обновлялся компонент example с новыми значениями
const pages = ref([{}]);
//начальное присваивание стартовой страницы
pages.value[0] = data.value[0];

function pageCount() {
  //console.log("page ", pageNumber.value);
  if (pageNumber.value > 2) return;
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
.slot {
  display: flex;
  flex: 100%;
}
.button {
  flex: 100%;
  justify-content: center;
  text-align: center;
  cursor: pointer;
  display: flex;
  flex-direction: row;
}
.button p {
  margin: 0;
}
.button_text {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 1rem;
}
.about__container {
  background: linear-gradient(
      to right,
      rgba(255, 255, 255, 0.4),
      70%,
      rgba(255, 255, 255, 1)
    ),
    url("/storage/images/shelf.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: 100% bottom;
}
</style>
