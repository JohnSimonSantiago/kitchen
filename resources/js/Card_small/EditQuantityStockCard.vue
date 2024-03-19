<template>
    <div
        class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-center"
    >
        <div class="p-2"></div>
        <div class="p-2 flex-1">
            <a href="#">
                <h5
                    class="font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ equipmentStatusDetails.equipment_id }}
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Current Stock: {{ equipmentStatusDetails.quantity }}
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Condition:
            </p>
        </div>
        <div></div>
        <div class="p-2 flex items-center">
            <input
                v-model="quantity"
                type="number"
                class="px-4 py-2 border border-gray-300 rounded-md w-16 text-center"
                required
                min="0"
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
    props: ["equipmentStatusDetails"],
    data() {
        return {
            quantity: 0,
            equipmentCondition: {},
        };
    },
    mounted() {
        this.getConditionNames();
    },
    methods: {
        getConditionNames() {
            axios
                .get("/get-equipment-condition")
                .then(({ data }) => {
                    data.forEach((condition) => {
                        this.equipmentCondition[condition.id] = {
                            condition: condition.condition,
                        };
                    });
                    console.log(this.equipmentCondition);
                })
                .catch((error) => {
                    console.error(
                        "Error fetching equipment data by condition:",
                        error
                    );
                });
        },
    },
};
</script>
