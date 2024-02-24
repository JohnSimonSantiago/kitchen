<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Return Reservation',
            content: 'Are you sure you want to return?',
        }"
        buttonLabel="Return Reservation"
        cancelLabel="Cancel"
        saveLabel="Return"
        :saveOption="true"
        @save="returnReservation"
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
        returnReservation() {
            axios
                .post("/return-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$emit("returned");
                });
        },
    },
};
</script>
