<template>
    <div
        class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-center"
    >
        <div class="p-2">
            <img
                class="rounded-t-lg w-10 h-10"
                :src="`/uploads/${equipmentDetails.image}`"
                alt=""
            />
        </div>
        <div class="p-2 flex-1">
            <a href="#">
                <h5
                    class="font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ equipmentDetails.equipmentName }}
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Current Stock: {{ equipmentDetails.quantity }}
            </p>
        </div>
        <div class="p-2 flex items-center">
            <input
                v-model="quantity"
                type="number"
                class="px-4 py-2 border border-gray-300 rounded-md w-16 text-center"
                required
                min="0"
                max="maxStock"
            />
        </div>
    </div>
</template>

<script>
import Button from "primevue/button";
export default {
    components: {
        Button,
    },
    props: ["equipmentDetails"],
    data() {
        return {
            quantity: 0,
            maxStock: 0,
        };
    },
    mounted() {
        this.getterMaxStock();
    },
    methods: {
        incrementQuantity() {
            this.quantity += 1;
        },
        decrementQuantity() {
            this.quantity = Math.max(1, this.quantity - 1);
        },
        getterMaxStock() {
            axios.get("/get-max-stock").then(({ data }) => {
                this.maxStock = data;
                console.log(this.maxStock);
            });
        },
    },
};
</script>
