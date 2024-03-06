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
                Category:
                {{ equipmentDetails.categoryID }}
            </p>
            <Button
                @click="readMore"
                label="Read More"
                icon="pi pi-arrow-right"
                class="border border-blue-500 p-2 hover:bg-blue-700 hover:text-white"
            >
            </Button>
        </div>
    </div>
</template>

<script>
import Card from "primevue/card";
import Button from "primevue/button";
export default {
    components: {
        Card,
        Button,
    },
    props: ["equipmentDetails"],
    methods: {
        readMore() {
            this.$emit("clicked", this.equipmentDetails);
        },
    },
};
</script>
