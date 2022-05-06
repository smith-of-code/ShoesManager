import { createApp } from 'vue'

import App from "./layouts/App.vue";
import router from './router'

createApp(App,{isAuth:window.isAuth}).use(router).mount('#app');


require("./bootstrap");
