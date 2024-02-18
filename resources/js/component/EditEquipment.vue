<template>
    <Modal
        :modalContent="{
            title: 'Edit Equipment',
            content: 'Please fill out the form below:',
        }"
        buttonLabel="Edit"
        cancelLabel="Cancel"
        saveLabel="Update"
        :saveOption="true"
        @save="updateEquipment"
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
                    <input
                        v-model="data.category"
                        type="text"
                        id="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Category"
                        required
                    />
                </div>
                <div>
                    <label
                        for="conditon"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Conditon</label
                    >
                    <input
                        v-model="data.condition"
                        type="text"
                        id="condition"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Condition"
                        required
                    />
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
            </div>
        </form>
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "./Modal.vue";

export default {
    props: ["equipment_id"],
    components: {
        Modal,
    },
    data() {
        return {
            edit_id: 0,
            data: {
                equipment_id: 0,
                equipmentName: "",
                quantity: 0,
                barcode: "",
                price: "",
                condition: "",
                location: "",
                category: "",
                description: "",
            },
        };
    },
    methods: {
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
};
</script>
