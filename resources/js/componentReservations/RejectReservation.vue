<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Reject Reservation',
            content: 'Are you sure you want to reject?',
        }"
        buttonLabel="Reject"
        cancelLabel="Cancel"
        saveLabel="Reject"
        :saveOption="true"
        @save="rejectReservation"
    >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";

export default {
    props: ["idReservation"],
    components: {
        Modal,
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
