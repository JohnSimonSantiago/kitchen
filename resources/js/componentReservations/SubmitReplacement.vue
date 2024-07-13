<template>
    <Button
        label="Submit Replacement"
        icon="pi pi-sort-alt"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Submit Replacement"
        :style="{ width: '25rem' }"
    >

        <div class="bg-gray-200 rounded-md px-4 py-2 my-2">
        <div v-for="order in reservationOrder" :key="order.id">
            <ReplacementCard :orderDetails="order" />
        </div>
    </div>

        <div class="flex justify-content-end gap-2">
            <Button
                type="button"
                label="Cancel"
                severity="secondary"
                @click="visible = false"
            ></Button>
            <Button
                type="button"
                label="Submit"
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
import Dialog from 'primevue/dialog';
import Toast from "primevue/toast";
import ReplacementCard from "../Card_small/ReplacementCard.vue";

export default {
    data() {
        return {
            visible: false,
            replacementDetails: [],
        };
    },
    props: ["idReservation"],
    components: {
        Modal,
        Dialog,
        ReplacementCard,
        Button,
        Toast,
        Message,
    },
    mounted() {
        this.getterReplacementDetails();
        this.getterReservationOrder();
    },
    methods: {
        saveAndSubmit() {
            this.replaceReservation();
            this.visible = false;
        },
        replaceReservation() {
            axios
                .post("/replace-reservation", { ID: this.idReservation })
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
        getterReservationOrder() {
            axios
                .get("/get-replacement-details", {
                    params: {
                        reservationNumber: this.idReservation,
                    },
                })
                .then(({ data }) => {
                    this.reservationOrder = data;
                    console.log(this.reservationOrder);
                });
        },
        getterReplacementDetails() {
            axios.get("/get-replacement-details").then(({ data }) => {
                this.replacementDetails = data;
            });
        },
    },
};
</script>
