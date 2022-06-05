<template>
  <div class="container collection_container collection_container_bgr">
    <h1 class="collection_header">Список вашей обуви</h1>
    <div class="collection__filter">
      <label for="shoes-search">
        <input
          class="collection__filtr_input"
          placeholder="Укажите название пары"
          type="search"
          id="shoes-search"
          name="q"
          v-model="searchWord"
        />
      </label>
      <button @click="eraseAll" class="collection__filtr_btn">Сбросить фильтры</button>
    </div>
    <div class="collection__lowblock">
      <div class="collection__purpose">
        <div class="collection__title collection__title_lf">Назначение пары:</div>
        <div class="collection__icons">
          <label for="casual" class="check_purpose" title="Повседневная">
            <input type="checkbox" id="casual" value="1" v-model="searchPurpose" hidden />
            <IconCasual :width="40" :height="40" :color="iconColor" />
          </label>
          <label class="check_purpose" title="Спортивная">
            <input type="checkbox" id="sport" value="2" v-model="searchPurpose" hidden />
            <IconSport :width="40" :height="40" :color="iconColor" />
          </label>
          <label class="check_purpose" title="Деловая">
            <input type="checkbox" id="work" value="3" v-model="searchPurpose" hidden />
            <IconWork :width="40" :height="40" :color="iconColor" />
          </label>
          <label class="check_purpose check_purpose_rt" title="Праздничная">
            <input type="checkbox" id="party" value="4" v-model="searchPurpose" hidden />
            <IconParty :width="40" :height="40" :color="iconColor" />
          </label>
        </div>
      </div>
      <div class="collection__temper">
        <div class="collection__title_weather">
          Температура ношения:
          <span>{{ searchTemp }}&nbsp;C</span>
        </div>
        <input type="range" min="-30" max="30" step="5" v-model="searchTemp" />
      </div>
      <div class="collection__weather">
        <div class="collection__title collection__title_rt">
          Укажите погодные условия:
        </div>
        <div class="collection__icons">
          <label class="check_purpose" title="солнечно">
            <input type="checkbox" id="sun" value="1" v-model="searchWeather" hidden />
            <IconSun :width="40" :height="40" :color="iconColor" />
          </label>
          <label class="check_purpose" title="дождь">
            <input type="checkbox" id="rain" value="2" v-model="searchWeather" hidden />
            <IconRain :width="40" :height="40" :color="iconColor" />
          </label>
          <label class="check_purpose" title="грязь">
            <input type="checkbox" id="dirt" value="3" v-model="searchWeather" hidden />
            <IconSpot :width="40" :height="40" :color="iconColor" />
          </label>
          <label class="check_purpose check_purpose_rt" title="снег">
            <input type="checkbox" id="snow" value="4" v-model="searchWeather" hidden />
            <IconSnow :width="40" :height="40" :color="iconColor" />
          </label>
        </div>
      </div>
    </div>
  </div>
  <div>
    <li v-for="(item, index) in listSearch.value" :key="index" class="serch_item">
      <img
        class="collection_img"
        :src="`/storage/shoes_img/` + item.photo_path"
        alt="picture"
      />
      <SearchList style="width: 15vw; justify-content: flex-start">{{
        item.name
      }}</SearchList>
      <SearchList style="width: 14vw">
        <div v-for="(ids, index) in item.purposes_ids" :key="index" class="">
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

      <SearchList style="width: 10vw"
        ><span>от&nbsp;&nbsp;</span
        ><span :class="[item.temp_from <= 0 ? lowTemp : highTemp]"
          >{{ item.temp_from }}C°</span
        ></SearchList
      >
      <SearchList style="width: 10vw"
        ><span>до&nbsp;&nbsp;</span
        ><span :class="[item.temp_to <= 0 ? lowTemp : highTemp]"
          >{{ item.temp_to }}C°</span
        ></SearchList
      >
      <SearchList style="width: 14vw">
        <div v-for="(ids, index) in item.weathers_ids" :key="index" class="">
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
      <div class="collection_buttons" style="width: 12vw">
        <button class="collection__edit_btn" @click="editCard(item.id)">
          <IconEdit :width="30" :height="30" :color="`#ffffff`" />
        </button>
        <button
          class="collection__edit_btn collection__delete_btn"
          @click="deleteCard(item.id)"
        >
          <IconTrash :width="30" :height="30" :color="`#ffffff`" />
        </button>
      </div>
    </li>
  </div>
</template>

