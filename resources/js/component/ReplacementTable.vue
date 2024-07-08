<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead>
                <tr class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="text-center px-6 py-3">
                        Replacement Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        Reservation Number 
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        Equipment
                    </th>

                    <th scope="col" class="text-center px-6 py-3">
                        Quantity
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(replacement, index) in replacementDetails" :key="replacement.id">
                    <td class="text-center">
                        {{ replacement.id }}
                    </td>
                    <td class="text-center">
                        {{ replacement.reservationNumber }}
                    </td>
                    <td class="text-center">
                        {{ replacement.equipment_id }}
                    </td>

                    <td class="text-center">
                        {{ replacement.quantity }}
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
            replacementDetails: [],
        };
    },
    mounted() {
        this.getterReplacementDetails();
    },
    methods: {
        getterReplacementDetails() {
            axios.get("/get-replacement-details")
                .then(({ data }) => {
                    console.log(data); // Log the data to the console
                    this.replacementDetails = data;
                })
                .catch(error => {
                    console.error("Error fetching replacement details:", error);
                });
        },
    },
};
</script>
