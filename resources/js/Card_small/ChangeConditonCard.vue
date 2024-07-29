<template>
    <div
        class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-center mb-4"
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
                        orderDetails.quantity
                    }})
                </h5>
            </a>
        </div>
        <div class="p-2 flex items-center">
            <div class="flex flex-col items-center mr-4">
                <div class="flex items-center">
                    <button
                        @click="decrementFirst"
                        class="px-3 py-1 border border-gray-300 rounded-l-md"
                    >
                        <span>-</span>
                    </button>
                    <div
                        class="px-3 py-1 border border-gray-300 w-16 text-center"
                    >
                        <span>{{ firstQuantity }}</span>
                    </div>
                    <button
                        @click="incrementFirst"
                        class="px-3 py-1 border border-gray-300 rounded-r-md"
                    >
                        <span>+</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col items-center mr-4">
                <div class="flex items-center">
                    <button
                        @click="decrementSecond"
                        class="px-3 py-1 border border-gray-300 rounded-l-md"
                    >
                        <span>-</span>
                    </button>
                    <div
                        class="px-3 py-1 border border-gray-300 w-16 text-center"
                    >
                        <span>{{ secondQuantity }}</span>
                    </div>
                    <button
                        @click="incrementSecond"
                        class="px-3 py-1 border border-gray-300 rounded-r-md"
                    >
                        <span>+</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col items-center">
                <div class="flex items-center">
                    <button
                        @click="decrementThird"
                        class="px-3 py-1 border border-gray-300 rounded-l-md"
                    >
                        <span>-</span>
                    </button>
                    <div
                        class="px-3 py-1 border border-gray-300 w-16 text-center"
                    >
                        <span>{{ thirdQuantity }}</span>
                    </div>
                    <button
                        @click="incrementThird"
                        class="px-3 py-1 border border-gray-300 rounded-r-md"
                    >
                        <span>+</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["orderDetails"],
    data() {
        return {
            firstQuantity: this.orderDetails.quantity * 3,
            secondQuantity: 0,
            thirdQuantity: 0,
            equipmentNameAndImage: {},
            equipmentPrices: {},
        };
    },
    mounted() {
        this.getEquipmentNameAndImage();
        this.getterEquipmentPrice();
    },
    methods: {
        getterEquipmentPrice() {
            axios
                .get("/get-equipments")
                .then(({ data }) => {
                    this.equipmentPrices = data.reduce((acc, equipment) => {
                        acc[equipment.equipment_id] = equipment.price;
                        return acc;
                    }, {});
                })
                .catch((error) => {
                    console.error("Error fetching equipment prices:", error);
                });
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
            return equipment ? equipment.imageSrc || "Unknown" : "Unknown";
        },
        getName(equipment_id) {
            const equipment = this.equipmentNameAndImage[equipment_id];
            return equipment ? equipment.name || "Unknown" : "Unknown";
        },
        getEquipmentPrice(equipment_id) {
            return this.equipmentPrices[equipment_id] || 0;
        },
        incrementFirst() {
            if (this.firstQuantity < this.orderDetails.quantity) {
                this.firstQuantity += 1;
                this.secondQuantity -= 1;
            }
        },
        decrementFirst() {
            if (this.firstQuantity > 0) {
                this.firstQuantity -= 1;
                this.secondQuantity += 1;
            }
        },
        incrementSecond() {
            if (this.secondQuantity < this.orderDetails.quantity) {
                this.secondQuantity += 1;
                this.thirdQuantity -= 1;
            }
        },
        decrementSecond() {
            if (this.secondQuantity > 0) {
                this.secondQuantity -= 1;
                this.thirdQuantity += 1;
            }
        },
        incrementThird() {
            if (this.thirdQuantity < this.orderDetails.quantity) {
                this.thirdQuantity += 1;
            }
        },
        decrementThird() {
            if (this.thirdQuantity > 0) {
                this.thirdQuantity -= 1;
            }
        },
    },
};
</script>
