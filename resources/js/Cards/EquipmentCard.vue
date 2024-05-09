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
                    class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ equipmentDetails.equipmentName }}
                </h5>
            </a>
            <p class="font-normal text-gray-700 dark:text-gray-400">
                Category:
                {{ getCategoryName(equipmentDetails.categoryID) }}
            </p>
            <p class="font-normal text-gray-700 dark:text-gray-400">
                <Badge
                    :value="getEquipmentQuantity(1)"
                    size="large"
                    severity="success"
                ></Badge>
                <Badge
                    :value="getEquipmentQuantity(2)"
                    size="large"
                    severity="warning"
                ></Badge>
                <Badge
                    :value="getEquipmentQuantity(3)"
                    size="large"
                    severity="danger"
                ></Badge>
            </p>

            <Button
                @click="readMore"
                label="View"
                icon="pi pi-arrow-right"
                class="border border-blue-500 p-2 hover:bg-blue-700 hover:text-white"
            >
            </Button>
        </div>
    </div>
</template>

<script>
import Button from "primevue/button";
import Badge from "primevue/badge";

export default {
    components: {
        Button,
        Badge,
    },
    data() {
        return {
            equipmentCategory: {},
        };
    },
    mounted() {
        this.getEquipmentCategory();
    },
    props: ["equipmentDetails"],
    methods: {
        getEquipmentQuantity(condition_id) {
            const params = {
                equipment_id: this.equipmentDetails.equipment_id,
                condition_id: condition_id,
            };

            return axios
                .get("/get-equipment-status-quantity", { params })
                .then((response) => {
                    const quantity = response.data.quantity;
                    console.log("Quantity:", quantity);
                    return quantity;
                })
                .catch((error) => {
                    console.error("Error fetching equipment quantity:", error);
                    return 0;
                });
        },

        readMore() {
            this.$emit("clicked", this.equipmentDetails);
        },
        getEquipmentCategory() {
            axios
                .get("/get-equipment-category")
                .then(({ data }) => {
                    data.forEach((category) => {
                        this.equipmentCategory[category.categoryID] = {
                            name: category.category,
                        };
                    });
                })
                .catch((error) => {
                    console.error("Error fetching equipment category:", error);
                });
        },
        getCategoryName(categoryID) {
            const category = this.equipmentCategory[categoryID];
            if (category) {
                return category.name || "Unknown";
            } else {
                return "Unknown";
            }
        },
    },
};
</script>
