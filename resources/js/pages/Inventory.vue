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
                                class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white p-button"
                            >
                                <span class="pi pi-file-edit"></span>
                                View/Edit Stock
                            </button>
                        </router-link>
                        <CreateCategory
                            @refresh="getterCategoryList"
                        ></CreateCategory>
                        <CreateEquipment
                            @success="getterEquipment"
                        ></CreateEquipment>
                    </div>
                </div>

                <div class="my-2 grid grid-cols-4 gap-5">
                    <div>
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-search"> </InputIcon>
                            <InputText
                                v-model="searchTerm"
                                placeholder="Search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-50 pl-10"
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
                        <EquipmentCard
                            :equipmentDetails="equipment"
                            @clicked="showDetails"
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
            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div v-if="showCardDetails === null">
                    <Message :closable="false" severity="info"
                        >Select Equipment to view Details</Message
                    >
                </div>
                <div v-else>
                    <h2
                        class="my-5 border-b border-gray-300 text-l font-semibold"
                    >
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
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";

export default {
    components: {
        CreateEquipment,
        Message,
        IconField,
        InputIcon,
        InputText,
        EditEquipment,
        EquipmentCard,
        CreateCategory,
        DeleteEquipment,
    },
    mounted() {
        this.getterEquipment();
        this.getterCategory();
        this.getterCondition();
        this.getterCategoryList();
    },
    data() {
        return {
            equipments: [],
            categories: [],
            conditions: [],
            showCardDetails: null,
            searchTerm: "",
            categoryList: [],
            selectedCategory: "",
        };
    },
    computed: {
        filteredEquipments() {
            if (!this.selectedCategory) {
                return this.equipments.filter((equipment) =>
                    equipment.equipmentName
                        .toLowerCase()
                        .includes(this.searchTerm.toLowerCase())
                );
            } else {
                return this.equipments.filter(
                    (equipment) =>
                        equipment.categoryID === this.selectedCategory &&
                        equipment.equipmentName
                            .toLowerCase()
                            .includes(this.searchTerm.toLowerCase())
                );
            }
        },
    },
    methods: {
        getterCategoryList() {
            axios.get("/get-categories").then(({ data }) => {
                this.categoryList = data;
            });
        },
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
        getterCondition() {
            axios.get("/get-conditions").then(({ data }) => {
                this.conditions = data;
            });
        },
    },
};
</script>
