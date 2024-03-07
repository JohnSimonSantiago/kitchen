<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="px-6 py-3">Reservation #</th>
                    <th scope="col" class="px-6 py-3">Customer Name</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Date Start</th>
                    <th scope="col" class="px-6 py-3">Date End</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(reservation, index) in reservations" key="index0">
                    <td class="py-2 px-4 border-r">
                        {{ reservation.reservationNumber }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ reservation.customerName }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ reservation.statusID }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ reservation.dateStart }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ reservation.dateEnd }}
                    </td>
                    <td class="py-1 px-2 my-1 gap-4">
                        ">
                        <ApproveReservation
                            v-if="reservation.statusID === 1"
                            :idReservation="reservation.reservationNumber"
                        ></ApproveReservation>
                        <ReturnReservation
                            v-if="reservation.statusID === 2"
                            :idReservation="reservation.reservationNumber"
                        >
                        </ReturnReservation>
                        <RejectReservation
                            v-if="reservation.statusID === 1"
                            :idReservation="reservation.reservationNumber"
                        ></RejectReservation>
                        <Button
                            @click="readMore(reservation)"
                            label="Read More"
                            icon="pi pi-arrow-right"
                            class="border border-blue-500 p-2 hover:bg-blue-700 hover:text-white"
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

export default {
    components: {
        Modal,
        Button,
        ReturnReservation,
        RejectReservation,
        ApproveReservation,
    },
    mounted() {
        this.getterReservations();
    },
    data() {
        return {
            reservations: [],
        };
    },
    props: ["reservationDetails"],
    methods: {
        getterReservations() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        readMore(data) {
            this.$emit("clicked", data);
        },
    },
};
</script>
