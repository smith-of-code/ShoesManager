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
  for (let i = 0; i < purpose.value.length; i++) {
    formData.append(`purposesIds${[i]}`, purpose.value[i]);
  }
  formData.append("temp_from", temp_from.value);
  formData.append("temp_to", temp_to.value);
  for (let i = 0; i < weather.value.length; i++) {
    formData.append(`weathersIds${[i]}`, weather.value[i]);
  }
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
  <h1>Ввод и редактирование карточки обуви</h1>
  <form class="shoes_card_form" method="post" enctype="multipart/form-data">
    <div class="shoes">
      <label for="shoes-name">Введите название обуви</label>
      <input type="text" id="shoes-name" v-model="name" required />
    </div>
    <div class="shoes">
      <p>Выбрать/поменять изображение обуви</p>
      <label
        class="shoes_img__label"
        for="shoes-img"
        :style="{ backgroundImage: `url(${pathPhoto})` }"
      ></label>
      <input
        class="shoes_img"
        type="file"
        id="shoes-img"
        accept="image/*"
        @change="onChangeFile"
        name="file"
      />
    </div>
    <div class="shoes">
      <p>Назначение обуви, можно выбрать несколько вариантов:</p>
      <div class="shoes_purpose">
        <div class="shoes">
          <IconCasual />
          <label for="casual">повседневная</label>
          <input type="checkbox" id="casual" value="1" v-model="purpose" />
        </div>
        <div class="shoes">
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
        </div>
      </div>
    </div>
    <div class="shoes">
      <p>Задайте температурный режим эксплуатации:</p>
      <p>
        Минимальная температура носки:<span>{{ temp_from }}C</span>
      </p>
      <input type="range" min="-30" max="30" step="5" v-model="temp_from" />
      <p>
        Максимальная температура носки:<span>{{ temp_to }}C</span>
      </p>
      <input type="range" min="-30" max="30" step="5" v-model="temp_to" />
    </div>
    <div class="shoes">
      <p>Погодные условия носки, можно выбрать несколько вариантов:</p>
      <div class="shoes_purpose">
        <div class="shoes">
          <IconSun />
          <label for="sun">сухо</label>
          <input type="checkbox" id="sun" value="1" v-model="weather" />
        </div>
        <div class="shoes">
          <IconRain />
          <label for="rain">дождь</label>
          <input type="checkbox" id="rain" value="2" v-model="weather" />
        </div>
        <div class="shoes">
          <IconSpot />
          <label for="dirt">грязь</label>
          <input type="checkbox" id="dirt" value="3" v-model="weather" />
        </div>
        <div class="shoes">
          <IconSnow />
          <label for="snow">снег</label>
          <input type="checkbox" id="snow" value="4" v-model="weather" />
        </div>
      </div>
    </div>
    <button type="submit" @click.prevent="prepareCardForm">Отправить</button>
  </form>
</template>

<style scoped>
.shoes_card_form {
  display: flex;
  width: 60vw;
  flex-direction: column;
  margin: 0 auto;
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
}
</style>
