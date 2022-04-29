<template>
<component :is="type"></component>
</template>

<script>
import signin from "../components/Auth/Signin";
import signup from "../components/Auth/Signup";
import resetPassword from "../components/Auth/ResetPassword";
export default {
    name: "Auth",
    components:{signin,signup,resetPassword},
    props:{
        type:{
            type: String,
            default:'signin'//signup , resetpassword
        }
    }
}
</script>

<style scoped>

</style>
