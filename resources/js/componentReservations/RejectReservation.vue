<template>
    <Button
        label="Reject Reservation"
        icon="pi pi-thumbs-down-fill"
        @click="visible = true"
        class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Reject Reservation"
        :style="{ width: '25rem' }"
    >
        <Message :closable="false" severity="error"
            >Warning: You cannot undo this action</Message
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
                label="Reject"
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
import Dialog from "primevue/Dialog";
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
        rejectReservation() {
            axios
                .post("/reject-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Rejected Successfully!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                });
        },
    },
};
</script>
