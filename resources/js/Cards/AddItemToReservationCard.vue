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
            <div class="gap-2 flex justify-start">
                <Button
                    @click="addItem"
                    label="Add"
                    icon="pi pi-plus"
                    class="border border-green-500 p-2 hover:bg-green-700 hover:text-white"
                >
                </Button>
                <Button
                    @click="removeItem"
                    label="Remove"
                    icon="pi pi-minus"
                    class="border border-red-500 p-2 hover:bg-red-700 hover:text-white"
                >
                </Button>
            </div>
            <Toast />
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

    props: ["equipmentDetails", "quantity"],

    methods: {
        addItem() {
            this.$emit("clicked", {
                equipmentDetails: this.equipmentDetails,
                quantity: 1,
            });
            this.$emit("refreshOrders");
            this.$toast.add({
                severity: "success",
                summary: "Success!",
                detail: "Item added to reservation.",
                life: 1000,
            });
        },

        removeItem() {
            if (this.quantity > 0) {
                this.$emit("remove", {
                    equipmentDetails: this.equipmentDetails,
                    quantity: 1,
                });
                this.$emit("refreshOrders");
                this.$toast.add({
                    severity: "success",
                    summary: "Success!",
                    detail: "Item removed from reservation.",
                    life: 1000,
                });
            } else {
                this.$toast.add({
                    severity: "warn",
                    summary: "Warning!",
                    detail: "Cannot remove item. Quantity is already 0.",
                    life: 1000,
                });
            }
        },
    },
};
</script>
