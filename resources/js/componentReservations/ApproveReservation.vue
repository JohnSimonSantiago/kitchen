<template>
    <Button
        label="Approve Reservation"
        icon="pi pi-thumbs-up-fill"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
        
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Approve Reservation"
        :style="{ width: '25rem' }"
    >
        <Message :closable="false" severity="warn"
            >Note: You cannot edit this reservations once it has been
            approved</Message
        >
        <div class="flex justify-content-end gap-2">
            <Button
                type="button"
                label="Cancel"
       
                @click="closeDialog"
            ></Button>

            <Button
                type="button"
                label="Approve"
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
import Dialog from "primevue/Dialog";
import Toast from "primevue/toast";
import Button from "primevue/button";

export default {
    data() {
        return {
            visible: false,
        };
    },
    props: ["idReservation", "idEquipment"],
    components: {
        Modal,
        Dialog,
        Button,
        Toast,
        Message,
    },
    methods: {
        saveAndSubmit() {
            this.approveReservation();
            this.visible = false;
        },
        closeDialog() {
            this.visible = false;
            this.currentStep = 1;
        },
        approveReservation() {
    axios
        .post("/approve-reservation", { 
            ID: this.idReservation,
            id: this.idEquipment,
        })
        .then(() => {
            this.$toast.add({
                severity: "success",
                summary: "Success!",
                detail: "Reservation Approved Successfully!",
                life: 3000,
            });
            this.$emit("Refresh");
        })
        .catch((error) => {
            this.$toast.add({
                severity: "error",
                summary: "Error",
                detail: "Failed to approve reservation. Please try again.",
                life: 3000,
            });
            console.error(error);
        });
},

    },
};
</script>
