<template>
    <div
        class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-center"
    >
        <img
            :src="`/uploads/${
                equipmentNameAndImage[orderDetails.equipment_id]?.imageSrc
            }`"
            alt="Equipment Image"
            class="rounded-t-lg w-10 h-10"
        />

        <div class="p-2 flex-1">
            <a href="#">
                <h5
                    class="font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ getName(orderDetails.equipment_id) }} ({{
                        initialQuantity
                    }})
                </h5>
            </a>
        </div>
        <div class="p-2 flex items-center">
            <div class="flex items-center">
                <button
                    @click="decrementQuantity"
                    class="px-3 py-1 border border-gray-300 rounded-l-md"
                >
                    <span>-</span>
                </button>
                <div class="px-3 py-1 border border-gray-300 w-16 text-center">
                    <span>{{ orderDetails.quantity }}</span>
                </div>
                <button
                    @click="incrementQuantity"
                    class="px-3 py-1 border border-gray-300 rounded-r-md"
                >
                    <span>+</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Button from "primevue/button";

export default {
    components: {
        Button,
    },
    mounted() {
        this.getEquipmentNameAndImage();
        this.getterEquipmentPrice();
    },
    props: ["orderDetails"],
    data() {
        return {
            equipmentNameAndImage: {},
            equipmentsPrice: [],
            maxQuantity: this.orderDetails.quantity, // Store the max quantity separately
            initialQuantity: this.orderDetails.quantity, // Store the initial quantity
        };
    },
    methods: {
        getterEquipmentPrice() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipmentsPrice = data.map((equipment) => equipment.price);
            });
        },
        getEquipmentPrice(equipment_id) {
            if (equipment_id && this.equipmentsPrice.length > 0) {
                const index = equipment_id - 1;
                if (index >= 0 && index < this.equipmentsPrice.length) {
                    return this.equipmentsPrice[index];
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        },
        getEquipmentNameAndImage() {
            axios
                .get("/get-equipment-name-and-image")
                .then(({ data }) => {
                    data.forEach((equipment) => {
                        this.equipmentNameAndImage[equipment.equipment_id] = {
                            name: equipment.equipmentName,
                            imageSrc: equipment.image,
                        };
                    });
                })
                .catch((error) => {
                    console.error("Error fetching equipment data:", error);
                });
        },
        getImageSrc(equipment_id) {
            const equipment = this.equipmentNameAndImage[equipment_id];
            if (equipment) {
                return equipment.imageSrc || "Unknown";
            } else {
                return "Unknown";
            }
        },
        getName(equipment_id) {
            const equipment = this.equipmentNameAndImage[equipment_id];
            if (equipment) {
                return equipment.name || "Unknown";
            } else {
                return "Unknown";
            }
        },
        incrementQuantity() {
            if (this.orderDetails.quantity < this.maxQuantity) {
                this.orderDetails.quantity += 1;
            } else {
                this.$toast.add({
                    severity: "warn",
                    summary: "Warning",
                    detail: "Maximum Quantity reached.",
                    life: 3000,
                });
            }
        },
        decrementQuantity() {
            if (this.orderDetails.quantity > 0) {
                this.orderDetails.quantity -= 1;
            } else {
                this.$toast.add({
                    severity: "warn",
                    summary: "Warning",
                    detail: "Minimum Quantity reached.",
                    life: 3000,
                });
            }
        },
    },
};
</script>
