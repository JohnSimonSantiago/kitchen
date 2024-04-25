<template lang="html">
    <div class="h-screen">
        <!-- Top Row -->
        <div
            class="bg-white-100 z-50 flex items-center border-b border-yellow-400 border-b-2 ps-2.5 pt-0.5 gap-2 fixed bg-white h-16 w-screen over-flow-clip"
        >
            <img src="../../../public/Cbea.png" alt="" class="w-10 h-10" />
            <span
                class="pl-11 fixed self-center text-xl font-semibold whitespace-nowrap dark:text-white"
                >CBEA Kitchen Equipment</span
            >
        </div>

        <div>
            <div
                class="w-32 mt-16 fixed bg-white/60 shadow-sm backdrop-blur-sm h-full flex flex-col items-center"
            >
                <div class="flex text-center items-center">
                    <div class="space-y-24 text-center py-8">
                        <div>
                            <router-link
                                to="/myReservations"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                                @click="toggleActive1"
                                :style="{
                                    borderRight: isActive1
                                        ? '3px solid green'
                                        : 'none',
                                }"
                                ><p class="mx-10">
                                    <i
                                        class="pi pi-book"
                                        style="font-size: 1.5rem"
                                    ></i>
                                </p>
                                My Reservations</router-link
                            >
                        </div>
                        <div>
                            <router-link
                                to="/rent"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                                @click.native="toggleActive('/rent')"
                                :style="{
                                    borderRight:
                                        isActive === '/rent'
                                            ? '3px solid green'
                                            : 'none',
                                }"
                            >
                                <p class="mx-10">
                                    <i
                                        class="pi pi-cart-plus"
                                        style="font-size: 1.5rem"
                                    ></i>
                                </p>
                                Rent</router-link
                            >
                        </div>

                        <div class="flex justify-center items-center">
                            <button
                                @click="logout"
                                class="flex flex-col items-center mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                            >
                                <i
                                    class="pi pi-user-minus"
                                    style="font-size: 1.5rem"
                                ></i>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="min-h-screen flex flex-col items-center justify-center ml-32"
            >
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
import Button from "primevue/button";
export default {
    components: {
        Button,
    },
    data() {
        return {
            isActive: false,
            isActive1: false,
            isActive2: false,
        };
    },
    methods: {
        toggleActive(inventory) {
            this.isActive = inventory;
        },
        toggleActive1() {
            this.isActive1 = !this.isActive1;
        },
        toggleActive2() {
            this.isActive2 = !this.isActive2;
        },
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                if (!data) {
                    this.$router.push("/");
                }
            });
        },
        logout() {
            axios.post("/logout").then(() => {
                this.$router.push("/");
            });
        },
    },
    mounted() {
        this.checkAuth();
    },
};
</script>

<style></style>
