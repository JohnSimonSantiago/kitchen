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
                    <td class="py-2 px-4">
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
                        <button
                            @click="readMore(reservation)"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            See Order Details
                            <svg
                                class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 10"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9"
                                />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import ReturnReservation from "../componentReservations/ReturnReservation.vue";
import RejectReservation from "../componentReservations/RejectReservation.vue";
import ApproveReservation from "../componentReservations/ApproveReservation.vue";

export default {
    components: {
        Modal,
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
