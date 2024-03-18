<template>
    <div
        class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
    >
        <div class="flex items-center justify-center p-2">
            <img
                class="rounded-t-lg w-52 h-52"
                :src="`/uploads/${equipmentDetails.image}`"
                alt=""
            />
        </div>
        <div class="p-5">
            <a href="#">
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ equipmentDetails.equipmentName }}
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Price:
                {{ equipmentDetails.price }}
            </p>
            <Button
                @click="addStock"
                label="Add Stock"
                icon="pi pi-database"
                class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
            >
            </Button>
        </div>
    </div>
</template>

<script>
import Toast from "primevue/toast";
import Button from "primevue/button";

export default {
    components: {
        Toast,
        Button,
    },
    data() {
        return {
            equipments: [],
            order: [],
            amountGiven: 0,
        };
    },
    props: ["equipmentDetails"],

    methods: {
        addStock() {},
    },
};
</script>
