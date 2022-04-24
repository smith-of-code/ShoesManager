<template>
  <div id="nav">
    <router-link to="/">Home</router-link> |
    <router-link to="/card">Запись и редактирование карточки обуви</router-link> |
    <router-link to="/list">Посмотреть список обуви</router-link>
  </div>
  <router-view />
</template>

<script>
export default {
  name: "App",
};
</script>

<style scoped></style>
