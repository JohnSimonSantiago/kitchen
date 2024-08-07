<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right dark:text-gray-400">
            <thead>
                <tr class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="text-center px-6 py-3 w-32">Reservation Number</th>
                    <th scope="col" class="text-center w-32">Customer Name</th>
                    <th scope="col" class="text-center w-56">Status</th>
                    <th scope="col" class="text-center">Date Start</th>
                    <th scope="col" class="text-center">Date End</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(reservation, index) in filteredReservations" :key="reservation.reservationNumber">
                    <td class="text-center text-base w-32">No. {{ reservation.reservationNumber }}</td>
                    <td class="text-center text-base w-32">{{ reservation.customerName }}</td>
                    <td class="text-center">
                        <div class="flex justify-center">
                            <Message :closable="false" :severity="getStatusSeverity(reservation.statusID)">
                                {{ getStatus(reservation.statusID) }}
                            </Message>
                        </div>
                    </td>
                    <td class="text-center text-base">{{ formatDate(reservation.dateStart) }}</td>
                    <td class="text-center text-base">{{ formatDate(reservation.dateEnd) }}</td>
                    <td class="text-center">
                        <div class="grid grid-cols-3 justify-center gap-2 p-2">
                            <ApproveReservation
                                v-if="reservation.statusID === 1"
                                :idReservation="reservation.reservationNumber"
                                @Refresh="$emit('refresh')"
                            ></ApproveReservation>
                            <ReceiveReservation
                                v-if="reservation.statusID === 2"
                                :idReservation="reservation.reservationNumber"
                                @Refresh="$emit('refresh')"
                            ></ReceiveReservation>
                            <ReturnReservation
                                v-if="reservation.statusID === 3"
                                :idReservation="reservation.reservationNumber"
                                @Refresh="$emit('refresh')"
                            ></ReturnReservation>
                            <RejectReservation
                                v-if="reservation.statusID === 1"
                                :idReservation="reservation.reservationNumber"
                                @Refresh="$emit('refresh')"
                            ></RejectReservation>
                            <SubmitReplacement
                                v-if="reservation.statusID === 6"
                                :idReservation="reservation.reservationNumber"
                                @Refresh="$emit('refresh')"
                            ></SubmitReplacement>
                            <Button
                                v-if="reservation.statusID >= 1 && reservation.statusID <= 5"
                                @click="readMore(reservation)"
                                label="View"
                                icon="pi pi-arrow-right"
                                class="border border-blue-500 p-2 hover:bg-blue-400 hover:text-white"
                            ></Button>
                            <Button
                                v-if="reservation.statusID === 6"
                                @click="viewReplacementDetails(reservation)"
                                label="View Replacements"
                                icon="pi pi-arrow-right"
                                class="border border-blue-500 p-2 hover:bg-blue-400 hover:text-white"
                            ></Button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Button from "primevue/button";
import ReturnReservation from "../componentReservations/ReturnReservation.vue";
import RejectReservation from "../componentReservations/RejectReservation.vue";
import ApproveReservation from "../componentReservations/ApproveReservation.vue";
import ReceiveReservation from "../componentReservations/ReceiveReservation.vue";
import SubmitReplacement from "../componentReservations/SubmitReplacement.vue";
import Message from "primevue/message";

export default {
    components: {
        Button,
        Message,
        SubmitReplacement,
        ReceiveReservation,
        ReturnReservation,
        RejectReservation,
        ApproveReservation,
    },
    props: ["reservationDetails", "reservations"],
    data() {
        return {
            statusTable: {},
            selectedStatus: "",
        };
    },
    computed: {
        filteredReservations() {
            if (this.selectedStatus === "") {
                return this.reservations || [];
            } else {
                const statusNumber = Number(this.selectedStatus);
                return (this.reservations || []).filter(
                    (reservation) => reservation.statusID === statusNumber
                );
            }
        }
    },
    mounted() {
        this.getStatusTable();
    },
    methods: {
        filterByStatus(status) {
            this.selectedStatus = status;
        },
        getStatusSeverity(statusID) {
            switch (statusID) {
                case 1: return "warn";
                case 2: return "success";
                case 3: return "info";
                case 4: return "success";
                case 5: return "error";
                case 6: return "warn";
                default: return "info";
            }
        },
        getStatusTable() {
            axios.get("/get-status-table").then(({ data }) => {
                this.statusTable = data.reduce((acc, status) => {
                    acc[status.id] = status.status;
                    return acc;
                }, {});
            });
        },
        getStatus(statusID) {
            return this.statusTable[statusID] || "Unknown";
        },
        readMore(reservation) {
            this.$emit("clicked", reservation);
            this.$emit("reservationSelected", reservation.reservationNumber);
        },
        viewReplacementDetails(replacementDetails) {
            this.$emit("clickedReplacement", replacementDetails);
            this.$emit("reservationSelected", replacementDetails.reservationNumber);
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