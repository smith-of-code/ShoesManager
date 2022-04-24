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
      <SearchList style="width: 20vw">{{ item.purposes }}</SearchList>
      <SearchList style="width: 8vw"
        ><span>От&nbsp;t&nbsp;</span>{{ item.temp_from }}</SearchList
      >
      <SearchList style="width: 8vw"
        ><span>До&nbsp;t&nbsp;</span>{{ item.temp_to }}</SearchList
      >
      <SearchList style="width: 20vw">{{ item.weathers }}</SearchList>
    </li>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, reactive, watch, onMounted } from "vue";
import SearchList from "../components/slot/SearchList.vue";

let searchWord = ref("");
const shoesStore = reactive([]);
const listSearch = reactive([]);

onMounted(async () => {
  await axios
    .get("/api/shoes")
    .then((response) => {
      shoesStore.value = response.data;
      console.log(response.status, shoesStore.value);
      listSearch.value = shoesStore.value;
    })
    .catch((error) => {
      error.response.data;
    });
});

//   function fff() {
//   if (!searchWord.value) {
//   listSearch.value = shoesStore.value;
//   return;
//   }
//   listSearch.value = shoesStore.value.filter(
//     (e) => e.name.indexOf(searchWord.value) != -1
//   );
//   }

watch(
  () => searchWord.value,
  () => {
    listSearch.value = shoesStore.value.filter(
      (e) => e.name.indexOf(searchWord.value) != -1
    );
  }
);
</script>

<style scoped>
.serch_item {
  display: flex;
  flex-direction: row;
  height: 10vh;
  border: 1px solid rgb(52, 143, 56);
}
</style>
