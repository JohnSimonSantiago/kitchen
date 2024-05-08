import Inventory from "@/pages/Inventory.vue";
import Calendar from "@/pages/Calendar.vue";
import Login from "@/pages/Login.vue";
import Reservations from "@/pages/Reservations.vue";
import MakeOrder from "@/pages/MakeOrder.vue";
import Signup from "@/pages/Signup.vue";
import Rent from "@/pagesUser/Rent.vue";
import Reservations2 from "@/pages/Reservations2.vue";
import EditStock from "@/pages/EditStock.vue";
import Dashboard from "./pages/Dashboard.vue";
import MyReservations from "@/pagesUser/MyReservations.vue";
import Home from "@/pagesUser/Home.vue";

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
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
    },
    {
        path: "/myreservations",
        name: "myreservations",
        component: MyReservations,
    },
    {
        path: "/home",
        name: "home",
        component: Home,
    },
    {
        path: "/editstock",
        name: "editstock",
        component: EditStock,
    },
    {
        path: "/reservations2",
        name: "reservations2",
        component: Reservations2,
    },
    {
        path: "/rent",
        name: "rent",
        component: Rent,
    },
    {
        path: "/makeOrder/:reservationNumber",
        name: "MakeOrder",
        component: MakeOrder,
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
