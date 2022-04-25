<script setup>
import { reactive, ref } from "vue";
import IconSun from "../components/icons/IconSun.vue";
import IconRain from "../components/icons/IconRain.vue";
import IconSpot from "../components/icons/IconSpot.vue";
import IconSnow from "../components/icons/IconSnow.vue";
import IconWork from "../components/icons/IconWork.vue";
import IconSport from "../components/icons/IconSport.vue";
import IconCasual from "../components/icons/IconCasual.vue";
import IconParty from "../components/icons/IconParty.vue";
import shoesBackground from "../components/images/ShoesPicture.jpg";
import axios from "axios";

//id клиента переданное в модуль из основного экрана
//const client = defineProps(["id"]);
//наименование обуви
const name = ref("");
//изображение обуви:
//кртинка
const photo = reactive({});
const pathPhoto = ref(shoesBackground);
const photoName = ref("");
//назначение обуви
const purpose = ref([]);
//температура от
const temp_from = ref(-5);
//температура до
const temp_to = ref(5);
//погодные условия
const weather = ref([]);

//объект всех данных формы при "отправить"
let formData = new FormData();

function onChangeFile(e) {
  photo.value = e.target.files[0];
  //показ изображения в качестве превью
  let reader = new FileReader();
  reader.onload = (function (theFile) {
    photoName.value = theFile.name;
    return function (e) {
      // convert image file to base64 string
      pathPhoto.value = e.target.result;
    };
  })(photo.value);
  //чтение пути для браузера
  reader.readAsDataURL(photo.value);
}

function prepareCardForm() {
  if (!name.value) {
    //временная заглушка вместо валидации введенного имени
    alert("Введите имя обуви");
    return;
  }
  formData.append("name", name.value);
  formData.append("photo", photo.value);
  formData.append("purposesIds", purpose.value);
  formData.append("temp_from", temp_from.value);
  formData.append("temp_to", temp_to.value);
  formData.append("weathersIds", weather.value);
  axios.post("/api/shoes", formData);
  for (let entry of formData.entries()) {
    console.log("output ", entry);
  }

  //очистка файла передачи данных
  formData = new FormData();
  //очистка исходных данных формы до ввода следующей пары
  name.value = "";
  photo.value = {};
  pathPhoto.value = shoesBackground;
  purpose.value = [];
  temp_from.value = -5;
  temp_to.value = 5;
  weather.value = [];

  console.log("объект передачи данных на сервер очищен...");
  //   for (let entry of formData.entries()) {
  //     console.log("output ", entry);
  //   }
}
</script>

