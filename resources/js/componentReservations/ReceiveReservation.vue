<template>
    <Button
        label="Receive Reservation"
        icon="pi pi-download"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Receive Reservation"
        :style="{ width: '25rem' }"
        @hide="resetDialog"
    >
        <!-- Part 1 -->
        <div v-if="currentStep === 1">
            <div>
                <p>Is Equipment Complete?</p>
            </div>

                <div class="bg-gray-200 rounded-md px-4 py-2">
                    <div v-for="order in reservationOrder" :key="order.id">
                        <OrderCard :orderDetails="order" />
                    </div>
                </div>
     
            <div class="flex gap-2">
                <Button
                    icon="pi pi-thumbs-down-fill"
                    class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
                    label="No"
                    @click="skipToPart3"
                />
                <Button
                    icon="pi pi-thumbs-up-fill"
                    class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                    label="Yes"
                    @click="nextStep"
                />
            </div>
        </div>

        <!-- Part 2 -->
        <div v-if="currentStep === 2">

            <div class="flex gap-2">
                <Button
                    icon="pi pi-thumbs-down-fill"
                    class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
                    label="Cancel"
                    @click="closeDialog"
                />
                <Button
                    icon="pi pi-thumbs-up-fill"
                    class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                    label="Receive"
                    @click="receiveReservation"
                />
            </div>
        </div>

        <!-- Part 3 -->
        <div v-if="currentStep === 3">
            <div>
                <p>Input Received Equipment</p>
            </div>
            <div class="bg-gray-200 rounded-md px-4 py-2">
                <div v-for="order in reservationOrder" :key="order.id">
                    <EditQuantityOrderCard :orderDetails="order" />
                </div>
            </div>
            <div class="flex gap-2">
                <Button
                    class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
                    label="Cancel"
                    @click="closeDialog"
                />
                <Button
                    class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                    label="Confirm"
                    @click=""
                />
            </div>
        </div>
    </Dialog>
    <Toast />
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Button from "primevue/button";
import Toast from "primevue/toast";
import Dialog from "primevue/Dialog";
import EditQuantityOrderCard from "../Card_small/EditQuantityOrderCard.vue";
import OrderCard from "../Card_small/OrderCard.vue";

export default {
    props: ["idReservation"],
    data() {
        return {
            visible: false,
            currentStep: 1,
            reservationOrder: [],
            modalContent: {
                title: "Return Reservation",
                content: "",
            },
        };
    },
    mounted() {
        this.getterReservationOrder();
    },
    components: {
        Toast,
        Dialog,
        Modal,
        OrderCard,
        Button,
        EditQuantityOrderCard,
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
        rejectReservation() {
            axios
                .post("/receive-reservation", { ID: this.idReservation })
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
        nextStep() {
            this.currentStep++;
        },
        skipToPart3() {
            this.currentStep = 3;
        },
        closeDialog() {
            this.visible = false;
            this.currentStep = 1;
        },

        receiveReservation() {
            axios
                .post("/receive-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Equipment Received Successfully!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                });
        },
    },
};
</script>
