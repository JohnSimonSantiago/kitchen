<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-50 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
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
                        class=""
                        @clicked="seeReservationDetails"
                    ></ReservationTable>
                </div>
            </div>

            <!-- Right Section -->
            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div v-if="showReservationDetails === null">
                    <Message :closable="false" severity="info"
                        >Select Reservation to view Details</Message
                    >
                </div>
                <div v-else>
                    <div>
                        <h2 class="text-1 font-bold">
                            Order No.
                            {{ this.showReservationDetails.reservationNumber }}
                        </h2>
                    </div>
                    <Tag icon="pi pi-user">
                        <span style="font-weight: 600">
                            <div icon="pi pi-user"></div>
                            {{ this.showReservationDetails.customerName }}
                        </span></Tag
                    >

                    <!-- drawer component -->
                    <div class="my-2 grid grid-cols-1">
                        <div class="bg-gray-300 rounded-md px-4 py-2">
                            <h1 class="font-bold">Cart:</h1>
                        </div>
                        <div
                            class="p-1 mt-4 flex items-center border-t border-dashed border-black h-30 flex items-center justify-center"
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
                                From:{{ this.showReservationDetails.dateStart }}
                            </span>
                        </div>
                        <div
                            class="p-1 flex items-center border-b border-dashed border-black h-30 flex items-center justify-center"
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
                                To:{{ this.showReservationDetails.dateEnd }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-col self-end">
                        <div class="flex items-center justify-center gap-2">
                            <AddItem
                                :idReservation="
                                    this.showReservationDetails
                                        .reservationNumber
                                "
                                @success="getterReservation"
                            ></AddItem>
                            <router-link
                                :to="
                                    '/makeOrder/' +
                                    showReservationDetails.reservationNumber
                                "
                            >
                                <button
                                    class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white p-button"
                                >
                                    <span class="pi pi-file-edit"></span>
                                    Edit Order
                                </button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import AddItem from "@/componentreservations/AddItem.vue";
import CreateReservation from "@/componentreservations/CreateReservation.vue";
import ReservationTable from "../component/ReservationTable.vue";
import Message from "primevue/message";
import Tag from "primevue/tag";

export default {
    components: {
        AddItem,
        Tag,
        Message,
        CreateReservation,
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
            console.log(data);
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
