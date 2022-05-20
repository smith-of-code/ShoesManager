<template>
  <div class="adviser__weather">
    <label class="adviser__label" for="your-city">{{ question }}</label>
    <input
      class="advaser_input"
      type="text"
      id="your-city"
      v-model.lazy="city"
      @keyup.enter="fetchWeather"
    />
    <div v-show="showButtons">
      <button
        class="adviser__btn"
        type="button"
        id="your-city-yes"
        @click="aproveLocation(1)"
      >
        ДА
      </button>
      <button
        class="adviser__btn"
        type="button"
        id="your-city-yes"
        @click="aproveLocation(0)"
      >
        НЕТ
      </button>
    </div>
    <label class="adviser__label" for="your-location"
      >Или разрешите узнать ваше местоположение:</label
    >
    <button class="adviser__btn" type="button" id="your-location" @click="yourPlace">
      Определить
    </button>
    <div class="weather-box">
      <div class="adviser__weather_box">Текущие погодные условия:</div>
      <div v-show="wind">
        <div class="temp">
          {{ Math.round(currentTemp) }}°c ощущается как {{ Math.round(fillingTemp) }}°c
          {{ weatherCondition }} скорость ветра: {{ Math.round(wind) }}м/с
        </div>
      </div>
      <div v-show="opps">Не могу получить погоду...</div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { reactive, ref, onBeforeMount } from "vue";
const city = ref("");
let weather = reactive({});
//const api_key = "a744ff0924d1107e3e24787a2749ab0c";Москва openweather
//const api_key = "06e244b17971890dfd276d9e64e89ae8";Амстердам openweather
const api_key = "9e341092-e547-434f-8444-b2e9055229de"; //Яндекс

const url_base = "https://api.openweathermap.org/data/2.5/";
const currentTemp = ref();
const fillingTemp = ref();
const weatherCondition = ref();
const wind = ref();
const opps = ref(false); //условие объявления, что координаты не определить
const showButtons = ref(true); //показ кнопок подтверждения города
const question = ref("Ваш населенный пункт?");
const latitude = ref();
const longitude = ref();
const emit = defineEmits(["onweatherdata"]);

const url_getCoordinatesFromOutsideAPI = "http://ip-api.com/json/?lang=ru";

onBeforeMount(() => {
  //если в памяти храниться город пользователя
  if (city.value) fetchWeather();
  else getCord();
});

const getCord = async () => {
  await axios
    .get(`${url_getCoordinatesFromOutsideAPI}`)
    .then((response) => {
      //получение текущих координат и названия города
      city.value = response.data.city;
      latitude.value = response.data.lat;
      longitude.value = response.data.lon;
      console.log("Запрос сделала", city.value);
      fetchWeatherWithLL();
    })
    .catch((error) => {
      error.response.data;
    });
};

//обращение к серверу погоды с запросом по названию города
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
  //контроль имени города
  //console.log("name", results.name);
  currentTemp.value = weather.main.temp;
  fillingTemp.value = weather.main.feels_like;
  //weatherCondition.value = weather.weather[0].description;
  switch (weather.weather[0].description) {
    //грязь предполагаем при темперауре от -2 до +5С
    case "дождь":
      weatherCondition.value = 2;
      break;
    case "снег":
      weatherCondition.value = 4;
      break;
    default:
      weatherCondition.value = 1; //сухо, ясно, облачно, пасмурно
  }
  wind.value = weather.wind.speed; //км/ч? проверить
  emit("onweatherdata", {
    temp: fillingTemp.value,
    condition: weatherCondition.value,
  });
}
//обработка ошибки, если не получается получить ответ сервера о погоде
function eraseWeather() {
  wind.value = 0;
  opps.value = true;
}

//Подтверждение города в запросе
function aproveLocation(aprove) {
  if (aprove) {
    showButtons.value = false;
    return;
  } else {
    city.value = "";
    question.value = "Укажите ваш город:";
  }
}

//уточнение местополения принудительно
function yourPlace() {
  if (!navigator.geolocation) {
    console.log("Geolocation не поддерживается вашим браузером");
  } else {
    navigator.geolocation.getCurrentPosition(success, error);
    fetchWeatherWithLL();
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
//запрос погоды по широте и долготе
function fetchWeatherWithLL() {
  if (latitude.value) {
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
