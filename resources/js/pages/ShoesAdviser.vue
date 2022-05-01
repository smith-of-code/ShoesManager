<template>
  <h1>Что сейчас одеть?</h1>
  <label for="your-city"
    >Введите ваш населенный пункт, если необходимо уточнить погоду</label
  >
  <input type="text" id="your-city" v-model.lazy="city" @keyup.enter="fetchWeather" />
  <label for="your-location">или разрешите узнать ваше местоположение</label>
  <button type="button" id="your-location" @click="yourPlace">определить</button>
  <div class="weather-box">
    <p>Текущие погодные условия:</p>
    <div v-show="wind">
      <div class="temp">
        {{ Math.round(currentTemp) }}°c ощущается как {{ Math.round(fillingTemp) }}°c{{
          weatherCondition
        }}
        скорость ветра{{ Math.round(wind) }}м/с
      </div>
    </div>
    <div v-show="opps">Не могу полчить погоду...</div>
    <DateBilder/>
  </div>
</template>

<script setup>
import { reactive, ref, onBeforeMount } from "vue";
import DateBilder from "../components/components/DateBilder.vue";

const city = ref("Самара");
let weather = reactive({});
const api_key = "a744ff0924d1107e3e24787a2749ab0c";
const url_base = "https://api.openweathermap.org/data/2.5/";
const currentTemp = ref();
const fillingTemp = ref();
const weatherCondition = ref();
const wind = ref();
const opps = ref(false);
const latitude = ref();
const longitude = ref();

onBeforeMount(() => {
  if (city) fetchWeather();
});
//обращение к серверу погоды с запросом
function fetchWeather() {
  opps.value = false;
  //https://openweathermap.org/api
  fetch(`${url_base}weather?q=${city.value}&units=metric&APPID=${api_key}&lang=ru`)
    .then((res) => {
      return res.json();
    })
    .then(setResults)
    .catch(() => eraseWeather);
}
//присваивание данных о погоде переменным
function setResults(results) {
  weather = results;
  //console.log(weather);
  currentTemp.value = weather.main.temp;
  fillingTemp.value = weather.main.feels_like;
  weatherCondition.value = weather.weather[0].description;
  wind.value = weather.wind.speed; //км/ч? проверить
}
//обработка ошибки, если не получается получить ответ сервера о погоде
function eraseWeather() {
  wind.value = 0;
  opps.value = true;
}

function yourPlace() {
  if (!navigator.geolocation) {
    console.log("Geolocation не поддерживается вашим браузером");
  } else {
    navigator.geolocation.getCurrentPosition(success, error);
    fetchWeatherWithLL;
  }
}
function success(position) {
  latitude.value = position.coords.latitude;
  longitude.value = position.coords.longitude;
  console.log(`Широта: ${latitude.value} °, Долгота: ${longitude.value} °`);
}
function error() {
  console.log("Невозможно получить ваше местоположение");
}

function fetchWeatherWithLL() {
  if (this.latitude) {
    fetch(
      `${url_base}weather?lat=${latitude.value}&lon=${longitude.value}&units=metric&APPID=${api_key}&lang=ru`
    )
      .then((res) => {
        return res.json();
      })
      .then(setResults)
      .catch(() => eraseWeather);
  }
}
</script>

<style scoped></style>
