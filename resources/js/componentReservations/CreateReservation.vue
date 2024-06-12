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
        <form class="">
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

                        <input
                            v-model="customerNumber"
                            type="text"
                            id="customer_number"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="9-digit Phone Number"
                            required
                        />
                    </div>
                    <div>
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Email</label
                        >

                        <input
                            v-model="email"
                            type="text"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="sample@sample.com"
                            required
                        />
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
                <Button
                    type="button"
                    label="Save"
                    @click="saveAndSubmit"
                ></Button>
            </div>
        </form>
    </Dialog>
    <Toast />
</template>

<script>
import Dialog from "primevue/Dialog";
import Calendar from "primevue/calendar";
import Toast from "primevue/toast";
import Button from "primevue/button";
import axios from 'axios';

export default {
    components: {
        Calendar,
        Dialog,
        Button,
        Toast,
    },
    data() {
        return {
            visible: false,
            customerName: null,
            customerNumber: null,
            email: null,
            selectedRange: null,
        };
    },

    methods: {
    saveAndSubmit() {
        this.submitReservation();
        this.visible = false;
    },
    submitReservation() {
        const { customerName, customerNumber, email, selectedRange } = this;
        let dateStart = selectedRange[0];
        let dateEnd = selectedRange[1];

        axios
            .post("/submit-reservation", {
                user_id: 1, // Automatically set the user_id to 1
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
                this.$router.push('/reservations');
            })
            .catch(error => {
                this.$toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Failed to create reservation",
                    life: 3000,
                });
                console.error("Error submitting reservation:", error);
            });
    },
},

};
</script>
