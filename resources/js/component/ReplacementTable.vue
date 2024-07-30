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
                        Replacement Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        Reservation Number
                    </th>
                    <th scope="col" class="text-center px-6 py-3">Equipment</th>
                    <th scope="col" class="text-center px-6 py-3">Quantity</th>
                    <th scope="col" class="text-center px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="replacement in paginatedReplacements"
                    :key="replacement.id"
                >
                    <td class="text-center">{{ replacement.id }}</td>
                    <td class="text-center">
                        {{ replacement.reservationNumber }}
                    </td>
                    <td class="text-center">
                        {{ getName(replacement.equipment_id) }}
                    </td>
                    <td class="text-center">{{ replacement.quantity }}</td>
                    <td class="text-center">
                        <div class="flex justify-center">
                            <Message
                                :closable="false"
                                :severity="
                                    getStatusSeverity(replacement.status)
                                "
                            >
                                {{ getStatusType(replacement.status) }}
                            </Message>
                        </div>
                    </td>
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
import Message from "primevue/message";

export default {
    data() {
        return {
            replacementDetails: [],
            filteredReplacements: [],
            equipmentNameAndImage: {},
            selectedStatus: "",
            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    components: {
        Message,
    },
    mounted() {
        this.getterReplacementDetails();
        this.getEquipmentNameAndImage();
    },
    computed: {
        totalPages() {
            return Math.ceil(
                this.filteredReplacements.length / this.itemsPerPage
            );
        },
        paginatedReplacements() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = this.currentPage * this.itemsPerPage;
            return this.filteredReplacements.slice(start, end);
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
        getterReplacementDetails() {
            axios
                .get("/get-replacement-all")
                .then(({ data }) => {
                    this.replacementDetails = data;
                    this.filterReplacements();
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
        getStatusSeverity(status) {
            switch (status) {
                case 0:
                    return "warn";
                case 1:
                    return "success";

                default:
                    return "info";
            }
        },

        getName(equipment_id) {
            const equipment = this.equipmentNameAndImage[equipment_id];
            if (equipment) {
                return equipment.name || "Unknown";
            } else {
                return "Unknown";
            }
        },
        getStatusType(status) {
            switch (status) {
                case 0:
                    return "Pending";
                case 1:
                    return "Replaced";
                default:
                    return "Unknown";
            }
        },
        filterReplacements() {
            if (this.selectedStatus === "") {
                this.filteredReplacements = this.replacementDetails;
            } else {
                this.filteredReplacements = this.replacementDetails.filter(
                    (replacement) =>
                        replacement.status === parseInt(this.selectedStatus)
                );
            }
            this.currentPage = 1;
        },
    },
};
</script>
