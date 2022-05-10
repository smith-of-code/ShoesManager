<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from "vue";
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
import { useRouter } from "vue-router";


//передача через роутер номера id обуви
const cardID = defineProps({
  id: {
    type: String,
    default: "",
  },
});

//получаемый объект обуви для редактирования
const shoesData = reactive([]);

//загрузка карточки обуви, если в модуль передано id
if (cardID.id) {
  onBeforeMount(() => {
    console.log("cardID ", cardID.id);
    axios
      .get(`/api/shoes/${cardID.id}`)
      .then((response) => {
        shoesData.value = response.data;
        console.log("response ", shoesData.value);
        console.log("id ", shoesData.value.id);
      })
      .catch((error) => {
        error.response.data;
      });
  });
}

//***БЛОК ПЕРЕМЕННЫХ***
//наименование обуви
const name = ref("");
//изображение обуви:
//картинка
const photo = reactive({});
const photoName = ref("");
//фоновая картинка
const pathPhoto = ref(shoesBackground);
//назначение обуви
const purpose = ref([]);
//температура от
const temp_from = ref(-5);
//температура до
const temp_to = ref(5);
//погодные условия
const weather = ref([]);
const router = useRouter();

const deltaTemp = computed(() => {
  return temp_to.value - temp_from.value;
});

const note = computed(() => {
  return deltaTemp.value == 0;
});

watch(
  () => deltaTemp.value,
  () => {
    note.value = false;
    if (deltaTemp.value < 0) {
      temp_from.value -= 5;
    }
  }
);

//следит, если id передан, подгружает данные пары в текущие переменный
//ситуация для редактирования карточки обуви
watch(
  () => shoesData.value,
  () => {
    name.value = shoesData.value.name;
    pathPhoto.value = `/storage/shoes_img/` + shoesData.value.photo_path;
    [...purpose.value] = shoesData.value.purposes_ids;
    temp_from.value = shoesData.value.temp_from;
    temp_to.value = shoesData.value.temp_to;
    [...weather.value] = shoesData.value.weathers_ids;
  }
);

//объект всех данных формы при "отправить"
let formData = new FormData();

//загрузка выбранного изображения,
//ЕСЛИ! загрузка через тег input type="file"
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

//фоормируем, отправляем и очищаем файл отправки данных карточки !photo.value ||
function prepareCardForm() {
  if (!name.value) {
    //временная заглушка вместо валидации введенного имени
    alert("Введите имя обуви");
    return;
  }
  if (!cardID.id) {
    //для новой карточки
    if (!photo.value) {
      //временная заглушка вместо валидации введенного имени
      alert("Загрузите изображение обуви");
      return;
    }
    formData.append("name", name.value);
    formData.append("photo", photo.value);
    for (let i = 0; i < purpose.value.length; i++) {
      formData.append(`purposesIds[${i}]`, purpose.value[i]);
    }
    formData.append("temp_from", temp_from.value);
    formData.append("temp_to", temp_to.value);
    for (let i = 0; i < weather.value.length; i++) {
      formData.append(`weathersIds[${i}]`, weather.value[i]);
    }
    axios.post("/api/shoes", formData);
    for (let entry of formData.entries()) {
      console.log("output new", entry);
    }
  } else {//для карточки, которая уже была и редактируется
        if (name.value != shoesData.value.name) formData.append("name", name.value);
        if (photo.value) formData.append("photo", photo.value);

    if (JSON.stringify(purpose.value) != JSON.stringify(shoesData.value.purposes_ids)){
    //purpose.value.forEach((e,i)=>formData.append(`purposesIds[${i}]`, e[i]));
    //forEach в применении к данному алгоритму не работает корректно при пропущенных элементах массива!
        for (let i = 0; i < purpose.value.length; i++) {
            formData.append(`purposesIds[${i}]`, purpose.value[i]);
        }
    }
    if (temp_from.value != shoesData.value.temp_from)
      formData.append("temp_from", temp_from.value);
    if (temp_to.value != shoesData.value.temp_to)
      formData.append("temp_to", temp_to.value);
    if (JSON.stringify(weather.value) != JSON.stringify(shoesData.value.weathers_ids)){
        for (let i = 0; i < weather.value.length; i++) {
      formData.append(`weathersIds[${i}]`, weather.value[i]);
        }
    }
    axios.post(`/api/shoes/${cardID.id}`, formData);
    for (let entry of formData.entries()) {
      console.log("output old", entry);
    }
    goToListing();
  }

  //очистка файла передачи данных
  formData = new FormData();
  //очистка исходных данных формы до ввода следующей пары
  name.value = "";
  photo.value = {};
  photoName.value ="";
  pathPhoto.value = shoesBackground;
  purpose.value = [];
  temp_from.value = -5;
  temp_to.value = 5;
  weather.value = [];

  console.log("объект передачи данных на сервер очищен...", cardID.id);
  //   for (let entry of formData.entries()) {
  //     console.log("output ", entry);
  //   }

}

