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
                        Replacement Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        Reservation Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">Equipment</th>
                    <th scope="col" class="text-center px-6 py-3">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(replacement, index) in replacementDetails"
                    :key="replacement.id"
                >
                    <td class="text-center">
                        {{ replacement.id }}
                    </td>
                    <td class="text-center">
                        {{ replacement.reservationNumber }}
                    </td>
                    <td class="text-center">
                        {{ getName(replacement.equipment_id) }}
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
            equipmentNameAndImage: {},
        };
    },
    mounted() {
        this.getterReplacementDetails();
        this.getEquipmentNameAndImage();
    },
    methods: {
        getterReplacementDetails() {
            axios
                .get("/get-replacement-details")
                .then(({ data }) => {
                    this.replacementDetails = data;
                })
                .catch((error) => {
                    console.error("Error fetching replacement details:", error);
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
