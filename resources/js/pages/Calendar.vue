<template>
    <Layout>
        <div class="min-h-screen w-full border-t border-gray-300 mt-11 flex">
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-50">
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
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div v-if="showReservationDetails === null">
                    <!-- Show a message if no reservation is selected -->
                    <Message :closable="false" severity="info"
                        >Select a date with a reservation to view
                        details.</Message
                    >
                </div>
                <div v-else>
                    <!-- Show reservation details in the drawer -->
                    <div>
                        <h2>Reservation Details</h2>
                        <p>
                            Reservation Number:
                            {{ showReservationDetails.reservationNumber }}
                        </p>
                        <!-- Other reservation details here -->
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";
import Message from "primevue/message";

export default {
    components: { Message },
    data() {
        return {
            attributes: [],
            clickedDate: null,
            showReservationDetails: null,
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
                    console.log(this.attributes);
                })
                .catch((error) => {
                    console.error("Error fetching reservations:", error);
                });
        },
    },
};
</script>
