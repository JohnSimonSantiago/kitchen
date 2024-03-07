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
        :style="{ width: '25rem' }"
    >
        <form>
            <div class="grid gap-6 mb-6 md:grid-cols-1">
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

                <div class="card flex flex-center justify-content-center">
                    <Calendar
                        v-model="selectedRange"
                        selectionMode="range"
                        inline
                    />
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
            selectedRange: null,
        };
    },

    methods: {
        saveAndSubmit() {
            this.submitReservation();
            this.visible = false;
        },
        submitReservation() {
            const { customerName, customerNumber, selectedRange } = this;

            let dateStart = selectedRange[0];
            let dateEnd = selectedRange[1];

            axios
                .post("/submit-reservation", {
                    customerName,
                    customerNumber,
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
                    this.customerName = "";
                    this.customerNumber = "";
                    this.selectedRange = null;
                    this.$emit("success");
                    this.$router.push("/reservations");
                });
        },
    },
};
</script>
