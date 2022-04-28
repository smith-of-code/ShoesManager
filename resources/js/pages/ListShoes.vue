<template>
  <h1>Список вашей обуви</h1>
  <div>
    <label for="shoes-search">Укажите название пары</label>
    <input type="search" id="shoes-search" name="q" v-model="searchWord" />
    <!-- <button @click="fff">Поиск</button> -->
  </div>
  <div>
    <li v-for="(item, index) in listSearch.value" :key="index" class="serch_item">
      <img :src="`/storage/shoes_img/` + item.photo_path" alt="picture" />
      <SearchList style="width: 10vw">{{ item.name }}</SearchList>
      <SearchList style="width: 20vw">
        <div v-for="(ids, index) in item.purposes_ids" :key="index">
          <div v-if="ids === 1"><IconCasual :width="30" :height="30" /></div>
          <div v-if="ids === 2"><IconSport :width="30" :height="30" /></div>
          <div v-if="ids === 3"><IconWork :width="30" :height="30" /></div>
          <div v-if="ids === 4"><IconParty :width="30" :height="30" /></div>
        </div>
      </SearchList>

      <SearchList style="width: 8vw"
        ><span>От&nbsp;t&nbsp;</span>{{ item.temp_from }}</SearchList
      >
      <SearchList style="width: 8vw"
        ><span>До&nbsp;t&nbsp;</span>{{ item.temp_to }}</SearchList
      >
      <SearchList style="width: 20vw">
        <div v-for="(ids, index) in item.weathers_ids" :key="index">
          <div v-if="ids === 1"><IconSun :width="30" :height="30" /></div>
          <div v-if="ids === 2"><IconRain :width="30" :height="30" /></div>
          <div v-if="ids === 3"><IconSpot :width="30" :height="30" /></div>
          <div v-if="ids === 4"><IconSnow :width="30" :height="30" /></div>
        </div>
      </SearchList>
      <button @click="editCard(item.id)"><IconEdit :width="30" :height="30" /></button>
      <button @click="deleteCard(item.id)"><IconTrash :width="30" :height="30" /></button>
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

let searchWord = ref("");
const shoesStore = reactive([]);
const listSearch = reactive([]);
const router = useRouter();

//загрузка списка обуви
onMounted(async () => {
  await axios
    .get("/api/shoes")
    .then((response) => {
      shoesStore.value = response.data;
      //console.log(response.status, shoesStore.value);
      listSearch.value = shoesStore.value;
    })
    .catch((error) => {
      error.response.data;
    });
});

//динамический поиск и вывод результата
watch(
  () => searchWord.value,
  () => {
    listSearch.value = shoesStore.value.filter(
      (e) => e.name.indexOf(searchWord.value) != -1
    );
  }
);
//передача id обуви в карточку редактирования
function editCard(shoesID) {
  //  console.log("id ", shoesID);
  router.push({ name: "CardID", params: { id: shoesID } });
}
//удаление карточки
function deleteCard(shoesID) {
  axios.delete(`/api/shoes/${shoesID}`);
}
</script>

<style scoped>
.serch_item {
  display: flex;
  flex-direction: row;
  height: 10vh;
  border: 1px solid rgb(52, 143, 56);
}
</style>
