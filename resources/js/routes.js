import Inventory from "@/pages/Inventory.vue";
import Calendar from "@/pages/Calendar.vue";
import Login from "@/pages/Login.vue";
import Reservations from "@/pages/Reservations.vue";
import Return from "@/pages/Return.vue";
import POS from "@/pages/POS.vue";
import MakeOrder from "@/pages/MakeOrder.vue";

export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/makeorder",
        name: "makeOrder",
        component: MakeOrder,
    },
    {
        path: "/pos",
        name: "POS",
        component: POS,
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
