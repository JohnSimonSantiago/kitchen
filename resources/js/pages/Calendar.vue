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

                <VCalendar
                    borderless
                    transparent
                    expanded
                    :attributes="attributes"
                ></VCalendar>

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

export default {
    components: {},
    data() {
        return {
            attributes: [],
            highlightColors: [
                "blue",
                "red",
                "green",
                "orange",
                "purple",
                "pink",
                "yellow",
            ],
        };
    },
    mounted() {
        this.getterReservation();
    },
    methods: {
        getterReservation() {
            axios
                .get("/get-reservations")
                .then((response) => {
                    this.attributes = response.data.map(
                        (reservation, index) => {
                            // Use modulo to cycle through highlight colors
                            const highlightColor =
                                this.highlightColors[
                                    index % this.highlightColors.length
                                ];
                            return {
                                highlight: highlightColor,
                                dates: [
                                    [
                                        new Date(reservation.dateStart),
                                        new Date(reservation.dateEnd),
                                    ],
                                ],
                            };
                        }
                    );
                })
                .catch((error) => {
                    console.error("Error fetching reservations:", error);
                });
            console.log(this.attributes);
        },
    },
};
</script>
