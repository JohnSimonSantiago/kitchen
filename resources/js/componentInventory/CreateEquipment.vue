<template>
    <Button
        label="Create Equipment"
        icon="pi pi-plus"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Create Equipment"
        :style="{ width: '75rem' }"
    >
        <div v-if="Error">Error: Please fill out all required fields</div>
        <form @submit.prevent="submitEquipment">
            <label
                for="category"
                class="block mb-5 text-sm font-medium text-gray-900 dark:text-white"
                >Please Fill up the form:
            </label>
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div>
                    <label
                        for="equipment_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Equipment Name</label
                    >

                    <input
                        v-model="equipmentName"
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
                        v-model="barcode"
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
                        v-model="location"
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
                        for="price"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Price</label
                    >
                    <input
                        v-model="price"
                        type="number"
                        id="price"
                        step="1"
                        min="0"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Price"
                        required
                    />
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
                <div>
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <textarea
                        v-model="description"
                        id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Equipment Description"
                        rows="3"
                        required
                    ></textarea>
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
                    label="Save"
                    @click="saveAndSubmit"
                ></Button>
            </div>
        </form>
    </Dialog>
</template>

<script>
import Modal from "../component/Modal.vue";
import Button from "primevue/button";
import Dialog from "primevue/Dialog";
import Toast from "primevue/toast";

export default {
    components: {
        Modal,
        Button,
        Toast,
        Dialog,
    },
    data() {
        return {
            Error: false,
            visible: false,
            equipmentName: "",
            description: "",
            location: "",
            price: "",
            barcode: "",
            image: "",
            categoryList: [],
            categoryID: null,
            selectedCategory: null,
        };
    },
    mounted() {
        this.getterCategoryList();
    },

    methods: {
        saveAndSubmit() {
            this.submitEquipment();
            this.visible = false;
        },
        submitEquipment() {
            const {
                selectedCategory,
                equipmentName,
                description,
                price,
                location,
                barcode,
                image,
            } = this;

            let formData = new FormData();
            formData.append("equipmentName", equipmentName);
            formData.append("description", description);
            formData.append("price", price);
            formData.append("location", location);
            formData.append("barcode", barcode);
            formData.append("categoryID", selectedCategory);
            formData.append("image", this.image);

            axios.post("/submit-equipment", formData).then(({ data }) => {
                this.$toast.add({
                    severity: "success",
                    summary: "Success!",
                    detail: "Equipment Created Successfully!",
                    life: 3000,
                });
                this.resetForm();
                this.$emit("success");
            });
        },
        resetForm() {
            // Reset form values, including the image
            this.equipmentName = "";
            this.description = "";
            this.price = "";
            this.location = "";
            this.barcode = "";
            this.image = "";
        },
        getterCategoryList() {
            axios.get("/get-categories").then(({ data }) => {
                this.categoryList = data;
            });
        },
        handleImageUpload(event) {
            this.image = event.target.files[0];
        },
    },
};
</script>
