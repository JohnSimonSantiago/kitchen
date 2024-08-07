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
                        Category <br />Name
                    </th>
                    <th scope="col" class="text-center px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in paginatedCategories" :key="category.id">
                    <td class="text-center">
                        {{ category.category }}
                    </td>
                    <td class="text-center">
                        <button
                            class="bg-yellow-400 px-4 py-2 rounded-lg text-white hover:bg-yellow-500"
                        >
                            Edit
                        </button>
                    </td>
                    <td></td>
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
            categories: [],

            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    components: {
        Message,
    },
    mounted() {
        this.getterReplacementDetails();
    },
    computed: {
        totalPages() {
            return Math.ceil(this.categories.length / this.itemsPerPage);
        },
        paginatedCategories() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = this.currentPage * this.itemsPerPage;
            return this.categories.slice(start, end);
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
                .get("/get-categories")
                .then(({ data }) => {
                    this.categories = data.reverse(); // Reverse the array for LIFO order
                })
                .catch((error) => {
                    console.error("Error fetching replacement details:", error);
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
