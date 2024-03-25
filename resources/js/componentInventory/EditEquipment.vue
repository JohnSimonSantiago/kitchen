<template>
    <Button
        label="Edit Equipment"
        icon="pi pi-cog"
        @click="visible = true"
        class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Edit Equipment"
        :style="{ width: '75rem' }"
    >
        <form @submit.prevent="updateEquipment">
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div>
                    <label
                        for="equipment_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Equipment Name</label
                    >
                    <input
                        v-model="data.equipmentName"
                        type="text"
                        id="equipment_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Equipment"
                        required
                    />
                </div>
                <div>
                    <label
                        for="barcode"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Barcode</label
                    >
                    <input
                        v-model="data.barcode"
                        type="text"
                        id="barcode"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Barcode"
                        required
                    />
                </div>
                <div>
                    <label
                        for="location"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Location</label
                    >
                    <input
                        v-model="data.location"
                        type="text"
                        id="location"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Location"
                        required
                    />
                </div>
                <div>
                    <label
                        for="category"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Category</label
                    >
                    <select
                        v-model="selectedCategory"
                        id="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option
                            v-for="category in categoryList"
                            :key="category.categoryID"
                            :value="category.categoryID"
                        >
                            {{ category.category }}
                        </option>
                    </select>
                </div>
                <div>
                    <label
                        for="condition"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Condition</label
                    >
                    <select
                        v-model="condition"
                        id="condition"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option value="Good">Good</option>
                        <option value="Slightly Damaged">
                            Slightly Damaged
                        </option>
                        <option value="Damaged">Damaged</option>
                    </select>
                </div>
                <div>
                    <label
                        for="quantity"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Quantity</label
                    >
                    <input
                        v-model="data.quantity"
                        type="number"
                        id="quantity"
                        step="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Quantity"
                        required
                    />
                </div>
                <div>
                    <label
                        for="price"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Price</label
                    >
                    <input
                        v-model="data.price"
                        type="number"
                        id="price"
                        step="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Price"
                        required
                    />
                </div>
                <div>
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <textarea
                        v-model="data.description"
                        id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Equipment Description"
                        rows="3"
                        required
                    ></textarea>
                </div>
                <div class="mb-3">
                    <label for="">Upload Image</label>
                    <input
                        type="file"
                        name="image"
                        @change="handleImageUpload"
                        required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
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
                        label="Save"
                        @click="saveAndSubmit"
                    ></Button>
                </div>
            </div>
        </form>
    </Dialog>
    <Toast />
</template>

<script>
import axios from "axios";
import Button from "primevue/button";
import Toast from "primevue/toast";
import Dialog from "primevue/Dialog";

export default {
    props: ["equipment_id"],
    components: {
        Toast,
        Dialog,
        Button,
    },
    data() {
        return {
            visible: false,
            edit_id: 0,
            data: {
                Error: false,
                equipment_id: 0,
                equipmentName: "",
                quantity: 0,
                barcode: "",
                price: "",
                condition: "",
                location: "",
                image: "",
                categoryList: [],
                categoryID: null,
                description: "",
            },
        };
    },
    methods: {
        saveAndSubmit() {
            (this.visible = false), this.updateEquipment();
        },
        getEquipment() {
            const { edit_id } = this;
            axios.post("/get-equipment", { edit_id }).then(({ data }) => {
                this.data = data;
            });
        },
        updateEquipment() {
            const { data } = this;
            axios.post("/update-equipment", { data }).then(({ data }) => {
                this.data = {
                    equipment_id: 0,
                    equipmentName: "",
                    quantity: "",
                    barcode: "",
                    location: "",
                    price: "",
                    condition: "",
                    category: "",
                    description: "",
                };
                this.$emit("success");
            });
        },
    },
    mounted() {
        this.edit_id = this.id;
        this.getEquipment();
    },
    watch: {
        edit_id(New, Old) {
            this.data.equipment_id = New;
            this.getEquipment();
        },
    },
    handleImageUpload(event) {
        this.image = event.target.files[0];
    },
};
</script>
