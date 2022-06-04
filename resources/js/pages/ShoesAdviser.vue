<template>
  <div
    class="collection_container collection_container_bgr collection_container_bgr_vert"
  >
    <h1 class="collection_header">Что сейчас надеть?</h1>
    <DateBilder @ondaydata="(e) => takeDateData(e)" />
    <WeatherBilder @onweatherdata="(e) => takeWeatherData(e)" />
    <!-- <DateBilder @ondaydata="(e) => (you = e)" /> -->
  </div>
  <div v-if="result">
    <li v-for="(item, index) in resultList.value" :key="index" class="serch_item">
      <img
        class="collection_img"
        :src="`/storage/shoes_img/` + item.photo_path"
        alt="picture"
      />
      <SearchList style="width: 15vw">{{ item.name }}</SearchList>
      <SearchList style="width: 12vw">
        <div v-for="(ids, index) in item.purposes_ids" :key="index">
          <div v-if="ids === 1">
            <IconCasual :width="30" :height="30" :color="`#000000`" />
          </div>
          <div v-if="ids === 2">
            <IconSport :width="30" :height="30" :color="`#000000`" />
          </div>
          <div v-if="ids === 3">
            <IconWork :width="30" :height="30" :color="`#000000`" />
          </div>
          <div v-if="ids === 4">
            <IconParty :width="30" :height="30" :color="`#000000`" />
          </div>
        </div>
      </SearchList>

      <SearchList style="width: 10vw">
        <span>от&nbsp;&nbsp;</span>
        <span :class="[item.temp_from <= 0 ? lowTemp : highTemp]"
          >{{ item.temp_from }}C°</span
        ></SearchList
      >
      <SearchList style="width: 10vw"
        ><span>до&nbsp;&nbsp;</span
        ><span :class="[item.temp_to <= 0 ? lowTemp : highTemp]"
          >{{ item.temp_to }}C°</span
        ></SearchList
      >
      <SearchList style="width: 12vw">
        <div v-for="(ids, index) in item.weathers_ids" :key="index">
          <div v-if="ids === 1">
            <IconSun :width="30" :height="30" :color="`#000000`" />
          </div>
          <div v-if="ids === 2">
            <IconRain :width="30" :height="30" :color="`#000000`" />
          </div>
          <div v-if="ids === 3">
            <IconSpot :width="30" :height="30" :color="`#000000`" />
          </div>
          <div v-if="ids === 4">
            <IconSnow :width="30" :height="30" :color="`#000000`" />
          </div>
        </div>
      </SearchList>
      <SearchList style="width: 24vw" class="adviser__recomend">{{
        item.comments
      }}</SearchList>
    </li>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import DateBilder from "../components/components/DateBilder.vue";
import WeatherBilder from "../components/components/WeatherBilder.vue";
import IconSun from "../components/icons/IconSun.vue";
import IconRain from "../components/icons/IconRain.vue";
import IconSpot from "../components/icons/IconSpot.vue";
import IconSnow from "../components/icons/IconSnow.vue";
import IconWork from "../components/icons/IconWork.vue";
import IconSport from "../components/icons/IconSport.vue";
import IconCasual from "../components/icons/IconCasual.vue";
import IconParty from "../components/icons/IconParty.vue";
import SearchList from "../components/slot/SearchList.vue";
import axios from "axios";

//получение данных из дочерних компонентов
const dateWeather = ref([]);
function takeWeatherData(e) {
  dateWeather.value = e;
  console.log("dateWeather", dateWeather.value.condition);
  //мы получили данные о погоде и готовы к загрузке листинга обуви
  loader();
}
const dateData = ref([]); //объект данных
const dayType = ref(""); //будни или выходные
const dayPeriod = ref(""); //время дня в сослагательном
const lowTemp = ref("temp_low");
const highTemp = ref("temp_high");

function takeDateData(e) {
  dateData.value = e;
  if (dateData.value.day === "суббота" || dateData.value.day === "воскресенье") {
    dayType.value = "выходного";
  } else dayType.value = "буднего";

  switch (dateData.value.period) {
    case "утро":
      dayPeriod.value = "утру";
      break;
    case "середина дня":
      dayPeriod.value = "середине";
      break;
    case "вечер":
      dayPeriod.value = "вечеру";
      break;
    case "ночь":
      dayPeriod.value = "ночи";
      break;
    default:
      dayPeriod.value = "важному периоду";
  }
  console.log(
    "dateData",
    dateData.value,
    dayType.value,
    dateData.value.period,
    dayPeriod.value
  );
}
//постоянный массив хранения обуви
const shoesStore = reactive([]);
//временный массив хранения обуви, меняется в зависимости от условий
const listSearch = reactive([]);
//итоговый список рекомендаций для рендеринга в template
const resultList = reactive([]);
//показать результат рекомендаций
const result = ref(false);
const comments = ref([]);

//загружаем обувь для последующей обработки
const loader = async () => {
  await axios
    .get("/api/shoes")
    .then((response) => {
      shoesStore.value = response.data;
      listSearch.value = shoesStore.value;
      byTemp(listSearch.value);
    })
    .catch((error) => {
      error.response.data;
    });
};

//выбираем обувь по температуре
function byTemp(list) {
  list = shoesStore.value.filter(
    (e) => dateWeather.value.temp >= e.temp_from && dateWeather.value.temp <= e.temp_to
  );
  comments.value = { comment: "по температуре" };
  console.log("listSearch byTemp ", list, list.length);
  //добавляем комментарии к каждой обуви в объекте списка
  list.forEach((e) => (e.comments = "по температуре"));
  resultList.value = list;
  console.log("after comments ", resultList.value);
  result.value = true; //показываем список в template
  byCondition(resultList.value);
}

//выбираем обувь по погодным условиям
function byCondition(list) {
  list.forEach((e) => {
    if (
      e.weathers_ids.filter((element) => {
        return (
          element === dateWeather.value.condition ||
          //определяем наличие грязи
          (element === 3 && dateWeather.value.temp <= 5 && dateWeather.value.temp >= -2)
        );
      }).length //такая конструкция позволяет возвращать истину или ложь из вложенного массива для filter
    ) {
      e.comments = "по температуре и погодным условиям";
      console.log("weather conditions ", e);
    }
  });
  byPurpose(resultList.value);
}

function byPurpose(list) {
  list.forEach((e) => {
    if (
      e.purposes_ids.filter((element) => {
        return (
          (element === 1 && dayPeriod.value !== "вечеру" && dayPeriod.value !== "ночи") ||
          (element === 2 && dayPeriod.value !== "ночи") ||
          (element === 3 &&
            dayPeriod.value !== "вечеру" &&
            dayPeriod.value !== "ночи" &&
            dayType.value === "буднего") ||
          (element === 4 &&
            dayPeriod.value !== "утру" &&
            dayPeriod.value !== "середине" &&
            dayType.value === "выходного")
        );
      }).length //такая конструкция позволяет возвращать истину или ложь из вложенного массива для filter
    ) {
      e.comments = `по температуре, погодным условиям, ${dayPeriod.value} ${dayType.value} дня`;
      console.log("purpose conditions ", e);
    }
  });
}
</script>

<style scoped>
/*.serch_item {
  display: flex;
  flex-direction: row;
  height: 10vh;
  width: 100vw;
  text-align: left;
  border: 1px solid rgb(52, 143, 56);
}
.search {
  display: flex;
}*/
</style>
