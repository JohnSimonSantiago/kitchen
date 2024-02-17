import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout1 from "@/Layout/Layout1.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const app = createApp({});

app.use(router);

app.component("Layout", Layout1);

app.mount("#app");
