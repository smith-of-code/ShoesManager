<template>
  <div class="search_element">
    <slot></slot>
  </div>
</template>

<style scoped>
.search_element {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 5px;
  margin: 5px 0;
  border: 1px solid red;
}
</style>
