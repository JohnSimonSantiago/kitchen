<template>
    <UserLayout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-5"
                >
                    <h1 class="text-l mb-3 mt-3 font-semibold">
                        My Reservations
                    </h1>
                    <div class="mb-4 space-x-1">
                        <CreateReservation
                            @success="getterReservation"
                        ></CreateReservation>
                    </div>
                </div>
            </div>
            <!-- Right Section -->

            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div>
                    <Message :closable="false" severity="info"
                        >Cart is Empty</Message
                    >
                </div>
                <div>
                    <!-- drawer component -->
                    <div class="my-5">
                        <div class="bg-gray-200 rounded-md px-4 py-2"></div>
                    </div>

                    <div
                        class="flex bottom-0 left-0 justify-center pb-4 space-x-4 w-full md:px-4"
                    ></div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import Message from "primevue/message";
import Button from "primevue/button";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import CreateReservation from "../componentReservations/CreateReservation.vue";
import UserLayout from "../Layout/UserLayout.vue";

export default {
    components: {
        UserLayout,
        CreateReservation,
        InputText,
        Button,
        IconField,
        Message,
        InputIcon,
    },

    mounted() {
        this.getterReservation();
    },

    data() {
        return {};
    },

    methods: {
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
    },
};
</script>
