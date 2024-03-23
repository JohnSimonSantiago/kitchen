<template>
    <div
        class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
    >
        <div class="flex items-center justify-center p-2">
            <img
                :src="`/uploads/${
                    equipmentNameAndImage[equipmentDetails.equipment_id]
                        ?.imageSrc
                }`"
                alt="Equipment Image"
                class="rounded-t-lg w-52 h-52"
            />
        </div>
        <div class="p-5">
            <a href="#">
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ getName(equipmentDetails.equipment_id) }}
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Current Stock:
                {{ equipmentDetails.quantity }}
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Condition:
                {{ getConditionName(equipmentDetails.condition_id) }}
            </p>
            <div class="flex items-center">
                <button
                    @click="decrementQuantity"
                    class="px-3 py-1 border border-gray-300 rounded-l-md"
                >
                    <span>-</span>
                </button>
                <div class="px-4 py-2 border border-gray-300 w-16 text-center">
                    <span>{{ equipmentDetails.quantity }}</span>
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
import Toast from "primevue/toast";
import Button from "primevue/button";
import Dialog from "primevue/Dialog";

export default {
    components: {
        Toast,
        Button,
        Dialog,
    },
    data() {
        return {
            selectedCondition: "",
            equipmentNameAndImage: {},
            equipmentCondition: {},
        };
    },
    mounted() {
        this.getEquipmentNameAndImage();
        this.getEquipmentCondition();
    },
    props: ["equipmentDetails"],

    methods: {
        getEquipmentCondition() {
            axios
                .get("/get-equipment-condition")
                .then(({ data }) => {
                    data.forEach((condition) => {
                        this.equipmentCondition[condition.id] = {
                            name: condition.condition,
                        };
                    });
                })
                .catch((error) => {
                    console.error("Error fetching equipment condition:", error);
                });
        },
        getConditionName(condition_id) {
            const condition = this.equipmentCondition[condition_id];
            if (condition) {
                return condition.name || "Unknown";
            } else {
                return "Unknown";
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
            this.equipmentDetails.quantity += 1;
        },
        decrementQuantity() {
            if (this.equipmentDetails.quantity > 1) {
                this.equipmentDetails.quantity -= 1;
            }
        },
    },
};
</script>