<script setup>
import IconSun from "../components/icons/IconSun.vue";
import IconRain from "../components/icons/IconRain.vue";
import IconSpot from "../components/icons/IconSpot.vue";
import IconSnow from "../components/icons/IconSnow.vue";
import IconWork from "../components/icons/IconWork.vue";
import IconSport from "../components/icons/IconSport.vue";
import IconCasual from "../components/icons/IconCasual.vue";
import IconParty from "../components/icons/IconParty.vue";
import IconEdit from "../components/icons/IconEdit.vue";
import IconTrash from "../components/icons/IconTrash.vue";
import axios from "axios";
import { ref, reactive, watch, onMounted } from "vue";
import { useRouter } from "vue-router";

import SearchList from "../components/slot/SearchList.vue";

//поиск по названию
const searchWord = ref("");
//выбор назначения обуви
const searchPurpose = ref([]);
//выбор температуры
const searchTemp = ref(0);
//выбор погодных условий
const searchWeather = ref([]);
const shoesStore = reactive([]);
const listSearch = reactive([]);
const router = useRouter();
const lowTemp = ref("temp_low");
const highTemp = ref("temp_high");
const iconColor = ref(`#800000`);
//непосредственно загрузчик обуви
const loader = async () => {
  await axios
    .get("/api/shoes")
    .then((response) => {
      shoesStore.value = response.data;
      //console.log(response.status, shoesStore.value);
      storeList(shoesStore.value);
      listSearch.value = shoesStore.value;
    })
    .catch((error) => {
      error.response.data;
    });
};

function storeList(listForSort) {
  //сортировка списка обуви от большей к меньшей средней температуре ношения
  //console.log("listForSort BEFORE", listForSort);
  //console.log("temp0", listForSort[0].temp_from);
  function middleVar(c, d) {
    //вычисляем среднюю температуру ношения пары
    return (c + d) / 2;
  }
  listForSort.sort(function (a, b) {
    if (middleVar(a.temp_from, a.temp_to) < middleVar(b.temp_from, b.temp_to)) {
      return 1;
    }
    if (middleVar(a.temp_from, a.temp_to) > middleVar(b.temp_from, b.temp_to)) {
      return -1;
    }
    // a должно быть равным b
    return 0;
  });
  //console.log("listForSort AFTER", listForSort);
}

//загрузка списка обуви при первой отрисовке
onMounted(async () => {
  loader();
});

//динамический поиск и вывод результата волатилен к прописным и строчным
watch(
  //сортируем по названию
  () => searchWord.value,
  () => {
    listSearch.value = shoesStore.value.filter(
      (e) => e.name.toLowerCase().indexOf(searchWord.value.toLowerCase()) != -1
    );
  }
);

watch(
  //сортируем по назначению
  () => searchPurpose.value,
  () => {
    if (searchPurpose.value.length !== 0) {
      //console.log("searchPurpose.value ", searchPurpose.value);
      let lastElement = searchPurpose.value[searchPurpose.value.length - 1];
      console.log("lastElement P", lastElement);
      if (lastElement !== undefined) {
        listSearch.value = shoesStore.value.filter((e) => {
          return e.purposes_ids.filter((element) => {
            return element == lastElement;
          }).length;
        });
      }
    } else loader();
  }
);

watch(
  //сортируем по температуре
  () => searchTemp.value,
  () => {
    listSearch.value = shoesStore.value.filter(
      (e) => searchTemp.value >= e.temp_from && searchTemp.value <= e.temp_to
    );
  }
);

watch(
  //сортируем по погоде
  () => searchWeather.value,
  () => {
    if (searchWeather.value.length !== 0) {
      //console.log("searchWeather.value ", searchWeather.value);
      let lastElement = searchWeather.value[searchWeather.value.length - 1];
      console.log("lastElement W ", lastElement);
      if (lastElement !== undefined) {
        listSearch.value = shoesStore.value.filter((e) => {
          return e.weathers_ids.filter((element) => {
            return element == lastElement;
          }).length;
        });
      }
    } else loader();
  }
);

//очистка полей фильтров
function eraseAll() {
  searchWord.value = "";
  searchPurpose.value = [];
  searchTemp.value = 0;
  searchWeather.value = [];
  loader();
}

//передача id обуви в карточку редактирования
function editCard(shoesID) {
  //  console.log("id ", shoesID);
  router.push({ name: "CardID", params: { id: shoesID } });
}

//удаление карточки
function deleteCard(shoesID) {
  axios.delete(`/api/shoes/${shoesID}`).then((response) => {
    console.log("delete", response);
    //loader() ради принудительного обновления страницы
    loader();
  });
}
</script>

<style scoped>
/* .serch_item {
  display: flex;
  flex-direction: row;
  height: 10vh;
  border: 1px solid rgb(52, 143, 56);
}
.search {
  display: flex;
} */
</style>
