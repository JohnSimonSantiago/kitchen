<template lang="html">
    <div class="h-screen">
        <!-- Top Row -->
        <div
            class="flex items-center border-b border-yellow-400 border-b-2 ps-2.5 pt-0.5 gap-2 fixed bg-white h-16 w-screen over-flow-clip"
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
                                to="/dashboard"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                                @click.native="toggleActive('/dashboard')"
                                :style="{
                                    borderRight:
                                        isActive === '/dashboard'
                                            ? '3px solid green'
                                            : 'none',
                                }"
                            >
                                <p class="mx-10">
                                    <svg
                                        class="w-[32px] h-[32px] text-gray-800 dark:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2.1"
                                            d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z"
                                        />
                                    </svg>
                                </p>
                                Dashboard</router-link
                            >
                        </div>
                        <div>
                            <router-link
                                to="/inventory"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                                @click.native="toggleActive('/inventory')"
                                :style="{
                                    borderRight:
                                        isActive === '/inventory'
                                            ? '3px solid green'
                                            : 'none',
                                }"
                            >
                                <p class="mx-10">
                                    <svg
                                        class="w-6 h-6 text-gray-800 dark:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 18 18"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M1 10h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H17M1 10v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M1 10l2-9h12l2 9M6 4h6M5 7h8"
                                        />
                                    </svg>
                                </p>
                                Inventory</router-link
                            >
                        </div>
                        <div>
                            <router-link
                                to="/reservations"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                                @click="toggleActive1"
                                :style="{
                                    borderRight: isActive1
                                        ? '3px solid green'
                                        : 'none',
                                }"
                                ><p class="mx-10">
                                    <svg
                                        class="w-6 h-6 text-gray-800 dark:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 18 20"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4H1m3 4H1m3 4H1m3 4H1m6.071.286a3.429 3.429 0 1 1 6.858 0M4 1h12a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Zm9 6.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"
                                        />
                                    </svg>
                                </p>
                                Reservations</router-link
                            >
                        </div>
                        <div>
                            <router-link
                                to="/calendar"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                                @click="toggleActive2"
                                :style="{
                                    borderRight: isActive2
                                        ? '3px solid green'
                                        : 'none',
                                }"
                                ><p class="mx-10">
                                    <svg
                                        class="w-6 h-6 text-gray-800 dark:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"
                                        />
                                    </svg>
                                </p>
                                Calendar</router-link
                            >
                        </div>
                        <router-link to="/reservations2">
                            reservations2</router-link
                        >
                        <div class="flex justify-center items-center">
                            <button
                                @click="logout"
                                class="flex flex-col items-center mb-2 text-sm font-medium text-gray-900 dark:text-white hover:bg-gray-200"
                            >
                                <svg
                                    class="w-4 h-4 text-gray-800 dark:text-white rtl:rotate-180 w-3.5 h-3.5 mb-1"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"
                                    />
                                </svg>
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
