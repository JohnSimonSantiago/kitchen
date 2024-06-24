<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="text-center px-6 py-3">
                        Reservation Number
                    </th>
                    <th scope="col" class="text-center">Customer Name</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Date Start</th>
                    <th scope="col" class="text-center">Date End</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(reservation, index) in reservations">
                    <td class="text-center">
                        No. {{ reservation.reservationNumber }}
                    </td>
                    <td class="text-center">
                        {{ reservation.customerName }}
                    </td>
                    <td
                        class="text-center flex items-center justify-center"
                        align="center"
                    >
                        <Message
                            class="text-center w-fit"
                            :closable="false"
                            :severity="getStatusSeverity(reservation.statusID)"
                        >
                            {{ getStatus(reservation.statusID) }}
                        </Message>
                    </td>
                    <td class="text-center">
                        {{ formatDate(reservation.dateStart) }}
                    </td>
                    <td class="text-center">
                        {{ formatDate(reservation.dateEnd) }}
                    </td>
                    <td class="space-x-2.5" align="center">
                        <ApproveReservation
                            v-if="reservation.statusID === 1"
                            :idReservation="reservation.reservationNumber"
                            @Refresh="getterReservations"
                        ></ApproveReservation>
                        <ReceiveReservation
                            v-if="reservation.statusID === 2"
                            :idReservation="reservation.reservationNumber"
                            @Refresh="getterReservations"
                        >
                        </ReceiveReservation>
                        <ReturnReservation
                            v-if="reservation.statusID === 3"
                            :idReservation="reservation.reservationNumber"
                            @Refresh="getterReservations"
                        >
                        </ReturnReservation>
                        <RejectReservation
                            v-if="reservation.statusID === 1"
                            :idReservation="reservation.reservationNumber"
                            @Refresh="getterReservations"
                        ></RejectReservation>
                        <SubmitReplacement
                            v-if="reservation.statusID === 6"
                            :idReservation="reservation.reservationNumber"
                            @Refresh="getterReservations"
                        ></SubmitReplacement>
                        <Button
                            @click="readMore(reservation)"
                            label="View"
                            icon="pi pi-arrow-right"
                            class="border border-blue-500 p-2 hover:bg-blue-400 hover:text-white"
                        >
                        </Button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Button from "primevue/button";
import ReturnReservation from "../componentReservations/ReturnReservation.vue";
import RejectReservation from "../componentReservations/RejectReservation.vue";
import ApproveReservation from "../componentReservations/ApproveReservation.vue";
import ReceiveReservation from "../componentReservations/ReceiveReservation.vue";
import SubmitReplacement from "../componentReservations/SubmitReplacement.vue";
import Message from "primevue/message";


export default {
    components: {
        Modal,
        Button,
        Message,
        SubmitReplacement,
        ReceiveReservation,
        ReturnReservation,
        RejectReservation,
        ApproveReservation,
    },
    mounted() {
        this.getterReservations();
        this.getStatusTable();
    },
    data() {
        return {
            reservations: [],
            statusTable: {},
        };
    },
    props: ["reservationDetails"],
    methods: {
        getStatusSeverity(statusID) {
            switch (statusID) {
                case 1:
                    return "warn";
                case 2:
                    return "success";
                case 3:
                    return "info";
                case 4:
                    return "success";
                case 5:
                    return "error";
                case 6:
                    return "warn";

                default:
                    return "info";
            }
        },
        getStatusTable() {
            axios.get("/get-status-table").then(({ data }) => {
                data.forEach((status) => {
                    this.statusTable[status.id] = status.status;
                });
            });
        },
        getStatus(statusID) {
            return this.statusTable[statusID] || "Unknown";
        },
        getterReservations() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        readMore(reservation) {
            this.$emit("clicked", reservation);

            this.$emit("reservationSelected", reservation.reservationNumber);
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric",
            });
        },
    },
};
</script>
