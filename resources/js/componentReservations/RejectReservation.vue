<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Reject Reservation',
            content: 'Are you sure you want to reject this reservation?',
        }"
        buttonLabel="Reject"
        cancelLabel="Cancel"
        saveLabel="Reject"
        :saveOption="true"
        @save="rejectReservation"
    >
        <Message :closable="false" severity="error"
            >Warning: You cannot undo this action</Message
        >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Message from "primevue/message";

export default {
    props: ["idReservation"],
    components: {
        Modal,
        Message,
    },
    methods: {
        rejectReservation() {
            axios
                .post("/reject-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$emit("deleted");
                });
        },
    },
};
</script>
