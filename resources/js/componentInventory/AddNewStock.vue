<template>
    <Button
        label="Add New Stock"
        icon="pi pi-database"
        @click="visible = true"
        class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Choose Category"
        :style="{ width: '25rem' }"
    >
        <div v-if="Error">Error</div>

        <form>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label
                        for="equipment_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Equipment Name</label
                    >

                    <select
                        v-model="selectedEquipment"
                        id="equipment_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option
                            v-for="equipment in equipmentList"
                            :key="equipment.equipment_id"
                            :value="equipment.equipment_id"
                        >
                            {{ equipment.equipmentName }}
                        </option>
                    </select>
                </div>
                <div>
                    <label
                        for="equipment_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Equipment Condition</label
                    >

                    <select
                        v-model="selectedCondition"
                        id="category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option value="good">Good</option>
                        <option value="slightly-damaged">
                            Slightly Damaged
                        </option>
                        <option value="bad">Bad</option>
                    </select>
                </div>
                <div class="">
                    <p>Quantity</p>
                    <input
                        type="number"
                        v-model="quantity"
                        class="rounded-md border-gray-200"
                    />
                </div>
                <div class=""></div>
                <div class="grid gap-6 mb-6">
                    <div class="flex justify-content-end gap-2">
                        <Button
                            type="button"
                            label="Cancel"
                            severity="secondary"
                            @click="visible = false"
                        ></Button>
                        <Button
                            type="button"
                            label="Add/Dispose"
                            @click="saveAndSubmit"
                        ></Button>
                    </div>
                </div>
            </div>
        </form>
    </Dialog>
    <Toast />
</template>

<script>
import Dialog from 'primevue/dialog';
import Toast from "primevue/toast";
import Button from "primevue/button";

export default {
    components: {
        Button,
        Toast,
        Dialog,
    },
    mounted() {
        this.getterEquipmentList();
    },
    data() {
        return {
            selectedCondition: "",
            selectedEquipment: null,
            equipmentList: [],
            visible: false,
            quantity: 1,
        };
    },
    methods: {
        getterEquipmentList() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipmentList = data;
            });
        },
        saveAndSubmit() {
            if (!this.selectedEquipment || !this.selectedCondition) {
                this.$toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Please select equipment and condition.",
                    life: 3000,
                });

                return;
            }

            let conditionId = 0;
            switch (this.selectedCondition) {
                case "good":
                    conditionId = 1;
                    break;
                case "slightly-damaged":
                    conditionId = 2;
                    break;
                case "bad":
                    conditionId = 3;
                    break;
            }

            axios
                .post("/add-dispose-equipment-stock", {
                    equipment_id: this.selectedEquipment,
                    condition_id: conditionId,
                    quantity: this.quantity,
                })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Equipment stock updated successfully.",
                        life: 3000,
                    });
                    this.quantity = 1;
                    this.getterEquipmentList();
                })
                .catch((error) => {
                    console.error(
                        "Error adding/disposing equipment stock:",
                        error
                    );

                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to update equipment stock.",
                        life: 3000,
                    });
                })
                .finally(() => {
                    this.visible = false;
                    this.$emit("refresh");
                });
        },
    },
};
</script>
