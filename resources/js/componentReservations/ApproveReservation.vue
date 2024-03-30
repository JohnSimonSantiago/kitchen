<template>
    <Button
        label="Approve Reservation"
        icon="pi pi-thumbs-up-fill"
        @click="visible = true"
        class="flex border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Approve Reservation"
        :style="{ width: '25rem' }"
    >
        <Message :closable="false" severity="warn"
            >Note: You cannot edit Reservations once it has been
            approved</Message
        >
        <div class="flex justify-content-end gap-2">
            <Button
                type="button"
                label="Cancel"
                severity="secondary"
                @click="visible = false"
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
        approveReservation() {
            axios
                .post("/approve-reservation", {
                    ID: this.idReservation,
                    id: this.idEquipment,
                })
                .then((response) => {
                    if (response.data.success) {
                        ToastService.add({
                            severity: "success",
                            summary: "Success!",
                            detail: "Reservation Approved Successfully!",
                            life: 3000,
                        });
                        this.$emit("Refresh");
                    } 
                    this.visible = false; // Move this line inside the `then` block
                })
                .catch((error) => {
                    console.error("Error approving reservation:", error);
                });
        },
    },
};
</script>
