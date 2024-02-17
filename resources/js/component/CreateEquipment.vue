<template>
    <Modal
        :modalContent="{
            title: 'Create Equipment',
            content: 'Please fill out the form below:',
        }"
        buttonLabel="Create New Equipment +"
        cancelLabel="Cancel"
        saveLabel="Create"
        :saveOption="true"
        @save="submitEquipment"
    >
        <div v-if="Error">Error</div>
        <form>
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
                    <input
                        v-model="category"
                        type="text"
                        id="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Category"
                        required
                    />
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
                        v-model="quantity"
                        type="number"
                        id="quantity"
                        step="1"
                        min="0"
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
        </form>
    </Modal>
</template>

<script>
import Modal from "./Modal.vue";
export default {
    components: {
        Modal,
    },
    data() {
        return {
            Error: false,
            equipmentName: "",
            quantity: "",
            description: "",
            location: "",
            price: "",
            barcode: "",
            category: "",
            condition: "",
        };
    },
    methods: {
        submitEquipment() {
            const {
                equipmentName,
                quantity,
                description,
                price,
                location,
                barcode,
                category,
                condition,
            } = this;
            axios
                .post("/submit-equipment", {
                    equipmentName,
                    quantity,
                    description,
                    price,
                    location,
                    barcode,
                    category,
                    condition,
                })
                .then(({ data }) => {
                    this.equipmentName = "";
                    this.quantity = "";
                    this.description = "";
                    this.price = "";
                    this.location = "";
                    this.barcode = "";
                    this.category = "";
                    this.condition = "";
                    this.$emit("success");
                    this.$router.push("/inventory");
                });
        },
    },
};
</script>
