<script setup>
import { reactive, ref } from "vue";
import IconSun from "./icons/IconSun.vue";
import IconRain from "./icons/IconRain.vue";
import IconSpot from "./icons/IconSpot.vue";
import IconSnow from "./icons/IconSnow.vue";
import IconWork from "./icons/IconWork.vue";
import IconSport from "./icons/IconSport.vue";
import IconCasual from "./icons/IconCasual.vue";
import IconParty from "./icons/IconParty.vue";

//наименование обуви
const name = ref("");
//изображение обуви
const shoesPicture = reactive({});
const photo_path = ref("");
//назначение обуви
const purpose_id = ref(["повседневная"]);
//температура от
const temp_from = ref(-5);
//температура до
const temp_to = ref(5);
//погодные условия
const weather_id = ref(["сухо"]);
//объект всех данных формы при "отправить"
let formData = new FormData();

function onChangeFile(e) {
  shoesPicture.value = e.target.files[0];
  photo_path.value = e.target.value;
  console.log("file ", shoesPicture.value, "path ", photo_path.value);
}

function prepareCardForm() {
  formData.append("name", name.value);
  formData.append("photo_file", shoesPicture.value);
  formData.append("photo_path", photo_path.value);
  formData.append("purpose_id", purpose_id.value);
  formData.append("temp_from", temp_from.value);
  formData.append("temp_to", temp_to.value);
  formData.append("weather_id", weather_id.value);
  console.log("output ", formData);
}
</script>

<template>
  <form class="shoes_card_form" method="post" enctype="multipart/form-data">
    <div class="shoes">
      <label for="shoes-name">Введите название обуви</label>
      <input type="text" id="shoes-name" v-model="name" />
    </div>
    <div class="shoes">
      <p>Выбрать/поменять изображение обуви</p>
      <label class="shoes_img__label" for="shoes-img"></label>
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
          <input type="checkbox" id="casual" value="повседневная" v-model="purpose_id" />
        </div>
        <div class="shoes">
          <IconSport />
          <label for="sport">спортивная</label>
          <input type="checkbox" id="sport" value="спортивная" v-model="purpose_id" />
        </div>
        <div class="shoes">
          <IconWork />
          <label for="work">деловая</label>
          <input type="checkbox" id="work" value="деловая" v-model="purpose_id" />
        </div>
        <div class="shoes">
          <IconParty />
          <label for="party">вечерняя</label>
          <input type="checkbox" id="party" value="вечерняя" v-model="purpose_id" />
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
          <input type="checkbox" id="sun" value="сухо" v-model="weather_id" />
        </div>
        <div class="shoes">
          <IconRain />
          <label for="rain">дождь</label>
          <input type="checkbox" id="rain" value="дождь" v-model="weather_id" />
        </div>
        <div class="shoes">
          <IconSpot />
          <label for="dirt">грязь</label>
          <input type="checkbox" id="dirt" value="грязь" v-model="weather_id" />
        </div>
        <div class="shoes">
          <IconSnow />
          <label for="snow">снег</label>
          <input type="checkbox" id="snow" value="снег" v-model="weather_id" />
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
}
.shoes_img__label {
  display: block;
  border: 1px solid black;
  width: auto;
  height: 10vh;
  cursor: pointer;
  background-image: url("../assets/images/ShoesPicture.jpg");
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
