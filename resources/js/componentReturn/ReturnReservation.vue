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
    props: ["idReservation", "idEquipment"],
    components: {
        Modal,
    },
    methods: {
        returnReservation() {},
    },
};
</script>
