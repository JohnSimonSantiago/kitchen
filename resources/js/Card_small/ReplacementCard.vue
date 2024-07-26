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
                        @click="decrementLeft"
                        class="px-3 py-1 border border-gray-300 rounded-l-md"
                    >
                        <span>-</span>
                    </button>
                    <div
                        class="px-3 py-1 border border-gray-300 w-16 text-center"
                    >
                        <span>{{ leftQuantity }}</span>
                    </div>
                    <button
                        @click="incrementLeft"
                        class="px-3 py-1 border border-gray-300 rounded-r-md"
                    >
                        <span>+</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col items-center">
                <div class="flex items-center">
                    <button
                        @click="decrementRight"
                        class="px-3 py-1 border border-gray-300 rounded-l-md"
                    >
                        <span>-</span>
                    </button>
                    <div
                        class="px-3 py-1 border border-gray-300 w-16 text-center"
                    >
                        <span>{{ rightQuantity }}</span>
                    </div>
                    <button
                        @click="incrementRight"
                        class="px-3 py-1 border border-gray-300 rounded-r-md"
                    >
                        <span>+</span>
                    </button>
                </div>
            </div>
            <div class="ml-2 flex items-center">
                <p class="text-gray-900 dark:text-white">₱ {{ totalAmount }}</p>
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
            leftQuantity: this.orderDetails.quantity * 3,
            rightQuantity: 0,
            equipmentNameAndImage: {},
            equipmentPrices: {}, // Changed to object for mapping equipment_id to price
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
                    console.log("API response data:", data);

                    this.equipmentPrices = data.reduce((acc, equipment) => {
                        console.log("Processing equipment:", equipment);
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
        getEquipmentPrice(equipment_id) {
            return this.equipmentPrices[equipment_id] || 0;
        },
        incrementLeft() {
            if (this.leftQuantity < this.orderDetails.quantity * 3) {
                this.leftQuantity += 1;
                this.rightQuantity -= 1;
            }
        },
        decrementLeft() {
            if (this.leftQuantity > 0) {
                this.leftQuantity -= 1;
                this.rightQuantity += 1;
            }
        },
        incrementRight() {
            if (this.rightQuantity < this.orderDetails.quantity * 3) {
                this.rightQuantity += 1;
                this.leftQuantity -= 1;
            }
        },
        decrementRight() {
            if (this.rightQuantity > 0) {
                this.rightQuantity -= 1;
                this.leftQuantity += 1;
            }
        },
    },
    computed: {
        totalAmount() {
            const price = this.getEquipmentPrice(
                this.orderDetails.equipment_id
            );
            const amount = this.rightQuantity * price;

            return amount;
        },
    },
};
</script>
