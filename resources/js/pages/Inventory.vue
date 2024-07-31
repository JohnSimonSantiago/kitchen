<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div
                    class="flex space-x-5 border items-center rounded-md border-gray-400"
                >
                    <div class="p-2.5 flex gap-4">
                        <router-link to="/editstock">
                            <Button
                                class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
                            >
                                <span class="pi pi-file-edit"></span>
                                Edit Stock
                            </Button>
                        </router-link>
                        <CreateCategory
                            @success="getterCategoryList"
                        ></CreateCategory>
                        <CreateEquipment
                            @success="getterEquipment"
                        ></CreateEquipment>
                    </div>
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
                                :value="category.categoryID.toString()"
                            >
                                {{ category.category }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="my-2 grid grid-cols-6 gap-5">
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
            <Dialog
                v-model:visible="showCard"
                modal
                header="Item Details"
                class="h-fit"
                :style="{ width: '40rem' }"
            >
                <div class="flex flex-col p-4 bg-gray-50 rounded-md">
                    <div>
                        <h2
                            class="my-5 border-b border-gray-300 text-l font-semibold"
                        >
                            Item Details
                        </h2>

                        <!-- drawer component -->
                        <div class="my-2">
                            <div class="grid grid-cols-2 gap-2.5">
                                <h1 class="bg-gray-100 px-4 py-2 rounded-md">
                                    <span class="font-bold">Name:</span>
                                    {{ this.showCardDetails.equipmentName }}
                                </h1>

                                <h1 class="bg-gray-100 px-4 py-2 rounded-md">
                                    <span class="font-bold">Location:</span>
                                    {{ this.showCardDetails.location }}
                                </h1>
                                <h1 class="bg-gray-100 px-4 py-2 rounded-md">
                                    <span class="font-bold">Price:</span>
                                    {{ this.showCardDetails.price }}
                                </h1>
                                <h1 class="bg-gray-100 px-4 py-2 rounded-md">
                                    <span class="font-bold">Barcode:</span>
                                    {{ this.showCardDetails.barcode }}
                                </h1>

                                <h1 class="bg-gray-100 px-4 py-2 rounded-md">
                                    <span class="font-bold">Description:</span>
                                    {{ this.showCardDetails.description }}
                                </h1>
                            </div>
                        </div>

                        <div class="pt-10 space-x-4 w-full">
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
            </Dialog>
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
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import axios from "axios";

export default {
    components: {
        CreateEquipment,
        Message,
        Button,
        IconField,
        InputIcon,
        InputText,
        EditEquipment,
        EquipmentCard,
        CreateCategory,
        DeleteEquipment,
        Dialog,
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
            showCard: false,
        };
    },
    computed: {
        filteredEquipments() {
            console.log("Selected Category:", this.selectedCategory);
            console.log("Search Term:", this.searchTerm);

            let filteredList = this.equipments.filter((equipment) => {
                let matchesCategory =
                    !this.selectedCategory ||
                    equipment.categoryID == this.selectedCategory;
                let matchesSearchTerm = equipment.equipmentName
                    .toLowerCase()
                    .includes(this.searchTerm.toLowerCase());
                return matchesCategory && matchesSearchTerm;
            });

            console.log("Filtered List:", filteredList);
            return filteredList;
        },
    },
    methods: {
        getterCategoryList() {
            axios.get("/get-categories").then(({ data }) => {
                this.categoryList = data;
            });
        },
        showDetails(data) {
            this.showCard = true;
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
        filterByCategory() {
            this.selectedCategory = parseInt(this.selectedCategory);
        },
    },
};
</script>
