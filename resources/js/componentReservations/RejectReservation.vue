<template>
    <Button
        label="Reject"
        icon="pi pi-thumbs-down-fill"
        @click="visible = true"
        class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Reject Reservation"
        :style="{ width: '30rem' }"
    >
        <div>
            <label
                for="description"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Remarks:</label
            >
            <textarea
                v-model="remarks"
                id="remarks"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Note"
                rows="3"
                required
            ></textarea>
        </div>
        <Message :closable="false" severity="error"
            >Warning: You cannot undo this action</Message
        >
        <div class="flex justify-content-end gap-2">
            <Button
                type="button"
                label="Cancel"
                icon="pi pi-thumbs-down-fill"
                class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
                severity="secondary"
                @click="visible = false"
            ></Button>
            <Button
                type="button"
                label="Reject"
                icon="pi pi-thumbs-up-fill"
                class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                @click="saveAndSubmit"
            ></Button>
        </div>
    </Dialog>
    <Toast />
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Message from "primevue/message";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";

export default {
    data() {
        return {
            visible: false,
        };
    },
    props: ["idReservation"],
    components: {
        Modal,
        Dialog,
        Button,
        Toast,
        Message,
    },
    methods: {
        saveAndSubmit() {
            this.rejectReservation();
            this.visible = false;
        },
        closeDialog() {
            this.visible = false;
            this.currentStep = 1;
        },
        rejectReservation() {
            axios
                .post("/reject-reservation", {
                    ID: this.idReservation,
                    remarks: this.remarks, // Include remarks in the request payload
                })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Rejected Successfully!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                })
                .catch((error) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error!",
                        detail:
                            "Failed to reject reservation: " + error.message,
                        life: 3000,
                    });
                });
        },
    },
};
</script>
