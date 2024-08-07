<template>
    <UserLayout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-50 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-l font-semibold">Reservations</h1>
                </div>
                <div
                    class="flex space-x-5 border items-center rounded-md border-gray-200"
                >
                    <div class="p-2.5 flex gap-4">
                        <CreateReservation
                            @success="getterReservation"
                        ></CreateReservation>
                    </div>
                    <div>
                        <select
                            v-model="selectedStatus"
                            @change="filterReservations"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                        >
                            <option value="">All</option>
                            <option :value="1">Pending</option>
                            <option :value="2">Accepted</option>
                            <option :value="3">Ongoing</option>
                            <option :value="4">Completed</option>
                            <option :value="5">Rejected</option>
                            <option :value="6">Pending Replacement</option>
                        </select>
                    </div>
                </div>

                <div class="my-2 gap-5">
                    <ReservationTableUser
                        ref="reservationTable"
                        @clicked="seeReservationDetails"
                        @clickedReplacement="seeReplacementDetails"
                        @reservationSelected="handleReservationSelected"
                    ></ReservationTableUser>
                </div>
            </div>
            <Dialog v-model:visible="visible" modal :style="{ width: '45rem' }">
                <template #header>
                    <Message
                        Tag
                        icon="pi pi-user"
                        :closable="false"
                        severity="info"
                    >
                        <span style="font-weight: 600">
                            <div icon="pi pi-user"></div>
                            {{ showReservationDetails?.customerName }}
                        </span>
                    </Message>
                </template>
                <h1 class="text-1 font-bold">
                    Order No.
                    {{ showReservationDetails?.reservationNumber }}
                </h1>

                <!-- drawer component -->
                <div class="my-2 grid grid-cols-1">
                    <div class="bg-gray-300 rounded-md px-4 py-2">
                        <div class="my-5">
                            <div v-if="isReservationDetails">
                                <div
                                    v-for="order in reservationOrder"
                                    :key="order.id"
                                >
                                    <OrderCard :orderDetails="order" />
                                </div>
                            </div>
                            <div v-if="!isReservationDetails">
                                <div
                                    v-for="order in replacementDetails"
                                    :key="order.id"
                                >
                                    <OrderCard :orderDetails="order" />
                                </div>
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
                        <span>
                            From:
                            {{ formatDate(showReservationDetails?.dateStart) }}
                        </span>
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
                        <span>
                            To:
                            {{ formatDate(showReservationDetails?.dateEnd) }}
                        </span>
                    </div>
                </div>
                <div
                    class="bg-yellow-100 rounded-md px-4 py-2"
                    v-if="
                        showReservationDetails &&
                        [4, 5].includes(showReservationDetails.statusID)
                    "
                >
                    <span>
                        Remarks:
                        {{ showReservationDetails?.remarks }}
                    </span>
                </div>
                <div class="flex-col self-end">
                    <div
                        v-if="
                            showReservationDetails &&
                            [1].includes(showReservationDetails.statusID)
                        "
                        class="flex items-center justify-center gap-2"
                    >
                        <router-link
                            :to="`/makeOrder/${showReservationDetails?.reservationNumber}`"
                        >
                            <Button
                                class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white p-button"
                            >
                                <span class="pi pi-file-edit"></span>
                                Edit Order
                            </Button>
                        </router-link>
                    </div>
                </div>
            </Dialog>
        </div>
    </UserLayout>
</template>

<script>
import CreateReservation from "@/componentReservations/CreateReservation.vue";
import ReservationTableUser from "../component/ReservationTableUser.vue";
import Message from "primevue/message";
import Tag from "primevue/tag";
import OrderCard from "../Card_small/OrderCard.vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import UserLayout from "../Layout/UserLayout.vue";
import axios from "axios";

export default {
    components: {
        Tag,
        Message,
        Button,
        OrderCard,
        UserLayout,
        CreateReservation,
        ReservationTableUser,
        Dialog,
    },
    mounted() {
        this.getterReservation();
    },
    data() {
        return {
            reservations: null,
            showReservationDetails: null,
            showReplacementDetails: null,
            reservationOrder: [],
            replacementDetails: [],
            visible: false,
            isReservationDetails: true,
            selectedStatus: "",
        };
    },
    methods: {
        filterReservations() {
            this.$refs.reservationTable.filterByStatus(this.selectedStatus);
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric",
            });
        },
        seeReservationDetails(data) {
            this.visible = true;
            this.showReservationDetails = data;
            this.isReservationDetails = true;
            this.getterReservationOrder(data.reservationNumber);
        },
        seeReplacementDetails(data) {
            this.visible = true;
            this.showReplacementDetails = data;
            this.isReservationDetails = false;
            this.getterReplacementDetails(data.reservationNumber);
        },
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        handleReservationSelected(reservationNumber) {
            this.getterReservationOrder(reservationNumber);
        },
        getterReservationOrder(reservationNumber) {
            axios
                .get("/get-reservation-orders", {
                    params: {
                        reservationNumber: reservationNumber,
                    },
                })
                .then(({ data }) => {
                    this.reservationOrder = data;
                });
        },
        getterReplacementDetails(reservationNumber) {
            axios
                .get("/get-reservation-orders", {
                    params: {
                        reservationNumber: reservationNumber,
                    },
                })
                .then(({ data }) => {
                    this.replacementDetails = data;
                });
        },
    },
};
</script>
