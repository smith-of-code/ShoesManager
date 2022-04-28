import { createWebHistory, createRouter } from "vue-router";
import Home from "./pages/Home";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/card",
        name: "Card",
        component: () => import('./pages/CardFormShoes.vue')
    },
    {
        path: "/list",
        name: "ListShoes",
        component: () => import('./pages/ListShoes.vue')
    },
    {
        path: "/auth/:type",
        name: "Signin",
        component: () => import('./pages/Auth.vue'),
        props:true
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
