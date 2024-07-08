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
                        <div>{{ 15 }}</div>
                    </div>

                    <!-- Number of Disposed Equipment Box -->
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow p-4 flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold mb-2">
                            Number of Disposed Equipment this Month
                        </h3>
                        <div>{{ 20 }}</div>
                    </div>
                    <div class="my-2">
                    <div>
                        <div
                        class="bg-white border border-gray-200 rounded-lg shadow p-4 flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold mb-2">
                            Transaction Record
                        </h3>
                    </div>
                        <TransactionTable
                        ></TransactionTable>
                    </div>
                </div>
                <div class="my-2">
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow p-4 flex flex-col items-center justify-center"
                    >
                        <h3 class="text-lg font-semibold mb-2">
                            Replacement Record
                        </h3>
                    </div>
                    <div>
                        <ReplacementTable
                        ></ReplacementTable>
                    </div>  
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
import ReplacementTable from "../component/ReplacementTable.vue";

export default {
    components: {
        TransactionTable,
        ReplacementTable,
    },
    data() {
        return {};
    },
    mounted() {},
    methods: {},
};
</script>
