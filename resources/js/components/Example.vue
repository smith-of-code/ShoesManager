<template>
    <h5>example {{text}}</h5>
</template>

<script>
export default {
    name: "App.vue",
    props:{
        text:{
            type:String,
            default: 'tralala'
        }
    }
}
</script>

<style scoped>

</style>
