<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full h-[300px] text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="text-center px-6 py-3">
                        Cash Log Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        Reservation Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">Equipment</th>
                    <th scope="col" class="text-center px-6 py-3">Quantity</th>
                    <th scope="col" class="text-center px-6 py-3">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cashLog in paginatedCashLogs" :key="cashLog.id">
                    <td class="text-center">{{ cashLog.id }}</td>
                    <td class="text-center">
                        {{ cashLog.reservation_number }}
                    </td>
                    <td class="text-center">
                        {{ getName(cashLog.equipment_id) }}
                    </td>
                    <td class="text-center">{{ cashLog.quantity }}</td>
                    <td class="text-center">{{ cashLog.cashAmount }}</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-start p-2">
            <button
                @click="currentPage = 1"
                :disabled="currentPage === 1"
                class="px-3 py-1 mx-1 bg-gray-200 rounded"
            >
                First
            </button>
            <button
                v-for="page in displayedPages"
                :key="page"
                @click="currentPage = page"
                :class="[
                    'px-3 py-1 mx-1 rounded',
                    {
                        'bg-gray-300': currentPage === page,
                        'bg-gray-200': currentPage !== page,
                    },
                ]"
            >
                {{ page }}
            </button>
            <button
                @click="currentPage = totalPages"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 mx-1 bg-gray-200 rounded"
            >
                Last
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Button from "primevue/button";
import Message from "primevue/message";

export default {
    components: {
        Modal,
        Button,
        Message,
    },
    data() {
        return {
            cashLogsDetails: [],
            equipmentNameAndImage: {},
            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    mounted() {
        this.getterCashLogs();
        this.getEquipmentNameAndImage();
    },
    computed: {
        totalPages() {
            return Math.ceil(this.cashLogsDetails.length / this.itemsPerPage);
        },
        paginatedCashLogs() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = this.currentPage * this.itemsPerPage;
            return this.cashLogsDetails.slice(start, end);
        },
        displayedPages() {
            const pages = [];
            let startPage = Math.max(1, this.currentPage - 2);
            let endPage = Math.min(this.totalPages, this.currentPage + 2);

            if (this.currentPage <= 3) {
                endPage = Math.min(5, this.totalPages);
            } else if (this.currentPage > this.totalPages - 3) {
                startPage = Math.max(1, this.totalPages - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }

            return pages;
        },
    },
    methods: {
        getterCashLogs() {
            axios
                .get("/get-cash-logs")
                .then(({ data }) => {
                    this.cashLogsDetails = data.reverse(); // Reverse the array for LIFO order
                })
                .catch((error) => {
                    console.error("Error fetching cash logs details:", error);
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