//возврат на страницу листинга обуви
function goToListing() {
    router.push({ path: '/list' });
}
</script>

<template>
  <div class="container">
    <form class="shoes_card_form" method="post" enctype="multipart/form-data">
      <h1 class="shoes_card_form_title">Карточка обуви</h1>
      <div class="shoes shoes_name">
        <label for="shoes-name">
          <input
            placeholder="Ваша любимая пара"
            type="text"
            id="shoes-name"
            class="shoes_name__input"
            v-model="name"
            required
          />
        </label>
      </div>

      <div class="shoes shoes_photo">
        <!--<p>Выбрать/поменять изображение обуви</p>-->
        <!-- Надежда, это НУЖНО для загрузки изображения
         из РЕДАКТИРУЕМОЙ карточки, когда осуществляется
          переход из листинга
          :style="{ backgroundImage: `url(${pathPhoto})` }
          Если не нравиться условное изображение пары при новой карточке,
           просто удали его программно:) или мне скажи, сделаю (Александр)
           ВРЕМЕННО включил стиль shoes_img__label в локальной оласти компонента,
            инае не видно изображения обуви.
           Кога будешь по своему делать, проверь, пожалуйста, чтобы обувь появлялась
           при переходе из компонента/страницы списка обуви в карточке"  -->
        <label
          class="shoes_img__label"
          for="shoes-img"
          :style="{ backgroundImage: `url(${pathPhoto})` }"
        >
          <input
            class="shoes_img"
            type="file"
            id="shoes-img"
            accept="image/*"
            @change="onChangeFile"
            name="file"
          />
          <div class="shoes_img__tag">Загрузить изображение:</div>
          <div class="shoes_img__load_foto">{{ photoName }}</div>
        </label>
      </div>
      <div class="shoes">
        <p>Отметьте назначение обуви:</p>
        <div class="shoes_purpose">
          <div class="shoes">
            <label class="check_purpose" title="Повседневная">
              <input
                type="checkbox"
                id="casual"
                value="1"
                v-model="purpose"
                hidden
              />
              <IconCasual :width="40" :height="40" :color="`#000000`" />
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
              <!-- у иконок можно задавать цвет и размеры -->
              <IconSport :width="40" :height="40" :color="`#000000`" />
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
              <IconWork :width="40" :height="40" :color="`#000000`" />
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
              <IconParty :width="40" :height="40" :color="`#000000`" />
            </label>
          </div>
        </div>
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
              <IconSun :width="40" :height="40" :color="`#000000`" />
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
              <IconRain :width="40" :height="40" :color="`#000000`" />
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
              <IconSpot :width="40" :height="40" :color="`#000000`" />
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
              <IconSnow :width="40" :height="40" :color="`#000000`" />
            </label>
          </div>
        </div>
      </div>
      <div class="shoes temper">
        <div class="range_label">
          Минимальная температура использования:
          <span>{{ temp_from }} &#176;C</span>
        </div>
        <input type="range" min="-30" max="30" step="5" v-model="temp_from" />
        <div class="range_label">
          Максимальная температура использования:
          <span>{{ temp_to }} &#176;C</span>
        </div>
        <input type="range" min="-30" max="30" step="5" v-model="temp_to" />
        <div class="temper_note" v-show="note">
          Макисмальная температура не может быть ниже минимальной
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
    <!-- блок слева с картинками и фоном -->
    <div class="shoes_card_img">
      <div class="shoes_card_backimg"></div>
      <div class="shoes_card_titel_img">
        <img src="storage/shoes_img/cardlogo.jpg" alt="" />
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
