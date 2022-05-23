<template>
  <div class="home__container">
    <div class="home__info">
      <h1 class="home__title">Ваш личный менеджер обуви</h1>
      <p>Менеджер поможет Вам навести порядок в имеющейся у Вас обуви.</p>
      <p>
        Приложение позволяет каталогизировать имеющиеся пары по различным характеристикам:
      </p>
      <li class="home__discribe">подходящая погода;</li>
      <li class="home__discribe">температура;</li>
      <li class="home__discribe">назначение;</li>

      <p>Поможет подобрать пару по заданным параметрам, а также решит вопрос:</p>
      <p><b>"что же сегодня надеть?"</b></p>
      <p>На основе актуального прогноза погоды вашего города.</p>
    </div>
    <a class="home__btn" href="/auth/signin">Вход/Регистрация</a>
    <div class="home__foto">
      <img :src="homeLogo" alt="Картинка0" />
      <!-- <img src="storage/images/home_logo.jpg" alt="Картинка0" /> -->
    </div>
  </div>
</template>

<script setup>
import homeLogo from "../../../storage/app/public/images/home_logo.jpg";
</script>

<style scoped></style>
