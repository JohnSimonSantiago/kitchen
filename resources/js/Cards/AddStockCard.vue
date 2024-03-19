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
            <ChooseEditStockCondition
                @conditionSelected="addItem"
            ></ChooseEditStockCondition>
        </div>
    </div>
</template>

<script>
import Toast from "primevue/toast";
import Button from "primevue/button";
import Dialog from "primevue/Dialog";
import ChooseEditStockCondition from "../componentInventory/ChooseEditStockCondition.vue";

export default {
    components: {
        Toast,
        Button,
        ChooseEditStockCondition,
        Dialog,
    },
    data() {
        return {
            selectedCondition: "",
        };
    },
    props: ["equipmentDetails"],

    methods: {
        addItem(condition) {
            this.$emit("clicked", {
                equipmentDetails: this.equipmentDetails,
                selectedCondition: condition,
                quantity: 1,
            });
            this.$emit("refreshOrders");
            this.$toast.add({
                severity: "success",
                summary: "Success!",
                detail: "Item added to Stock.",
                life: 1000,
            });
        },
    },
};
</script>
