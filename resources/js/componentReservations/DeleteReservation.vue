<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Delete Order',
            content: 'Are you sure you want to delete?',
        }"
        buttonLabel="Delete"
        cancelLabel="Cancel"
        saveLabel="Delete"
        :saveOption="true"
        @save="deleteReservation"
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
        deleteReservation() {
            axios
                .post("/delete-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$emit("deleted");
                });
        },
    },
};
</script>
