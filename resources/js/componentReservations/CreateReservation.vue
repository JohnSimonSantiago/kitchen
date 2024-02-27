<template>
    <Modal
        :modalContent="{
            title: 'Create Order',
            content: 'Please fill out the form below:',
        }"
        buttonLabel="Create New Reservation +"
        cancelLabel="Cancel"
        saveLabel="Create"
        :saveOption="true"
        @save="submitReservation"
    >
        <div v-if="Error">Error</div>
        <form @submit.prevent="submitReservation">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label
                        for="customer_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Customer Name</label
                    >

                    <input
                        v-model="customerName"
                        type="text"
                        id="customer_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Customer Name"
                        required
                    />
                </div>
                <div>
                    <label
                        for="customer_number"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Customer Contact Number</label
                    >

                    <input
                        v-model="customerNumber"
                        type="text"
                        id="customer_number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Customer Contact Number"
                        required
                    />
                </div>

                <div>
                    <label
                        for="datestart"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Date Start</label
                    >
                    <input
                        v-model="dateStart"
                        type="date"
                        id="date_start"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Date Start"
                        required
                    />
                </div>
                <div>
                    <label
                        for="dateEnd"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Date End</label
                    >
                    <input
                        v-model="dateEnd"
                        type="date"
                        id="date_End"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Date End"
                        required
                    />
                </div>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "../component/Modal.vue";
import { DatePicker } from "v-calendar";

export default {
    components: {
        DatePicker,
        Modal,
    },
    data() {
        return {
            Error: false,
            customerName: null,
            customerNumber: null,
            dateStart: null,
            dateEnd: null,
        };
    },
    methods: {
        submitReservation() {
            const { customerName, customerNumber, dateStart, dateEnd } = this;

            axios
                .post("/submit-reservation", {
                    customerName,
                    customerNumber,
                    dateStart,
                    dateEnd,
                })

                .then(({ data }) => {
                    this.customerName = "";
                    this.customerNumber = "";
                    this.dateStart = "";
                    this.dateEnd = "";
                    this.$emit("success");
                    this.$router.push("/reservations");
                });
        },
    },
};
</script>
