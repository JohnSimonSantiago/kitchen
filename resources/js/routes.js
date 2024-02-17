import Inventory from "@/pages/Inventory.vue";
import Calendar from "@/pages/Calendar.vue";
import Login from "@/pages/Login.vue";
import Reservations from "@/pages/Reservations.vue";
import Return from "@/pages/Return.vue";
import MakeOrder from "@/pages/MakeOrder.vue";
import Signup from "@/pages/Signup.vue";

export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
    {
        path: "/makeorder",
        name: "makeOrder",
        component: MakeOrder,
    },
    {
        path: "/return",
        name: "return",
        component: Return,
    },
    {
        path: "/reservations",
        name: "reservations",
        component: Reservations,
    },

    {
        path: "/inventory",
        name: "inventory",
        component: Inventory,
    },
    {
        path: "/calendar",
        name: "calendar",
        component: Calendar,
    },
    ,
];
