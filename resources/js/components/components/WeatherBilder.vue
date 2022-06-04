<template>
  <div class="adviser__weather">
    <div class="weather-box">
      <div class="adviser__weather_box">{{ city }}, текущие погодные условия:</div>
      <div v-if="wind">
        <div class="adviser__weather_box">
          температура&nbsp;<span :class="[currentTemp <= 0 ? lowTemp : highTemp]"
            >{{ Math.round(currentTemp) }}°C</span
          >&nbsp;ощущается как&nbsp;
          <span :class="[fillingTemp <= 0 ? lowTemp : highTemp]"
            >{{ Math.round(fillingTemp) }}°C</span
          >,&nbsp;скорость ветра&nbsp;<span class="adviser__wind">{{ Math.round(wind) }}&nbsp;м/с</span>
        </div>
      </div>
      <div v-else class="adviser__label adviser__label_coord">
        Не могу получить погоду...
      </div>
      <div class="adviser__weather_city">{{ condition }}</div>
    </div>
    <div class="adviser_coordinaty">
      <label class="adviser__label adviser__label_coord" for="your-location"
        >Если город определился не верно, разрешите уточнить ваше местоположение?</label
      >
      <button class="adviser__btn" type="button" id="your-location" @click="yourPlace">
        Определить
      </button>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { reactive, ref, onBeforeMount } from "vue";
//город местоположения пользователя
const city = ref("");
let weather = reactive({});
//const api_key = "a744ff0924d1107e3e24787a2749ab0c";Москва openweather
//const api_key = "9e341092-e547-434f-8444-b2e9055229de"; //Яндекс
//const url_base = "https://api.openweathermap.org/data/2.5/";
//const url_base = "https://api.weather.yandex.ru/v2/informers";
//текущая температура
const currentTemp = ref();
//ощущуаемая температура
const fillingTemp = ref();
//погодные условия
const weatherCondition = ref();
//ветер
const wind = ref();
const condition = ref();
const opps = ref(false); //условие объявления, что координаты не определить
const showButtons = ref(true); //показ кнопок подтверждения города
const question = ref("Ваш населенный пункт?");
const latitude = ref();
const longitude = ref();
const emit = defineEmits(["onweatherdata"]);
//сторонний источник координат
const url_getCoordinatesFromOutsideAPI = "http://ip-api.com/json/?lang=ru";
const lowTemp = ref("temp_low");
const highTemp = ref("temp_high");

onBeforeMount(() => {
  //получаем координаты из открытого стороннего источника
  getCord();
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
      //вызов функции определения погоды по координатам
      fetchWeatherWithLL();
    })
    .catch((error) => {
      error.response.data;
    });
};

//запрос погоды по широте и долготе
function fetchWeatherWithLL() {
  if (latitude.value) {
    //openweather
    // fetch(
    //   `${url_base}weather?lat=${latitude.value}&lon=${longitude.value}&units=metric&APPID=${api_key}&lang=ru`
    // )
    //Яндекс:
    axios
      .get(`/api/yandex-weather?lat=${latitude.value}&lon=${longitude.value}&lang=ru_RU`)
      .then((res) => {
        console.log("res", res);
        return res;
      })
      .then(setResults)
      .catch(() => eraseWeather);
  }
}

//присваивание данных о погоде переменным после ее получения
function setResults(results) {
  weather = results;
  currentTemp.value = weather.data.fact.temp;
  fillingTemp.value = weather.data.fact.feels_like;
  weatherCondition.value = weather.data.fact.condition;
  console.log("condition", weatherCondition.value);
  switch (weatherCondition.value) {
    //грязь предполагаем при темперауре от -2 до +5С
    case "drizzle" ||
      "light-rain" ||
      "rain" ||
      "moderate-rain" ||
      "heavy-rain" ||
      "continuous-heavy-rain" ||
      "showers" ||
      "thunderstorm" ||
      "thunderstorm-with-rain" ||
      "thunderstorm-with-hail":
      {
        weatherCondition.value = 2;
        condition.value = " Берегите обувь от дождя";
      } //дождь
      break;
    case "showers" || "wet-snow" || "light-snow" || "snow" || "snow-showers":
      {
        weatherCondition.value = 4;
        condition.value = " Ваша обувь будет ходить по снегу";
      } //снег
      break;
    default: {
      weatherCondition.value = 1;
      condition.value = " Вашей обуви будет комфортно";
    } //сухо, ясно, облачно, пасмурно
  }
  wind.value = weather.data.fact.wind_speed;
  emit("onweatherdata", {
    temp: fillingTemp.value,
    condition: weatherCondition.value,
  });
  console.log(
    "currentTemp",
    currentTemp.value,
    "\n",
    "fillingTemp",
    fillingTemp.value,
    "\n",
    "weatherCondition",
    weatherCondition.value,
    "\n",
    "wind",
    wind.value
  );
}
//обработка ошибки, если не получается получить ответ сервера о погоде
function eraseWeather() {
  currentTemp.value = "нет данных";
  fillingTemp.value = "нет данных";
  wind.value = "нет данных";
  opps.value = true;
}

//уточнение местополения принудительно
function yourPlace() {
  if (!navigator.geolocation) {
    console.log("Geolocation не поддерживается вашим браузером");
  } else {
    navigator.geolocation.getCurrentPosition(success, error);
  }
}
function success(position) {
  latitude.value = position.coords.latitude;
  longitude.value = position.coords.longitude;
  console.log(`Широта: ${latitude.value} °, Долгота: ${longitude.value} °`);
  //вызов функции определения погоды по координатам
  fetchWeatherWithLL();
}
function error() {
  console.log("Невозможно получить ваше местоположение");
}

//обращение к серверу погоды openweathermap с запросом по названию города
// function fetchWeather() {
//   opps.value = false;
//   //https://openweathermap.org/api
//   fetch(`${url_base}weather?q=${city.value}&units=metric&APPID=${api_key}&lang=ru`)
//     .then((res) => {
//       return res.json();
//     })
//     .then(setResults)
//     .catch(() => eraseWeather);
// }
</script>
