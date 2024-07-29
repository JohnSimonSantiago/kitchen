<template>
    <div>
        <Button
            label="Submit Replacement"
            icon="pi pi-sort-alt"
            @click="visible = true"
            class="border border-green-500 w-full p-2 hover:bg-green-600 hover:text-white"
        />
        <Dialog
            v-model:visible="visible"
            modal
            header="Submit Replacement"
            :style="{ width: '40rem' }"
        >
            <Message :closable="false" severity="info"
                >Note: 1 Equipment = 3 Replacements</Message
            >
            <div class="bg-gray-200 rounded-md px-4 py-2 my-2">
                <span class="text-gray-900 dark:text-white font-bold mr-8"
                    >Replacement</span
                >
                <div class="text-right mb-2 mr-14">
                    <span class="text-gray-900 dark:text-white font-bold mr-8"
                        >Replacement</span
                    >
                    <span class="text-gray-900 dark:text-white font-bold"
                        >Cash Replacement</span
                    >
                </div>
                <div v-for="order in reservationOrder" :key="order.id">
                    <ReplacementCard
                        :orderDetails="order"
                        @updateTotalAmount="updateTotalAmount"
                        @updateReplacementQuantity="updateReplacementQuantity"
                        @updateRightQuantity="updateRightQuantity"
                    />
                </div>
                <div class="text-right mt-4">
                    <p class="text-gray-900 dark:text-white">
                        Final Total Price: ₱ {{ finalTotalPrice.toFixed(2) }}
                    </p>
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
    </div>
</template>

<script>
import axios from "axios";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import ReplacementCard from "../Card_small/ReplacementCard.vue";
import Message from "primevue/message";

export default {
    data() {
        return {
            visible: false,
            reservationOrder: [],
            totalAmounts: {},
            replacementQuantities: {},
            rightQuantities: {},
        };
    },
    props: ["idReservation"],
    components: {
        Button,
        Message,
        Dialog,
        Toast,
        ReplacementCard,
    },
    methods: {
        updateRightQuantity(data) {
            this.rightQuantities[data.equipment_id] = data.quantity;
        },
        updateReplacementQuantity(data) {
            this.replacementQuantities[data.equipment_id] = data.quantity;
        },
        saveAndSubmit() {
            this.submitReplacementReservation();
            this.visible = false;
        },
        submitReplacementReservation() {
            const replacements = Object.entries(this.replacementQuantities).map(
                ([equipment_id, quantity]) => ({
                    equipment_id,
                    quantity,
                    right_quantity: this.rightQuantities[equipment_id] || 0,
                    total_amount: this.totalAmounts[equipment_id] || 0,
                })
            );

            axios
                .post("/submit-replacement-reservation", {
                    ID: this.idReservation,
                    replacements: replacements,
                })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Reservation Replaced Successfully!",
                        life: 3000,
                    });
                    this.$emit("Refresh");
                })
                .catch((error) => {
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail:
                            "Failed to replace reservation: " + error.message,
                        life: 5000,
                    });
                });
        },
        getterReplacementDetails() {
            axios
                .get("/get-replacement-details", {
                    params: {
                        reservationNumber: this.idReservation,
                    },
                })
                .then(({ data }) => {
                    this.reservationOrder = data;
                });
        },
        updateTotalAmount(equipmentId, amount) {
            this.totalAmounts[equipmentId] = amount;
            this.$forceUpdate(); // Force Vue to re-render
        },
    },
    mounted() {
        this.getterReplacementDetails();
    },
    computed: {
        finalTotalPrice() {
            return Object.values(this.totalAmounts).reduce(
                (sum, amount) => sum + amount,
                0
            );
        },
    },
};
</script>
