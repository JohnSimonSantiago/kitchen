<template>
    <UserLayout>
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
                    <div>
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-search"> </InputIcon>
                            <InputText
                                v-model="searchTerm"
                                placeholder="Search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full pl-8"
                            />
                        </IconField>
                    </div>

                    <div>
                        <select
                            v-model="selectedCategory"
                            @change="filterByCategory"
                            id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full"
                            required
                        >
                            <option value="">All Categories</option>
                            <option
                                v-for="category in categoryList"
                                :key="category.categoryID"
                                :value="category.categoryID"
                            >
                                {{ category.category }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="my-2 grid grid-cols-4 gap-5">
                    <div
                        v-for="equipment in filteredEquipments"
                        :key="equipment.id"
                    >
                        <AddItemToReservationCard
                            :equipmentDetails="equipment"
                            @clicked="submitEquipmentOrder"
                            @refreshOrders="getterReservationOrder"
                        />
                    </div>
                    <div
                        v-if="filteredEquipments.length === 0"
                        class="text-gray-500"
                    >
                        No matching equipment found.
                    </div>
                </div>
            </div>
            <!-- Right Section -->

            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div v-if="reservationOrder.length === 0">
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
                            <div
                                v-for="order in reservationOrder"
                                :key="order.id"
                            >
                                <EditQuantityOrderCard :orderDetails="order" />
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex bottom-0 left-0 justify-center pb-4 space-x-4 w-full md:px-4"
                    ></div>
                    <button
                        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white p-button"
                    >
                        <span class="pi pi-file-export"></span>
                        Back to Reservation
                    </button>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import AddItemToReservationCard from "../Cards/AddItemToReservationCard.vue";
import Message from "primevue/message";
import Button from "primevue/button";
import EditQuantityOrderCard from "../Card_small/EditQuantityOrderCard.vue";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";
import UserLayout from "../Layout/UserLayout.vue";

export default {
    components: {
        AddItemToReservationCard,
        UserLayout,
        InputText,
        EditQuantityOrderCard,
        Button,
        IconField,
        Message,
        InputIcon,
    },

    mounted() {
        this.reservationNumber = this.$route.params.reservationNumber;
        this.getterEquipment();
        this.getterReservationOrder();
        this.getterMaxPossibleOrder();
        this.getterCategoryList();
    },

    data() {
        return {
            equipments: [],
            showCardDetails: null,
            reservationOrder: [],
            maxPossibleOrder: [],
            searchTerm: "",
            categoryList: [],
            selectedCategory: "",
        };
    },
    computed: {
        filteredEquipments() {
            return this.equipments.filter((equipment) =>
                equipment.equipmentName
                    .toLowerCase()
                    .includes(this.searchTerm.toLowerCase())
            );
        },
    },
    methods: {
        getterCategoryList() {
            axios.get("/get-categories").then(({ data }) => {
                this.categoryList = data;
            });
        },
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
        getterMaxPossibleOrder() {
            axios.get("/get-max-possible-order").then(({ data }) => {
                this.maxPossibleOrder = data;
                console.log(this.maxPossibleOrder);
            });
        },
        getterReservationOrder() {
            axios
                .get("/get-reservation-orders", {
                    params: {
                        reservationNumber: this.reservationNumber,
                    },
                })
                .then(({ data }) => {
                    this.reservationOrder = data;
                });
        },
    },
};
</script>
