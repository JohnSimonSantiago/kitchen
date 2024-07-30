<template>
    <Button
        label="Approve"
        icon="pi pi-thumbs-up-fill"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Approve Reservation"
        :style="{ width: '30rem' }"
    >
        <div class="bg-gray-200 rounded-md px-4 py-2">
            <div v-for="order in reservationOrder" :key="order.id">
                <OrderCard :orderDetails="order" />
            </div>
        </div>
        <Message :closable="false" severity="warn"
            >Note: You cannot edit this reservations once it has been
            approved</Message
        >
        <div class="flex justify-content-end gap-2">
            <Button type="button" label="Cancel" @click="closeDialog"></Button>

            <Button
                type="button"
                label="Approve"
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
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import Button from "primevue/button";
import OrderCard from "../Card_small/OrderCard.vue";

export default {
    props: ["idReservation"],
    data() {
        return {
            visible: false,
            reservationOrder: [],
        };
    },
    mounted() {
        this.getterReservationOrder();
    },
    props: ["idReservation", "idEquipment"],
    components: {
        Modal,
        OrderCard,
        Dialog,
        Button,
        Toast,
        Message,
    },
    methods: {
        getterReservationOrder() {
            axios
                .get("/get-reservation-orders", {
                    params: {
                        reservationNumber: this.idReservation,
                    },
                })
                .then(({ data }) => {
                    this.reservationOrder = data;
                });
        },
        saveAndSubmit() {
            this.approveReservation();
            this.visible = false;
        },
        closeDialog() {
            this.visible = false;
            this.currentStep = 1;
        },
        approveReservation() {
            axios
                .post("/approve-reservation", {
                    ID: this.idReservation,
                    id: this.idEquipment,
                })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Approved Successfully!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                })
                .catch((error) => {
                    if (
                        error.response &&
                        error.response.data &&
                        error.response.data.errors
                    ) {
                        error.response.data.errors.forEach((err) => {
                            this.$toast.add({
                                severity: "error",
                                summary: "Error",
                                detail: err,
                                life: 3000,
                            });
                        });
                    } else {
                        this.$toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: "Failed to approve reservation. Please try again.",
                            life: 3000,
                        });
                    }
                    console.error(error);
                });
        },
    },
};
</script>
