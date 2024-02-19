<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Approve Reservation',
            content: 'Are you sure you want to approve?',
        }"
        buttonLabel="Approve Order"
        cancelLabel="Cancel"
        saveLabel="Approve"
        :saveOption="true"
        @save="approveReservation"
    >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";

export default {
    props: ["idReservation", "idEquipment"],
    components: {
        Modal,
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
