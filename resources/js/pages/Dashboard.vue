<template>
    <Layout>
        <div class="min-h-screen w-full border-t border-gray-300 mt-11 flex">
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Dashboard</h1>
                    <div class="space-x-1"></div>
                </div>

                <!-- Boxes -->
                <div class="my-2 grid grid-cols-2 gap-5">
                    <!-- Number of Reservations Box -->
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow p-4 flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold mb-2">
                            Number of Reservations this Month
                        </h3>
                        <div>{{ numberOfReservations }}</div>
                    </div>

                    <!-- Number of Disposed Equipment Box -->
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow p-4 flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold mb-2">
                            Number of Disposed Equipment this Month
                        </h3>
                        <div>{{ numberOfDisposedEquipment }}</div>
                    </div>
                </div>
                <div class="my-2 gap-5">
                    <div>
                        <TransactionTable
                            class=""
                            @clicked="seeReservationDetails"
                            @reservationSelected="handleReservationSelected"
                        ></TransactionTable>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            ></div>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";
import TransactionTable from "../component/TransactionTable.vue";

export default {
    components: {
        TransactionTable,
    },
    data() {
        return {};
    },
    mounted() {},
    methods: {},
};
</script>
