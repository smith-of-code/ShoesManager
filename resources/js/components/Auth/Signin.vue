<template>
    <form action="/auth/signin" method="post" class="auth-form">
        <h1>Вход</h1>
        <div class="auth-form__box">
            <hr/>
            <div class="auth-form__container">
                <input type="text" placeholder="Email" name="email" required>
                <input type="password" placeholder="Пароль" name="password" required>
            </div>
            <button type="submit">Войти</button>
            <div class="auth-form__footer" style="background-color: #eee">
                <label style="padding-left: 15px">
                    <input type="checkbox"  checked="checked" name="remember"> Запомнить меня
                </label>
                <span class="psw"><a href="#"> Потеряли пароль?</a></span>
            </div>
        </div>

    </form>
</template>

<script>
export default {
    name: "Signin"
}
</script>

<style scoped>
.auth-form {
    border: 5px solid #f1f1f1;
}
input[type=text], input[type=password] {
    width: 100%;
    padding: 16px 8px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
button {
    background-color: #8ebf42;
    color: white;
    padding: 14px 0;
    margin: 10px 0;
    border: none;
    cursor: grabbing;
    width: 100%;
}
h1 {
    text-align:center;
    fone-size:18;
}
button:hover {
    opacity: 0.8;
}
.auth-form__box {
    text-align: left;
    margin: 24px 50px 12px;
}
.auth-form__container {
    padding: 16px 0;
    text-align:left;
}

.auth-form__footer{
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 35px;
}

span.psw {
    float: right;
    padding-top: 0;
    padding-right: 15px;
}
/* Change styles for span on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
        display: block;
        float: none;
    }
}
</style>
