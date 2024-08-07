<template>
    <Layout>
        <div class="min-h-screen w-full border-t border-gray-300 mt-11 flex">
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-50 mt-4">
                <div
                    class="flex space-x-5 border p-3 items-center rounded-md border-gray-400"
                >
                    <h3 class="flex items-center ml-2 text-lg font-semibold">
                        Transaction Record:
                    </h3>
                    <div>
                        <select
                            v-model="selectedTransactionType"
                            @change="filterTransactions"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                            required
                        >
                            <option value="">All Categories</option>
                            <option value="1">Approve</option>
                            <option value="2">Receive</option>
                            <option value="3">Reject</option>
                            <option value="4">Return</option>
                            <option value="5">Submit Replacement</option>
                        </select>
                    </div>
                    <h3 class="flex items-center text-lg font-semibold">
                        Replacement Record:
                    </h3>
                    <div>
                        <select
                            v-model="selectedReplacementStatus"
                            @change="filterReplacements"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                            required
                        >
                            <option value="">All Categories</option>
                            <option value="0">Pending</option>
                            <option value="1">Replaced</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="my-2">
                        <div>
                            <TransactionTable
                                :transactions="filteredTransactions"
                                :getName="getName"
                            ></TransactionTable>
                        </div>
                    </div>
                    <!-- Boxes -->
                    <div class="flex grid grid-cols-2 gap-2 my-2">
                        <div class="grid grid-cols-2 gap-2">
                            <div
                                class="bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center"
                            >
                                <h3 class="text-lg font-semibold mb-2">
                                    Reservations
                                </h3>
                                <div>{{ 15 }}</div>
                            </div>
                            <div
                                class="bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center"
                            >
                                <h3 class="text-lg font-semibold">Equipment</h3>
                                <div>{{ 20 }}</div>
                            </div>
                            <div
                                class="bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center"
                            >
                                <h3 class="text-lg font-semibold">Equipment</h3>
                                <div>{{ 12 }}</div>
                            </div>
                            <div
                                class="bg-white border border-gray-200 rounded-lg flex flex-col items-center justify-center"
                            >
                                <h3 class="text-lg font-semibold">Cash</h3>
                                <div>{{ 12 }}</div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div><Calendar /></div>
                            <div
                                class="bg-white border h-full border-gray-200 rounded-lg flex flex-col items-center justify-center"
                            >
                                <h3 class="text-lg font-semibold">
                                    Upcoming reservation:
                                </h3>
                                <div>awdawd</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <ReplacementTable
                                ref="replacementTable"
                            ></ReplacementTable>
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

import Calendar from "./Calendar.vue";

export default {
    components: {
        TransactionTable,
        ReplacementTable,
        Calendar,
    },
    data() {
        return {
            transactions: [],
            filteredTransactions: [],
            selectedTransactionType: "",
            selectedReplacementStatus: "",
            equipmentNameAndImage: {},
        };
    },
    mounted() {
        this.getterTransactions();
        this.getEquipmentNameAndImage();
    },
    methods: {
        filterTransactions() {
            if (this.selectedTransactionType === "") {
                this.filteredTransactions = this.transactions;
            } else {
                this.filteredTransactions = this.transactions.filter(
                    (transaction) =>
                        transaction.transaction_type ===
                        parseInt(this.selectedTransactionType)
                );
            }
        },
        filterReplacements() {
            this.$refs.replacementTable.selectedStatus =
                this.selectedReplacementStatus;
            this.$refs.replacementTable.filterReplacements();
        },
        getterTransactions() {
            axios
                .get("/get-transactions")
                .then(({ data }) => {
                    this.transactions = data.sort((a, b) => b.id - a.id);
                    this.filteredTransactions = this.transactions;
                })
                .catch((error) => {
                    console.error("Error fetching transactions:", error);
                });
        },
        getEquipmentNameAndImage() {
            axios
                .get("/get-equipment-name-and-image")
                .then(({ data }) => {
                    data.forEach((equipment) => {
                        this.equipmentNameAndImage[equipment.equipment_id] = {
                            name: equipment.equipmentName,
                            imageSrc: equipment.image,
                        };
                    });
                })
                .catch((error) => {
                    console.error("Error fetching equipment data:", error);
                });
        },
        getName(equipment_id) {
            const equipment = this.equipmentNameAndImage[equipment_id];
            if (equipment) {
                return equipment.name || "Unknown";
            } else {
                return "Unknown";
            }
        },
    },
};
</script>
