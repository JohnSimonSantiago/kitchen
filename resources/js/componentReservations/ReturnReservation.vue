<template>
    <Button
        label="Return Reservation"
        icon="pi pi-undo"
        @click="visible = true"
        class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Return Reservation"
        :style="{ width: '25rem' }"
    >
        <!-- Part 1: -->
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
                    @click="skipToPart4"
                />
                <Button
                    icon="pi pi-thumbs-up-fill"
                    class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                    label="Yes"
                    @click="nextStep"
                />

            </div>
        </div>

        <!-- Part 2: -->
        <div v-if="currentStep === 2">
            <div>
                <p>Is Equipment in Good Condition?</p>
            </div>
            <div class="flex gap-2">
                <Button
                    icon="pi pi-thumbs-down-fill"
                    class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
                    label="No"
                    @click="skipToPar5"
                />
                <Button
                    icon="pi pi-thumbs-up-fill"
                    class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                    label="Yes"
                    @click="returnReservation"
                />

            </div>
        </div>

        <!-- Part 3: -->
        <div v-if="currentStep === 3">
            <Button
                class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
                label="Return Equipment Now"
                @click="returnReservation"
            />
        </div>

        <!-- Part : -->
        <div v-if="currentStep === 4">
    <p>Input Missing Equipment</p>
    <div class="bg-gray-200 rounded-md px-4 py-2 my-2">
        <div v-for="order in reservationOrder" :key="order.id">
            <InputMissingEquipmentCard :orderDetails="order" />
        </div>
    </div>
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
            label="Confirm"
            @click="submitReplacementDetails"
        />
    </div>
</div>

        <!-- Part 5: -->
        <div v-if="currentStep === 5">
            <p>This is Part 5 .</p>
        </div>
    </Dialog>
    <Toast />
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Button from "primevue/button";
import Toast from "primevue/toast";
import Dialog from 'primevue/dialog';
import OrderCard from "../Card_small/OrderCard.vue";
import InputMissingEquipmentCard from "../Card_small/InputMissingEquipmentCard.vue";


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
    components: {
        Toast,
        OrderCard,
        InputMissingEquipmentCard,
        Dialog,
        Modal,
        Button,
    },
    mounted() {
        this.getterReservationOrder();
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
                    console.log(this.reservationOrder);
                });
        },
        nextStep() {
            this.currentStep++;
        },
        skipToPart4() {
            this.currentStep = 4;
        },
        skipToPar5() {
            this.currentStep = 5;
        },
        closeDialog() {
            this.visible = false;
            this.currentStep = 1;
        },
        returnReservationIncomplete() {
            axios
                .post("/return-reservation-incomplete", { ID: this.idReservation })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Returned Incompletely!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                });
        },
        submitReplacementDetails() {
        const replacementDetails = this.reservationOrder.map(order => ({
            reservationNumber: this.idReservation,
            equipment_id: order.equipment_id,
            quantity: order.quantity,
        }));

        axios.post("/submit-replacement-details", replacementDetails)
            .then(() => {
                this.$toast.add({
                    severity: "success",
                    summary: "Success!",
                    detail: "Replacement details submitted successfully!",
                    life: 3000,
                });
                this.$emit("Refresh");
            })
            .catch(error => {
                console.error("Error submitting replacement details:", error);
                this.$toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Failed to submit replacement details.",
                    life: 3000,
                });
            });
    },
        returnReservation() {
            axios
                .post("/return-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Returned Successfully!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                });
        },
    },
};
</script>
