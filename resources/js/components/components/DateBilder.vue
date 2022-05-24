<template>
  <div class="adviser__label">
    Сейчас&nbsp;{{ currentDate.day }},&nbsp; {{ currentDate.period }}.
  </div>
</template>

<script setup>
const currentDate = [];

const emit = defineEmits(["ondaydata"]);

let d = new Date();

let days = [
  "воскресенье",
  "понедельник",
  "вторник",
  "среда",
  "четверг",
  "пятница",
  "суббота",
];

currentDate.day = days[d.getDay()];
currentDate.hour = d.getHours();

if (currentDate.hour > 4 && currentDate.hour < 11) currentDate.period = "утро";
else if (currentDate.hour > 10 && currentDate.hour < 18)
  currentDate.period = "середина дня";
else if (currentDate.hour > 17 && currentDate.hour < 23) currentDate.period = "вечер";
else currentDate.period = "ночь";

emit("ondaydata", currentDate);
</script>
