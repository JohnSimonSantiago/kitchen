<template>
    <Button
        label="Create Reservation"
        icon="pi pi-file-edit"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Create Reservation"
        :style="{ width: '40rem' }"
    >
        <form class="" @submit.prevent="saveAndSubmit">
            <div class="gap-6 mb-6 flex items-center justify-center">
                <div>
                    <div class="">
                        <label
                            for="customer_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Customer Name</label
                        >
                        <div class="flex items-center">
                            <input
                                v-model="customerName"
                                type="text"
                                id="customer_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Customer Name"
                                required
                            />
                        </div>
                    </div>
                    <div>
                        <label
                            for="customer_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Customer Contact Number</label
                        >
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
                            >
                                +639
                            </span>
                            <input
                                v-model="customerNumber"
                                type="text"
                                id="customer_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="9-digit Phone Number"
                                required
                            />
                        </div>
                        <Message v-if="showPhoneError" severity="error"
                            >Invalid format</Message
                        >
                    </div>
                    <div>
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Email</label
                        >
                        <input
                            v-model="email"
                            type="email"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="sample@sample.com"
                            required
                        />
                        <Message v-if="showEmailError" severity="error"
                            >Invalid format</Message
                        >
                    </div>
                </div>

                <div class="flex flex-col">
                    <Calendar
                        v-model="selectedRange"
                        selectionMode="range"
                        inline
                    ></Calendar>
                </div>
            </div>
            <div class="flex justify-content-end gap-2">
                <Button
                    type="button"
                    label="Cancel"
                    severity="secondary"
                    @click="visible = false"
                ></Button>
                <Button type="submit" label="Submit"></Button>
            </div>
        </form>
    </Dialog>
    <Toast />
</template>
<script>
import Dialog from "primevue/dialog";
import Calendar from "primevue/calendar";
import Toast from "primevue/toast";
import Button from "primevue/button";
import axios from "axios";
import Message from "primevue/message";

export default {
    components: {
        Calendar,
        Dialog,
        Button,
        Message,
        Toast,
    },
    data() {
        return {
            visible: false,
            customerName: null,
            customerNumber: null,
            email: null,
            selectedRange: null,
            showPhoneError: false,
            showEmailError: false,
        };
    },
    methods: {
        saveAndSubmit() {
            this.showPhoneError = !this.isValidPhoneNumber();
            this.showEmailError = !this.isValidEmail();

            if (!this.showPhoneError && !this.showEmailError) {
                this.submitReservation();
                this.visible = false;
            }
        },
        submitReservation() {
            const { customerName, customerNumber, email, selectedRange } = this;
            let dateStart = selectedRange[0];
            let dateEnd = selectedRange[1];

            axios
                .post("/submit-reservation", {
                    customerName,
                    customerNumber,
                    email,
                    dateStart,
                    dateEnd,
                })
                .then(({ data }) => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Created Successfully!",
                        life: 3000,
                    });
                    this.$emit("success");
                })
                .catch((error) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to create reservation",
                        life: 3000,
                    });
                    console.error("Error submitting reservation:", error);
                });
        },
        isValidPhoneNumber() {
            return (
                this.customerNumber &&
                this.customerNumber.length === 9 &&
                /^\d+$/.test(this.customerNumber)
            );
        },
        isValidEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return this.email && emailRegex.test(this.email);
        },
    },
};
</script>
