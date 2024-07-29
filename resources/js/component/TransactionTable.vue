<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="text-center px-2 py-3 w-16">
                        Transaction Number
                    </th>
                    <th scope="col" class="text-center px-2 w-16">
                        Reservation Number
                    </th>
                    <th scope="col" class="text-center px-2">
                        Transaction Type
                    </th>
                    <th scope="col" class="text-center px-2">Equipment</th>

                    <th scope="col" class="text-center px-2">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(transaction, index) in transactions"
                    :key="transaction.id"
                >
                    <td class="text-center">
                        {{ transaction.id }}
                    </td>
                    <td class="text-center">
                        {{ transaction.reservation_number }}
                    </td>
                    <td class="text-center">
                        {{ getTransactionType(transaction.transaction_type) }}
                    </td>
                    <td class="text-center">
                        {{ getName(transaction.equipment_id) }}
                    </td>

                    <td class="text-center">
                        {{ transaction.quantity }}
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
import Message from "primevue/message";

export default {
    components: {
        Modal,
        Button,
        Message,
    },

    data() {
        return {
            transactions: [],
            equipmentNameAndImage: {},
        };
    },
    mounted() {
        this.getterTransactions();
        this.getEquipmentNameAndImage();
    },
    methods: {
        getterTransactions() {
            axios
                .get("/get-transactions")
                .then(({ data }) => {
                    this.transactions = data;
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
        getCondition(condition_id) {
            switch (condition_id) {
                case 1:
                    return "Good";
                case 2:
                    return "Damaged";
                case 3:
                    return "Bad";
                default:
                    return "Unknown";
            }
        },
        getTransactionType(transaction_type) {
            switch (transaction_type) {
                case 1:
                    return "Approve";
                case 2:
                    return "Receive";
                case 3:
                    return "Reject";
                case 4:
                    return "Return";
                case 5:
                    return "Submit Replacement";
                default:
                    return "Unknown";
            }
        },
    },
};
</script>
