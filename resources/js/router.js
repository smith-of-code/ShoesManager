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
    props: true,
   component: () => import("./pages/CardFormShoes.vue"),
    children: [
        {
        path: '/card/:id',
        name: "CardID",
        props: true,
        component: () => import('./pages/CardFormShoes.vue')
        },
            ]
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
    {
        path: "/adviser",
        name: "ShoesAdviser",
        component: () => import('./pages/ShoesAdviser.vue')
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
