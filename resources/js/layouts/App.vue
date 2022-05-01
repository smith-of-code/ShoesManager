<template>
  <div class="mainmenu" id="nav">
    <router-link class="mainmenu__item" to="/">Главная</router-link>
    <router-link class="mainmenu__item" to="/card">Карточка обуви</router-link>
    <router-link class="mainmenu__item" to="/list">Моя коллекция</router-link>
    <router-link class="mainmenu__item" to="/adviser">Рекомендации</router-link>
      <a href="/auth/signout">Выход</a>
  </div>
  <router-view />
</template>

<script setup></script>

<style scoped></style>
