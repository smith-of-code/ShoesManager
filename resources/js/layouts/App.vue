<template>
  <div class="main__window">
    <div class="mainmenu" id="nav">
      <div class="mainmenu_titel__text">
        Менеджер обуви
        <div v-show="!$attrs.isAuth">
          <a class="home__btn" href="/auth/signin">Вход/Регистрация</a>
        </div>
      </div>
      <div class="mainmenu_router" v-if="$attrs.isAuth">
        <!-- <div class="mainmenu_router__mask"></div> -->
        <!-- просто блок маски для прирывистой границы блока. Можно убрать, если меню не нужно как в макете  -->
        <div class="mainmenu_router__box">
          <!-- блок меню для планшета и телефона -->
          <input id="hamburger__check" type="checkbox" />
          <label class="hamburger__btn" for="hamburger__check">
            <span></span>
          </label>
          <!-- конец блока меню для планшета и телефона -->
          <div class="hamburger__list">
            <router-link class="mainmenu__item mainmenu__item_glavnaya" to="/"
              >Главная</router-link
            >
            <router-link class="mainmenu__item mainmenu__item_cartochka" to="/card"
              >Карточка обуви</router-link
            >
            <router-link class="mainmenu__item mainmenu__item_kollekcya" to="/list"
              >Моя коллекция</router-link
            >
            <router-link class="mainmenu__item mainmenu__item_recomend" to="/adviser"
              >Рекомендации</router-link
            ><router-link class="mainmenu__item mainmenu__item_obuchen" to="/about"
              >Обучение</router-link
            >
            <!-- <a class="mainmenu__item exit" href="/auth/signout">Выход</a> -->
          </div>
        </div>
      </div>
    </div>
    <router-view />
  </div>
</template>

<script setup></script>

<style scoped></style>
