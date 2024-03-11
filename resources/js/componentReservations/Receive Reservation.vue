<template>
    <Button
        label="Receive Reservation"
        icon="pi pi-downnload"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Receive Reservation"
        :style="{ width: '25rem' }"
    >
        <!-- Part 1: -->
        <div v-if="currentStep === 1">
            <div>
                <p>Is Equipment Complete?</p>
            </div>
            <div>
                <Button
                    class="px-4 py-2 ml-2 text-white bg-red-600 rounded-md text-sm"
                    label="No"
                    @click="skipToPart3"
                />
                <Button
                    class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
                    label="Yes"
                    @click="nextStep"
                />
            </div>
        </div>

        <div v-if="currentStep === 2">
            <div>
                <p>Receive Equipment</p>
            </div>
            <div>
                <Button
                    class="px-4 py-2 ml-2 text-white bg-red-600 rounded-md text-sm"
                    label="Cancel"
                    @click=""
                />
                <Button
                    class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
                    label="Receive"
                    @click=""
                />
            </div>
        </div>

        <div v-if="currentStep === 3">
            <div>
                <p>Input Missing Equipment</p>
            </div>
            <div>
                <Button
                    class="px-4 py-2 ml-2 text-white bg-red-600 rounded-md text-sm"
                    label="Cancel"
                    @click=""
                />
                <Button
                    class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
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
import Dialog from "primevue/dialog";

export default {
    props: ["idReservation"],
    data() {
        return {
            visible: false,
            currentStep: 1,
            modalContent: {
                title: "Return Reservation",
                content: "",
            },
        };
    },
    components: {
        Toast,
        Dialog,
        Modal,
        Button,
    },
    methods: {
        nextStep() {
            this.currentStep++;
        },
        skipToPart3() {
            this.currentStep = 3;
        },

        receiveReservation() {
            axios
                .post("/return-reservation", { ID: this.idReservation })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Equipment Returned Successfully!",
                        life: 3000,
                    });
                    this.$emit("returned");
                });
        },
    },
};
</script>
