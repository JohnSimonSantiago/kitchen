<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Equipment List</h1>

                    <div class="mb-4 flex gap-4">
                        <router-link to="/editstock">
                            <button
                                class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white p-button p-button-outlined p-button-info p-button-text"
                            >
                                <span class="pi pi-file-edit"></span>
                                Edit Stock
                            </button>
                        </router-link>
                        <CreateCategory
                            @success="getterCategory"
                        ></CreateCategory>
                        <CreateEquipment
                            @success="getterEquipment"
                        ></CreateEquipment>
                    </div>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5">
                    <div v-for="equipment in equipments" class="">
                        <EquipmentCard
                            :equipmentDetails="equipment"
                            @clicked="showDetails"
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
                        >Select Equipment to view Details</Message
                    >
                </div>
                <div v-else>
                    <h2 class="border-b border-gray-300 text-l font-semibold">
                        Item Details
                    </h2>

                    <!-- drawer component -->
                    <div class="my-2 grid grid-cols-1">
                        <div class="bg-gray-200 rounded-md px-4 py-2">
                            <h1>
                                <span class="font-bold">Name:</span>
                                {{ this.showCardDetails.equipmentName }}
                            </h1>

                            <h1>
                                <span class="font-bold">Location:</span>
                                {{ this.showCardDetails.location }}
                            </h1>
                            <h1>
                                <span class="font-bold">Price:</span>
                                {{ this.showCardDetails.price }}
                            </h1>
                            <h1>
                                <span class="font-bold">Barcode:</span>
                                {{ this.showCardDetails.barcode }}
                            </h1>
                            <h1>
                                <span class="font-bold">Category:</span>
                                {{ this.showCardDetails.cateegoryid }}
                            </h1>

                            <h1>
                                <span class="font-bold">Description:</span>
                                {{ this.showCardDetails.description }}
                            </h1>
                        </div>
                    </div>

                    <div
                        class="flex bottom-0 left-0 justify-center pb-4 space-x-4 w-full md:px-4"
                    >
                        <EditEquipment
                            :id="this.showCardDetails.equipment_id"
                            @success="getterEquipment"
                        ></EditEquipment>
                        <DeleteEquipment
                            :id="this.showCardDetails.equipment_id"
                            @deleted="DeletedEquipment"
                        ></DeleteEquipment>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import EquipmentCard from "../Cards/EquipmentCard.vue";
import CreateEquipment from "@/componentinventory/CreateEquipment.vue";
import EditEquipment from "@/componentinventory/EditEquipment.vue";
import DeleteEquipment from "@/componentinventory/DeleteEquipment.vue";
import CreateCategory from "@/componentinventory/CreateCategory.vue";
import Message from "primevue/message";

export default {
    components: {
        CreateEquipment,
        Message,
        EditEquipment,
        EquipmentCard,
        CreateCategory,
        DeleteEquipment,
    },
    mounted() {
        this.getterEquipment();
        this.getterCategory();
        this.getterCondition();
    },
    data() {
        return {
            equipments: [],
            categories: [],
            conditions: [],
            showCardDetails: null,
        };
    },
    methods: {
        onAdvancedUpload() {
            this.$toast.add({
                severity: "info",
                summary: "Success",
                detail: "File Uploaded",
                life: 3000,
            });
        },
        showDetails(data) {
            this.showCardDetails = data;
            console.log(this.showCardDetails);
        },
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipments = data;
            });
        },
        DeletedEquipment() {
            this.getterEquipment();
            this.showCardDetails = null;
        },

        getterCategory() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
        getterCondition() {
            axios.get("/get-conditions").then(({ data }) => {
                this.conditions = data;
            });
        },
    },
};
</script>
