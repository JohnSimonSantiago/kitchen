<template>
    <Layout>
        <div class="min-h-screen w-full border-t border-gray-300 mt-11 flex">
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-50">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-l font-semibold p-4">Dashboard</h1>
                    <div class="space-x-1"></div>
                </div>

                <!-- Boxes -->
                <div class="grid grid-cols-4 gap-2">
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold mb-2">
                            Number of Reservations this Month
                        </h3>
                        <div>{{ 15 }}</div>
                    </div>
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold">
                            Equipment Disposed this Month
                        </h3>
                        <div>{{ 20 }}</div>
                    </div>
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold">
                            Equipment Replaced this Month
                        </h3>
                        <div>{{ 12 }}</div>
                    </div>
                    <div>
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow p-4"
                        >
                            <Calendar />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2">
                    <div class="my-2">
                        <div>
                            <div
                                class="flex space-x-5 border items-center rounded-md border-gray-200 p-2"
                            >
                                <h3 class="text-lg font-semibold mb-2">
                                    Transaction Record
                                </h3>
                                <select
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg"
                                    required
                                >
                                    <option value="">All Categories</option>
                                    <option value="">Approve</option>
                                    <option value="">Receive</option>
                                    <option value="">Reject</option>
                                    <option value="">Replacement</option>
                                </select>
                            </div>
                            <TransactionTable></TransactionTable>
                        </div>
                    </div>
                    <div class="my-2">
                        <div
                            class="flex space-x-5 border items-center rounded-md border-gray-200 p-2"
                        >
                            <h3 class="text-lg font-semibold mb-2">
                                Replacement Record
                            </h3>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg"
                                required
                            >
                                <option value="">All Categories</option>
                                <option value="">Replaced</option>
                                <option value="">Pending</option>
                            </select>
                        </div>
                        <div>
                            <ReplacementTable></ReplacementTable>
                        </div>
                    </div>
                    <div class="my-2">
                        <div
                            class="flex space-x-5 border items-center rounded-md border-gray-200 p-2"
                        >
                            <h3 class="text-lg font-semibold mb-2">
                                Cash Record
                            </h3>
                        </div>
                        <div>
                            <CashTable></CashTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";
import TransactionTable from "../component/TransactionTable.vue";
import ReplacementTable from "../component/ReplacementTable.vue";
import CashTable from "../component/CashTable.vue";
import Calendar from "./Calendar.vue";

export default {
    components: {
        TransactionTable,
        ReplacementTable,
        Calendar,
        CashTable,
    },
    data() {
        return {};
    },
    mounted() {},
    methods: {},
};
</script>
