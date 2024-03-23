<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-5"
                >
                    <h1 class="text-l mb-3 mt-3 font-semibold">
                        Equipment List
                    </h1>
                    <AddNewStock @conditionSelected="addItem"></AddNewStock>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5">
                    <div v-for="equipment in equipmentsStatus" class="">
                        <EditStockCard
                            :equipmentDetails="equipment"
                            :selectedCondition="selectedCondition"
                            @clicked="submitEquipmentStatus"
                        />
                    </div>
                </div>
            </div>

            <!-- Right Section -->

            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div></div>
                <button
                    class="border border-green-500 p-2 hover:bg-green-600 hover:text-white p-button mt-6"
                >
                    <span class="pi pi-file-export"></span>
                    Update Stock
                </button>
            </div>
        </div>
    </Layout>
</template>

<script>
import EditStockCard from "../Cards/EditStockCard.vue";
import AddNewStock from "../componentInventory/AddNewStock.vue";

export default {
    components: {
        EditStockCard,
        AddNewStock,
    },
    mounted() {
        this.getterEquipment();
        this.getterAllEquipmentStatus();
    },
    data() {
        return {
            equipments: [],
            equipmentsStatus: [],
            selectedCondition: "",
        };
    },
    methods: {
        getterAllEquipmentStatus() {
            axios.get("/get-all-equipment-status").then(({ data }) => {
                this.equipmentsStatus = data;
            });
        },
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipments = data;
            });
        },
        submitEquipmentStatus(data) {
            const { equipmentDetails, quantity, selectedCondition } = data;
            axios
                .post("add-and-dispose-equipment-stock", {
                    equipment_id: equipmentDetails.equipment_id,
                    condition_id: selectedCondition,
                    quantity,
                })
                .then(({ data }) => {
                    this.id = "";
                    this.quantity = "";
                    this.$emit("success");
                });
        },
    },
};
</script>
