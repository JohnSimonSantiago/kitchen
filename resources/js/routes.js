import App from "@/component/App.vue";
import Home from "@/pages/Home.vue";
import Page3 from "@/pages/Page3.vue";
import Calendar from "@/pages/Calendar.vue";
import Login from "@/pages/Login.vue";
import Signup from "@/pages/Signup.vue";

export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/home",
        name: "home",   
        component: Home,
    },
    {
        path: "/app",
        name: "app",
        component: App,
    },
    {
        path: "/page3",
        name: "page3",
        component: Page3,
    },
    {
        path: "/calendar",
        name: "calendar",
        component: Calendar,
    },
    ,
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
];
