<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="text-center px-6 py-3">
                        Transaction Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        Transaction Type
                    </th>
                    <th scope="col" class="text-center px-6 py-3">Equipment</th>
                    <th scope="col" class="text-center px-6 py-3">Condition</th>
                    <th scope="col" class="text-center px-6 py-3">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(transaction, index) in transactions" key="index0">
                    <td class="text-center">
                        {{ transaction.id }}
                    </td>
                    <td class="text-center">
                        {{ transaction.transaction_type }}
                    </td>
                    <td class="text-center">
                        {{ transaction.equipment_id }}
                    </td>
                    <td class="text-center">
                        {{ transaction.condition_id }}
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
    mounted() {
        this.getterTransactions();

    },
    data() {
        return {
            transactions: [],
        };
    },
    props: ["reservationDetails"],
    methods: {
        getterTransactions() {
            axios.get("/get-transactions").then(({ data }) => {
                this.reservations = data;
            });
        },
        readMore(transaction) {
            this.$emit("clicked", transaction);

            this.$emit("reservationSelected", reservation.reservationNumber);
        },

    },
};
</script>
