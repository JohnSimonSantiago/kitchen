<template>
    <div class="">
        <form @submit.prevent="submitEquipment">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
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
                        for="quantity"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Quantity</label
                    >
                    <input
                        v-model="quantity"
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
                        step="1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Barcode"
                        required
                    />
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
export default {
    data() {
        return {
            equipmentName: "",
            quantity: "",
            description: "",
            barcode: "",
        };
    },
    methods: {
        submitEquipment() {
            const { equipmentName, quantity, description, barcode } = this;
            axios
                .post("/submit-equipment", {
                    equipmentName,
                    quantity,
                    description,
                    barcode,
                })
                .then(({ data }) => {
                    this.equipmentName = "";
                    this.quantity = "";
                    this.description = "";

                    this.$emit("success");
                });
        },
    },
};
</script>
