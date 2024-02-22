<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <!-- min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex -->
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-300">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Orders</h1>
                    <div class="mb-4 space-x-1">
                        <CreateReservation
                            @success="getterReservation"
                        ></CreateReservation>
                    </div>
                </div>
                <div>
                    <ReservationTable
                        v-for="reservation in reservations"
                        class=""
                        :reservationDetails="reservation"
                        @clicked="seeReservationDetails"
                    ></ReservationTable>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5">
                    <div v-for="reservation in reservations" class="">
                        <ReservationCard
                            :reservationDetails="reservation"
                            @clicked="seeReservationDetails"
                        />
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex min-h-screen flex-col w-1/4 p-4 bg-gray-200">
                <div v-if="showReservationDetails === null">
                    (Select Order to View Details)
                </div>
                <div v-else>
                    <div>
                        <h2 class="text-1 font-bold">
                            Order No.
                            {{ this.showReservationDetails.reservationNumber }}
                        </h2>
                    </div>

                    <div style="display: flex">
                        <svg
                            class="w-6 h-6 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke="currentColor"
                                stroke-width="2"
                                d="M7 17v1c0 .6.4 1 1 1h8c.6 0 1-.4 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                            />
                        </svg>

                        <span style="font-weight: 600">
                            {{ this.showReservationDetails.customerName }}
                        </span>
                    </div>

                    <!-- drawer component -->
                    <div class="my-2 grid grid-cols-1">
                        <div class="bg-gray-300 rounded-md px-4 py-2">
                            <h1 class="font-bold">Name:</h1>
                            <p>
                                {{ this.reservationOrder.quantity }}
                            </p>
                            <p>
                                {{ this.reservationOrder.quantity }}
                            </p>
                            <div class="mb-2">
                                <AddItem
                                    :idReservation="
                                        this.showReservationDetails
                                            .reservationNumber
                                    "
                                    @success="getterReservation"
                                ></AddItem>
                            </div>
                        </div>
                        <div
                            class="p-1 mt-4 flex items-center border-t border-dashed border-black h-30"
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

                            <span style="font-weight: 400">
                                {{ this.showReservationDetails.dateStart }}
                            </span>
                        </div>
                        <div
                            class="p-1 flex items-center border-b border-dashed border-black h-30"
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

                            <span style="font-weight: 400">
                                {{ this.showReservationDetails.dateEnd }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-col self-end">
                        <ApproveReservation
                            v-if="this.showReservationDetails.statusID === 1"
                            :idReservation="
                                this.showReservationDetails.reservationNumber
                            "
                            :idEquipment="getEquipmentIdForApproval()"
                        ></ApproveReservation>
                        <RejectReservation
                            v-if="this.showReservationDetails.statusID === 1"
                            :idReservation="
                                this.showReservationDetails.reservationNumber
                            "
                            @rejected="RejectedReservation"
                        ></RejectReservation>
                        <ReturnReservation
                            v-if="this.showReservationDetails.statusID === 2"
                            :idReservation="
                                this.showReservationDetails.reservationNumber
                            "
                            :idEquipment="getEquipmentIdForApproval()"
                        ></ReturnReservation>
                        <router-link :to="'/makeOrder/' + reservationNumber">
                            <button>Edit Order</button>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import ReservationCard from "../cards/ReservationCard.vue";
import RejectReservation from "@/componentreservations/RejectReservation.vue";
import ReturnReservation from "../componentReturn/ReturnReservation.vue";
import ApproveReservation from "@/componentreservations/ApproveReservation.vue";
import AddItem from "@/componentreservations/AddItem.vue";
import CreateReservation from "@/componentreservations/CreateReservation.vue";
import ReservationTable from "../component/ReservationTable.vue";

export default {
    components: {
        AddItem,
        ReservationCard,
        CreateReservation,
        ReturnReservation,
        RejectReservation,
        ApproveReservation,
        ReservationTable,
    },
    mounted() {
        this.getterReservation();
        this.getterReservationOrder();
    },
    data() {
        return {
            reservations: null,
            showReservationDetails: null,
        };
    },
    methods: {
        getEquipmentIdForApproval() {
            // Check if there is a selected reservation and if reservationOrder is available
            if (this.showReservationDetails && this.reservationOrder) {
                // Find the corresponding reservation order
                const order = this.reservationOrder.find((order) => {
                    return (
                        order.reservationNumber ===
                        this.showReservationDetails.reservationNumber
                    );
                });

                // Return the idEquipment if found
                if (order) {
                    return order.idEquipment;
                }
            }

            // Return a default value or handle the case when idEquipment is not available
            return null;
        },
        seeReservationDetails(data) {
            this.showReservationDetails = data;
        },
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        RejectedReservation() {
            this.getterReservation();
            this.showReservationDetails = null;
        },

        getterReservationOrder() {
            axios.get("/get-reservation-orders").then(({ data }) => {
                this.reservationOrder = data;
            });
        },
    },
};
</script>
