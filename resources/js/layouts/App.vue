<template>
  <div class="mainmenu" id="nav">
    <div class="mainmenu_titel">
      <div class="mainmenu_titel__text">Менеджер обуви</div>
      <img
        class="mainmenu_titel__logo"
        src="storage/images/bootlogo.png"
        alt="logo"
      />
    </div>
    <div class="mainmenu_router" v-if="$attrs.isAuth">
      <div class="mainmenu_router__mask"></div>
      <!-- просто блок маски для прирывистой границы блока. Можно убрать, если меню не нужно как в макете  -->
      <div class="mainmenu_router__box">
        <!-- блок меню для планшета и телефона -->
        <input id="hamburger__check" type="checkbox" />
        <label class="hamburger__btn" for="hamburger__check">
          <span></span>
        </label>
        <!-- конец блока меню для планшета и телефона -->
        <div class="hamburger__list">
          <router-link class="mainmenu__item" to="/">Главная</router-link>
          <router-link class="mainmenu__item" to="/card"
            >Карточка обуви</router-link
          >
          <router-link class="mainmenu__item" to="/list"
            >Моя коллекция</router-link
          >
          <router-link class="mainmenu__item" to="/adviser"
            >Рекомендации</router-link
          >
          <a class="mainmenu__item exit" href="/auth/signout">Выход</a>
        </div>
      </div>
    </div>
  </div>
  <router-view />
</template>
<script setup></script>
<style scoped></style>
