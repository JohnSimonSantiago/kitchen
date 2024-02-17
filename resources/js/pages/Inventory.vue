<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-300">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Equipment List</h1>
                    <div class="mb-4">
                        <CreateEquipment
                            @success="getterEquipment"
                        ></CreateEquipment>
                        <CreateCategory
                            @success="getterCategory"
                        ></CreateCategory>
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
            <div class="flex min-h-screen flex-col w-1/4 p-4 bg-gray-200">
                <div v-if="showCardDetails === null">
                    (Select Equipment to View Info)
                </div>
                <div v-else>
                    <h2 class="border-b border-gray-300 text-l font-semibold">
                        Item Details
                    </h2>

                    <!-- drawer component -->
                    <div class="my-2 grid grid-cols-1">
                        <div class="bg-gray-300 rounded-md px-4 py-2">
                            <h1 class="font-bold">Name:</h1>
                            <p>{{ this.showCardDetails.equipmentName }}</p>
                            <h1 class="font-bold">Quantity:</h1>
                            <p>{{ this.showCardDetails.quantity }}</p>
                            <h1 class="font-bold">Location:</h1>
                            <p>{{ this.showCardDetails.location }}</p>
                            <h1 class="font-bold">Price:</h1>
                            <p>{{ this.showCardDetails.price }}</p>
                            <h1 class="font-bold">Barcode:</h1>
                            <p>{{ this.showCardDetails.barcode }}</p>
                            <h1 class="font-bold">Category:</h1>
                            <p>{{ this.showCardDetails.category }}</p>
                            <h1 class="font-bold">Condition:</h1>
                            <p>{{ this.showCardDetails.condition }}</p>
                            <h1 class="font-bold">Description:</h1>
                            <p>{{ this.showCardDetails.description }}</p>
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
import CreateEquipment from "@/component/CreateEquipment.vue";
import EditEquipment from "@/component/EditEquipment.vue";
import DeleteEquipment from "@/component/DeleteEquipment.vue";
import CreateCategory from "../component/CreateCategory.vue";

export default {
    components: {
        CreateEquipment,
        EditEquipment,
        EquipmentCard,
        CreateCategory,
        DeleteEquipment,
    },
    mounted() {
        this.getterEquipment();
        this.getterCategory();
    },
    data() {
        return {
            equipments: [],
            categories: [],
            showCardDetails: null,
        };
    },
    methods: {
        showDetails(data) {
            this.showCardDetails = data;
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
    },
};
</script>
