<template lang="html">
    <div class="h-screen">
        <!-- Top Row -->
        <div
            class="flex items-center ps-2.5 pt-0.5 gap-2 fixed bg-white z-50 w-screen over-flow-clip"
        >
            <img src="../../../public/Cbea.png" alt="" class="w-10 h-10" />
            <span
                class="pl-11 fixed self-center text-xl font-semibold whitespace-nowrap dark:text-white"
                >CBEA Kitchen Equipment</span
            >
        </div>

        <div>
            <div
                class="w-32 mt-11 border-t border-gray-300 fixed bg-white/60 shadow-sm backdrop-blur-sm h-full flex flex-col items-center"
            >
                <div class="items-center">
                    <div class="space-y-24 text-center py-8">
                        <router-link
                            to="/rent"
                            class="text-black-500 font-bold block"
                            ><p class="mx-10">
                                <svg
                                    class="w-[32px] h-[32px] text-gray-800 dark:text-white"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.1"
                                        d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.3L19 7h-1M8 7h-.7M13 5v4m-2-2h4"
                                    />
                                </svg>
                            </p>
                            Rent</router-link
                        >
                        <router-link
                            to="/cart"
                            class="text-black-500 font-bold block"
                            ><p class="mx-10">
                                <svg
                                    class="w-[32px] h-[32px] text-gray-800 dark:text-white"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.1"
                                        d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.3L19 7H7.3"
                                    />
                                </svg>
                            </p>
                            Cart</router-link
                        >
                        <button
                            @click="logout"
                            class="text-black-500 font-bold block mx-10"
                        >
                            Exit
                            <svg
                                class="w-4 h-4 text-gray-800 dark:text-white rtl:rotate-180 w-3.5 h-3.5 ms-2"
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
                        </button>
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
export default {
    methods: {
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
