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
        <Button label="Show" @click="show()" />
        <Toast />
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Button from "primevue/button";

import Toast from "primevue/toast";

export default {
    props: ["idReservation"],
    components: {
        Toast,
        Modal,
        Button,
    },
    methods: {
        returnReservation() {
            axios
                .post("/return-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$toast.add({
                        severity: "info",
                        summary: "Info",
                        detail: "AWDWAHDJAWDWAJDAW",
                        life: 3000,
                    });
                    this.$emit("returned");
                });
        },
        show() {
            this.$toast.add({
                severity: "info",
                summary: "Info",
                detail: "Message Content",
                life: 3000,
            });
        },
    },
};
</script>
