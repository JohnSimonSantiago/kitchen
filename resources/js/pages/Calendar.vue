<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-200">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Calendar</h1>
                    <div class="space-x-1"></div>
                </div>

                <Calendar
                    inline
                    :events="reservations"
                    :event-title="(event) => event.title"
                    :event-start="(event) => event.start"
                    :event-end="(event) => event.end"
                ></Calendar>

                <div class="my-2 grid grid-cols-4 gap-5"></div>
            </div>

            <!-- Right Section -->
            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-100"
            ></div>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Calendar from "primevue/calendar";

export default {
    components: {
        Dialog,
        Calendar,
        Button,
    },
    data() {
        return {
            value: 0,
            visible: false,
            reservations: [],
        };
    },
    mounted() {
        this.getterReservations();
    },
    methods: {
        getterReservations() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data.map((reservation) => ({
                    title: "Reservation", 
                    start: new Date(reservation.dateStart), 
                    end: new Date(reservation.dateEnd), 
                }));
            });
        },
    },
};
</script>
