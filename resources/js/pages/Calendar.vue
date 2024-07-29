<template>
    <div>
        <div>
            <VCalendar
                :attributes="attributes"
                @dayclick="handleDayClick"
                expanded
                borderless
            ></VCalendar>
        </div>

        <Dialog
            v-model:visible="dialogVisible"
            modal
            :style="{ width: '45rem' }"
        >
            <template #header>
                <Message
                    Tag
                    icon="pi pi-user"
                    :closable="false"
                    severity="info"
                >
                    <span style="font-weight: 600">{{
                        selectedReservationDetails?.customerName
                    }}</span>
                </Message>
            </template>
            <h1 class="text-1 font-bold">
                Reservation No.
                {{ selectedReservationDetails?.reservationNumber }}
            </h1>
            <div class="my-2 grid grid-cols-1">
                <div class="bg-gray-300 rounded-md px-4 py-2">
                    <div class="my-5">
                        <div v-for="order in reservationOrder" :key="order.id">
                            <OrderCard :orderDetails="order" />
                        </div>
                    </div>
                </div>
                <div
                    class="p-1 mt-4 flex items-center border-t border-dashed border-black h-30 justify-center"
                >
                    <svg
                        class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14c.6 0 1-.4 1-1V7c0-.6-.4-1-1-1H5a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Z"
                        />
                    </svg>
                    <span
                        >From:
                        {{
                            formatDate(selectedReservationDetails?.dateStart)
                        }}</span
                    >
                </div>
                <div
                    class="p-1 border-b border-dashed border-black h-30 flex items-center justify-center"
                >
                    <svg
                        class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M6 5V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V7c0-1.1.9-2 2-2h1ZM3 19v-8h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm5-6a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <span
                        >To:
                        {{
                            formatDate(selectedReservationDetails?.dateEnd)
                        }}</span
                    >
                </div>
            </div>
        </Dialog>
    </div>
</template>

<script>
import axios from "axios";
import Message from "primevue/message";
import Tag from "primevue/tag";
import OrderCard from "../Card_small/OrderCard.vue";
import Dialog from "primevue/dialog";

export default {
    components: { Message, Tag, OrderCard, Dialog },
    data() {
        return {
            reservations: [],
            selectedReservationDetails: null,
            reservationOrder: [],
            dotColors: [
                "blue",
                "red",
                "green",
                "orange",
                "purple",
                "pink",
                "yellow",
            ],
            noReservationMessage:
                "Select a date with a reservation to view details.",
            dialogVisible: false,
        };
    },
    computed: {
        attributes() {
            return this.reservations.map((reservation, index) => {
                const dotColor = this.dotColors[index % this.dotColors.length];
                return {
                    dates: [
                        [
                            new Date(reservation.dateStart),
                            new Date(reservation.dateEnd),
                        ],
                    ],
                    dot: {
                        color: dotColor,
                    },
                    popover: {
                        label: `Reservation: ${reservation.customerName}`,
                    },
                    reservationNumber: reservation.reservationNumber,
                };
            });
        },
    },
    mounted() {
        this.getterReservation();
    },
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric",
            });
        },
        handleDayClick(day) {
            const reservation = this.attributes.find((attr) => {
                const startDate = new Date(attr.dates[0][0]);
                const endDate = new Date(attr.dates[0][1]);
                return day.date >= startDate && day.date <= endDate;
            });

            if (reservation) {
                const reservationNumber = reservation.reservationNumber;
                this.getReservationDetails(reservationNumber);
                this.dialogVisible = true;
                this.noReservationMessage =
                    "Select a date with a reservation to view details.";
            } else {
                this.selectedReservationDetails = null;
                this.reservationOrder = [];
                this.dialogVisible = false;
                this.noReservationMessage = "No reservations on this date.";
            }
        },
        getReservationDetails(reservationNumber) {
            axios
                .get("/get-reservation-details", {
                    params: { reservationNumber },
                })
                .then(({ data }) => {
                    this.selectedReservationDetails = data;
                    this.getReservationOrders(reservationNumber);
                })
                .catch((error) => {
                    console.error("Error fetching reservation details:", error);
                });
        },
        getReservationOrders(reservationNumber) {
            axios
                .get("/get-reservation-orders", {
                    params: { reservationNumber },
                })
                .then(({ data }) => {
                    this.reservationOrder = data;
                })
                .catch((error) => {
                    console.error("Error fetching reservation orders:", error);
                });
        },
        getterReservation() {
            axios
                .get("/get-reservations")
                .then((response) => {
                    this.reservations = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching reservations:", error);
                });
        },
    },
};
</script>