<template>
  <div class="container">
    <h1 class="shoes_card_form_title">Карточка обуви</h1>
    <form class="shoes_card_form" method="post" enctype="multipart/form-data">
      <div class="shoes shoes_name">
        <label for="shoes-name"></label>
        <input
          placeholder="Введите наименование"
          type="text"
          id="shoes-name"
          class="shoes_name__input"
          v-model="name"
          required
        />
      </div>

      <div class="shoes shoes_photo">
        <!--<p>Выбрать/поменять изображение обуви</p>-->
        <label class="shoes_img__label" for="shoes-img"></label>
        <input
          class="shoes_img"
          type="file"
          id="shoes-img"
          accept="image/*"
          @change="onChangeFile"
          name="file"
        />
        <span>Загрузить изображение</span>
      </div>
      <div class="shoes">
        <p>Отметьте назначение обуви:</p>
        <div class="shoes_purpose">
          <div class="shoes">
            <!--
            прежний вариант
            <IconCasual />
            <label for="casual"><IconCasual /></label>
             <input
              class="check_casual"
              type="checkbox"
              id="casual"
              value="1"
              v-model="purpose"
            />-->
            <label class="check_purpose" title="Повседневная">
              <input
                type="checkbox"
                id="casual"
                value="1"
                v-model="purpose"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M17,18A2,2 0 0,1 19,20A2,2 0 0,1 17,22C15.89,22 15,21.1 15,20C15,18.89 15.89,18 17,18M1,2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.3,11.97C16.96,12.58 16.3,13 15.55,13H8.1L7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7C5.89,17 5,16.1 5,15C5,14.65 5.09,14.32 5.24,14.04L6.6,11.59L3,4H1V2M7,18A2,2 0 0,1 9,20A2,2 0 0,1 7,22C5.89,22 5,21.1 5,20C5,18.89 5.89,18 7,18M16,11L18.78,6H6.14L8.5,11H16Z"
                />
              </svg>
            </label>
          </div>
          <div class="shoes">
            <label class="check_purpose" title="Спортивная">
              <input
                type="checkbox"
                id="sport"
                value="2"
                v-model="purpose"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M12.3,2C11.33,2.03 10.58,2.84 10.61,3.8C10.62,4.04 10.67,4.27 10.77,4.5L11.06,5.14V5.14C11.1,5.27 11.03,5.41 10.89,5.45C10.8,5.5 10.7,5.45 10.63,5.37L10.21,4.82C9.88,4.4 9.38,4.14 8.85,4.13C7.88,4.11 7.08,4.88 7.06,5.84C7.05,6.26 7.19,6.66 7.45,7L7.87,7.5H7.88C7.96,7.63 7.93,7.79 7.82,7.87C7.73,7.94 7.61,7.94 7.53,7.87L7,7.45C6.66,7.19 6.25,7.05 5.84,7.06C4.88,7.08 4.11,7.88 4.13,8.85C4.14,9.38 4.4,9.88 4.82,10.21L5.39,10.65C5.5,10.75 5.5,10.91 5.38,11C5.31,11.07 5.21,11.09 5.12,11.05H5.11L4.5,10.77C4.27,10.68 4.04,10.62 3.8,10.61C2.84,10.58 2.03,11.34 2,12.31C2,13.03 2.4,13.69 3.06,13.97L14.45,19.04L19.04,14.45L13.97,3.06C13.69,2.39 13,1.97 12.3,2M13.13,6.1C13.55,6.09 13.93,6.33 14.09,6.71L17.14,13.55L13.19,9.61L12.26,7.5C11.96,6.87 12.42,6.12 13.13,6.1M9.85,8.85C10.12,8.85 10.37,8.95 10.56,9.15L15.37,13.96C15.77,14.34 15.78,14.97 15.4,15.37C15,15.77 14.38,15.78 13.96,15.37L9.15,10.56C8.75,10.18 8.74,9.54 9.13,9.15C9.32,8.95 9.58,8.85 9.85,8.85M7.13,12.17C7.26,12.17 7.4,12.21 7.5,12.26L9.63,13.2L13.57,17.14L6.71,14.09C5.69,13.65 6.03,12.14 7.13,12.17M20.28,16.04L16.04,20.28L16.89,21.13C17.65,21.88 18.75,22.17 19.78,21.9C20.81,21.62 21.62,20.81 21.9,19.78C22.17,18.75 21.88,17.65 21.13,16.89L20.28,16.04Z"
                />
              </svg>
            </label>
          </div>

          <div class="shoes">
            <label class="check_purpose" title="Деловая">
              <input
                type="checkbox"
                id="work"
                value="3"
                v-model="purpose"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M8,9A2,2 0 0,1 10,11A2,2 0 0,1 8,13A2,2 0 0,1 6,11A2,2 0 0,1 8,9M12,17H4V16C4,14.67 6.67,14 8,14C9.33,14 12,14.67 12,16V17M20,8H14V10H20V8M20,12H14V14H20V12M20,16H14V18H20V16M22,4H14V6H22V20H2V6H10V4H2A2,2 0 0,0 0,6V20A2,2 0 0,0 2,22H22A2,2 0 0,0 24,20V6A2,2 0 0,0 22,4M13,6H11V2H13V6Z"
                />
              </svg>
            </label>
          </div>
          <div class="shoes">
            <label class="check_purpose" title="Праздничная">
              <input
                type="checkbox"
                id="party"
                value="4"
                v-model="purpose"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M7.5,7L5.5,5H18.5L16.5,7M11,13V19H6V21H18V19H13V13L21,5V3H3V5L11,13Z"
                />
              </svg>
            </label>
          </div>
          <!-- <div class="shoes">
            <IconSport />
            <label for="sport">спортивная</label>
            <input type="checkbox" id="sport" value="2" v-model="purpose" />
          </div>
          <div class="shoes">
            <IconWork />
            <label for="work">деловая</label>
            <input type="checkbox" id="work" value="3" v-model="purpose" />
          </div>
          <div class="shoes">
            <IconParty />
            <label for="party">вечерняя</label>
            <input type="checkbox" id="party" value="4" v-model="purpose" />
          </div>-->
        </div>
      </div>
      <div class="shoes temper">
        <p>
          Минимальная температура использования:
          <span>{{ temp_from }} &#176;C</span>
        </p>
        <input type="range" min="-30" max="30" step="5" v-model="temp_from" />
        <p>
          Максимальная температура использования:
          <span>{{ temp_to }} &#176;C</span>
        </p>
        <input type="range" min="-30" max="30" step="5" v-model="temp_to" />
      </div>
      <div class="shoes shoes_weather">
        <p>Отметьте погодные условия:</p>
        <div class="shoes_purpose">
          <div class="shoes">
            <label class="check_purpose" title="солнечно">
              <input
                type="checkbox"
                id="sun"
                value="1"
                v-model="weather"
                hidden
              />
              <svg
                style="width: 70px; height: 70px"
                viewBox="0 0 35 20"
                xmlns="http://www.w3.org/2000/svg"
                fill="#2e3e78"
              >
                <path
                  d="M10 2L7.6 5.4C8.4 5.2 9.2 5 10 5C10.8 5 11.6 5.2 12.4 5.4M19 5C17.89 5 17 5.89 17 7V13.76C16.36 14.33 16 15.15 16 16C16 17.66 17.34 19 19 19C20.66 19 22 17.66 22 16C22 15.15 21.64 14.33 21 13.77V7C21 5.89 20.11 5 19 5M19 6C19.55 6 20 6.45 20 7V8H18V7C18 6.45 18.45 6 19 6M5.5 6.7L1.3 7L3.1 10.8C3.2 10 3.5 9.2 3.9 8.5C4.4 7.8 4.9 7.2 5.5 6.7M10 7C7.2 7 5 9.2 5 12C5 14.8 7.2 17 10 17C12.8 17 15 14.8 15 12C15 9.2 12.8 7 10 7M3.2 13.2L1.4 17L5.5 17.4C5 16.9 4.4 16.2 4 15.5C3.5 14.8 3.3 14 3.2 13.2M7.6 18.6L10 22L12.4 18.6C11.6 18.8 10.8 19 10 19C9.1 19 8.3 18.8 7.6 18.6Z"
                />
              </svg>
            </label>
          </div>
          <div class="shoes">
            <label class="check_purpose" title="дождь">
              <input
                type="checkbox"
                id="rain"
                value="2"
                v-model="weather"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M9,12C9.53,12.14 9.85,12.69 9.71,13.22L8.41,18.05C8.27,18.59 7.72,18.9 7.19,18.76C6.65,18.62 6.34,18.07 6.5,17.54L7.78,12.71C7.92,12.17 8.47,11.86 9,12M13,12C13.53,12.14 13.85,12.69 13.71,13.22L11.64,20.95C11.5,21.5 10.95,21.8 10.41,21.66C9.88,21.5 9.56,20.97 9.7,20.43L11.78,12.71C11.92,12.17 12.47,11.86 13,12M17,12C17.53,12.14 17.85,12.69 17.71,13.22L16.41,18.05C16.27,18.59 15.72,18.9 15.19,18.76C14.65,18.62 14.34,18.07 14.5,17.54L15.78,12.71C15.92,12.17 16.47,11.86 17,12M17,10V9A5,5 0 0,0 12,4C9.5,4 7.45,5.82 7.06,8.19C6.73,8.07 6.37,8 6,8A3,3 0 0,0 3,11C3,12.11 3.6,13.08 4.5,13.6V13.59C5,13.87 5.14,14.5 4.87,14.96C4.59,15.43 4,15.6 3.5,15.32V15.33C2,14.47 1,12.85 1,11A5,5 0 0,1 6,6C7,3.65 9.3,2 12,2C15.43,2 18.24,4.66 18.5,8.03L19,8A4,4 0 0,1 23,12C23,13.5 22.2,14.77 21,15.46V15.46C20.5,15.73 19.91,15.57 19.63,15.09C19.36,14.61 19.5,14 20,13.72V13.73C20.6,13.39 21,12.74 21,12A2,2 0 0,0 19,10H17Z"
                />
              </svg>
            </label>
          </div>
          <div class="shoes">
            <label class="check_purpose" title="грязь">
              <input
                type="checkbox"
                id="dirt"
                value="3"
                v-model="weather"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M18.14 16.7C17.23 18.21 16.08 17.73 15 17.09S12.9 15.68 12.25 16.59C11.54 17.37 12.09 18.62 12.37 19.72C12.65 20.83 12.67 21.79 10.9 22C9.5 21.81 9.58 20.65 9.81 19.42C10.04 18.19 10.4 16.89 9.5 16.43C8.78 15.95 8.28 16.78 7.65 17.6C7 18.41 6.26 19.2 5.04 18.62C3.94 17.71 4.36 17.18 4.94 16.5S6.27 14.91 5.84 13.31C5.66 12.66 4.76 12.81 3.87 12.79C3 12.77 2.12 12.59 2.03 11.29C1.96 10.5 2.55 10.18 3.16 9.93C3.78 9.68 4.41 9.5 4.42 8.87C4.45 8.26 4.04 7.83 3.78 7.38S3.41 6.46 4.03 5.76C5.08 4.9 5.92 5.63 6.76 6.42S8.43 8.04 9.46 7.39C10.28 6.85 9.53 5.9 8.95 4.97S7.96 3.15 9.46 2.74C10.76 2.38 11.26 3.27 11.71 4.3C12.17 5.33 12.57 6.5 13.67 6.71C15.24 7 16.38 5.16 17.47 3.7S19.63 1.15 21 2.95C22.5 4.84 21.07 5.72 19.4 6.5C17.73 7.23 15.81 7.87 16.27 9.28C16.54 10.1 17.42 9.65 18.35 9.34C19.27 9.03 20.26 8.86 20.74 10.27C21.25 11.76 20.04 12.1 18.68 12.24C17.32 12.38 15.8 12.32 15.7 13C15.59 13.71 16.5 14 17.29 14.42C18.08 14.85 18.75 15.42 18.14 16.7M20.5 19C19.55 19 19.06 18.26 19.06 17.5C19.06 16.74 19.54 16 20.5 16C21.5 16 22 16.74 22 17.5C22 18.26 21.5 19 20.5 19Z"
                />
              </svg>
            </label>
          </div>
          <div class="shoes">
            <label class="check_purpose" title="снег">
              <input
                type="checkbox"
                id="snow"
                value="4"
                v-model="weather"
                hidden
              />
              <svg style="width: 70px; height: 70px" viewBox="0 0 35 20">
                <path
                  fill="#2e3e78"
                  d="M4,16.36C3.86,15.82 4.18,15.25 4.73,15.11L7,14.5L5.33,12.86C4.93,12.46 4.93,11.81 5.33,11.4C5.73,11 6.4,11 6.79,11.4L8.45,13.05L9.04,10.8C9.18,10.24 9.75,9.92 10.29,10.07C10.85,10.21 11.17,10.78 11,11.33L10.42,13.58L12.67,13C13.22,12.83 13.79,13.15 13.93,13.71C14.08,14.25 13.76,14.82 13.2,14.96L10.95,15.55L12.6,17.21C13,17.6 13,18.27 12.6,18.67C12.2,19.07 11.54,19.07 11.15,18.67L9.5,17L8.89,19.27C8.75,19.83 8.18,20.14 7.64,20C7.08,19.86 6.77,19.29 6.91,18.74L7.5,16.5L5.26,17.09C4.71,17.23 4.14,16.92 4,16.36M1,10A5,5 0 0,1 6,5C7,2.65 9.3,1 12,1C15.43,1 18.24,3.66 18.5,7.03L19,7A4,4 0 0,1 23,11A4,4 0 0,1 19,15A1,1 0 0,1 18,14A1,1 0 0,1 19,13A2,2 0 0,0 21,11A2,2 0 0,0 19,9H17V8A5,5 0 0,0 12,3C9.5,3 7.45,4.82 7.06,7.19C6.73,7.07 6.37,7 6,7A3,3 0 0,0 3,10C3,10.85 3.35,11.61 3.91,12.16C4.27,12.55 4.26,13.16 3.88,13.54C3.5,13.93 2.85,13.93 2.47,13.54C1.56,12.63 1,11.38 1,10M14.03,20.43C14.13,20.82 14.5,21.04 14.91,20.94L16.5,20.5L16.06,22.09C15.96,22.5 16.18,22.87 16.57,22.97C16.95,23.08 17.35,22.85 17.45,22.46L17.86,20.89L19.03,22.05C19.3,22.33 19.77,22.33 20.05,22.05C20.33,21.77 20.33,21.3 20.05,21.03L18.89,19.86L20.46,19.45C20.85,19.35 21.08,18.95 20.97,18.57C20.87,18.18 20.5,17.96 20.09,18.06L18.5,18.5L18.94,16.91C19.04,16.5 18.82,16.13 18.43,16.03C18.05,15.92 17.65,16.15 17.55,16.54L17.14,18.11L15.97,16.95C15.7,16.67 15.23,16.67 14.95,16.95C14.67,17.24 14.67,17.7 14.95,17.97L16.11,19.14L14.54,19.55C14.15,19.65 13.92,20.05 14.03,20.43Z"
                />
              </svg>
            </label>
          </div>
          <!--<IconSun />
            <label for="sun">сухо</label>
            <input type="checkbox" id="sun" value="1" v-model="weather" />
            <IconRain />
            <label for="rain">дождь</label>
            <input type="checkbox" id="rain" value="2" v-model="weather" />
            <IconSpot />
            <label for="dirt">грязь</label>
            <input type="checkbox" id="dirt" value="3" v-model="weather" />
            <IconSnow />
            <label for="snow">снег</label>
            <input type="checkbox" id="snow" value="4" v-model="weather" />-->
        </div>
      </div>
      <button
        class="shoes_save_button"
        type="submit"
        @click.prevent="prepareCardForm"
      >
        Сохранить
      </button>
    </form>
  </div>
</template>

<style scoped>
/*.shoes_card_form {
  display: flex;
  width: 60vw;
  flex-direction: column;
}
.shoes {
  display: flex;
  flex-direction: column;
  margin-bottom: 1em;
  position: relative;
}
.shoes_img__label {
  display: block;
  border: 1px solid black;
  width: auto;
  height: 10vh;
  cursor: pointer;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
}
.shoes_img {
  display: none;
}
.shoes_purpose {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}*/
</style>
