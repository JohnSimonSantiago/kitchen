<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-5"
                >
                    <h1 class="text-l mb-3 mt-3 font-semibold">
                        Equipment List
                    </h1>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5">
                    <div v-for="equipment in equipments" class="">
                        <AddItemToReservationCard
                            :equipmentDetails="equipment"
                            @clicked="submitEquipmentOrder"
                        />
                    </div>
                </div>
            </div>

            <!-- Right Section -->

            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div v-if="showCardDetails === null">
                    <Message :closable="false" severity="info"
                        >Cart is Empty</Message
                    >
                </div>
                <div v-else>
                    <h2
                        class="border-b my-5 border-gray-300 text-l font-semibold"
                    >
                        Item Details
                    </h2>

                    <!-- drawer component -->
                    <div class="my-5">
                        <div class="bg-gray-200 rounded-md px-4 py-2">
                            <div v-for="order in reservationOrder" class="">
                                <EditQuantityOrderCard :orderDetails="order" />
                            </div>
                            <h1>
                                <span class="font-bold">Name:</span>
                                {{ this.showCardDetails.equipmentName }}
                            </h1>
                        </div>
                        <Button
                            label="Make Order"
                            icon="pi pi-file-edit"
                            @click="visible = true"
                            class="my-5 border border-green-500 p-2 hover:bg-green-600 hover:text-white"
                        />
                    </div>

                    <div
                        class="flex bottom-0 left-0 justify-center pb-4 space-x-4 w-full md:px-4"
                    ></div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import AddItemToReservationCard from "../Cards/AddItemToReservationCard.vue";
import Message from "primevue/message";
import Button from "primevue/button";
import EditQuantityOrderCard from "../Card_small/EditQuantityOrderCard.vue";

export default {
    components: {
        AddItemToReservationCard,
        EditQuantityOrderCard,
        Button,
        Message,
    },
    mounted() {
        this.reservationNumber = this.$route.params.reservationNumber;
        this.getterEquipment();
        this.getterReservationOrder();
    },
    data() {
        return {
            equipments: [],
            showCardDetails: null,
            reservationOrder: [],
        };
    },
    methods: {
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipments = data;
            });
        },
        submitEquipmentOrder(data) {
            const { equipmentDetails, quantity } = data;
            axios
                .post("/submit-equipment-order", {
                    equipment_id: equipmentDetails.equipment_id,
                    reservationNumber: this.reservationNumber,
                    quantity,
                })
                .then(({ data }) => {
                    this.id = "";
                    this.quantity = "";
                    this.$emit("success");
                });
        },
        getterReservationOrder() {
            axios.get("/get-reservation-orders").then(({ data }) => {
                this.reservationOrder = data;
            });
        },
    },
};
</script>
