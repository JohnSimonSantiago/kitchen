<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Approve Reservation',
            content: 'Are you sure you want to approve?',
        }"
        buttonLabel="Approve Reservation"
        cancelLabel="Cancel"
        saveLabel="Approve"
        :saveOption="true"
        @save="approveReservation"
    >
        <Message :closable="false" severity="warn"
            >Note: You cannot edit Reservations once it has been
            approved</Message
        >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Message from "primevue/message";

export default {
    props: ["idReservation", "idEquipment"],
    components: {
        Modal,
        Message,
    },
    methods: {
        approveReservation() {
            axios
                .post("/approve-reservation", {
                    ID: this.idReservation,
                    id: this.idEquipment,
                })
                .then(() => {
                    this.$emit("approved");
                })
                .catch((error) => {
                    console.error("Error approving reservation:", error);
                });
        },
    },
};
</script>
