<template>
    <div class="">
        <h1>Edit Equipment</h1>
        <form @submit.prevent="editEquipment">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label
                        for="equipment_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Equipment Name</label>
                    <input
                        v-model="data.equipmentName"
                        type="text"
                        id="equipment_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Equipment Name"
                        required
                    />
                </div>
                <div>
                    <label
                        for="quantity"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Quantity</label>
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
                        for="barcode"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Barcode</label>
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
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Description</label>
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
            <button
                type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                Submit
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["id"],
    data() {
        return {
            edit_id: 0,
            data: {
                id: 0,
                equipmentName: "",
                quantity: 0,
                barcode: "",
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
        editEquipment() {
            const { data } = this;
            axios.post("/update-equipment", { data }).then(({ data }) => {
                this.data = {
                    id: 0,
                    equipmentName: "",
                    quantity: 0,
                    barcode: "",
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
            this.data.id = New;
            this.getEquipment();
        },
    },
};
</script>
