<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full h-[300px] text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
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
                    v-for="(transaction, index) in paginatedTransactions"
                    :key="transaction.id"
                >
                    <td class="text-center">{{ transaction.id }}</td>
                    <td class="text-center">
                        {{ transaction.reservation_number }}
                    </td>
                    <td class="text-center">
                        {{ getTransactionType(transaction.transaction_type) }}
                    </td>
                    <td class="text-center">
                        {{ getName(transaction.equipment_id) }}
                    </td>
                    <td class="text-center">{{ transaction.quantity }}</td>
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
export default {
    props: ["transactions"],
    data() {
        return {
            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.transactions.length / this.itemsPerPage);
        },
        paginatedTransactions() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = this.currentPage * this.itemsPerPage;
            return this.transactions.slice(start, end);
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
        getName(equipment_id) {
            // This method should be implemented or passed as a prop from the parent component
            // For now, we'll return a placeholder
            return "Equipment Name";
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
