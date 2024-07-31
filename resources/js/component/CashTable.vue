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
                <tr v-for="cashLogs in cashLogsDetails" :key="cashLogs.id">
                    <td class="text-center">{{ cashLogs.id }}</td>
                    <td class="text-center">
                        {{ cashLogs.reservation_number }}
                    </td>
                    <td class="text-center">
                        {{ getName(cashLogs.equipment_id) }}
                    </td>
                    <td class="text-center">{{ cashLogs.quantity }}</td>
                    <td class="text-center">{{ cashLogs.cashAmount }}</td>
                </tr>
            </tbody>
        </table>
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
        };
    },
    mounted() {
        this.getterCashLogs();
        this.getEquipmentNameAndImage();
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
