<template>
    <Modal
        :modalContent="{
            title: 'Add Item',
            content: 'Please fill out the form below:',
        }"
        buttonLabel="Add Item"
        cancelLabel="Cancel"
        saveLabel="Add Item"
        :saveOption="true"
        @save="submitEquipmentOrder"
    >
        <div v-if="Error">Error</div>
        <form>
            <div class="grid gap-6 mb-6 md:grid-cols-3">
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
                        for="condition"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Condition</label
                    >
                    <select
                        v-model="selectedCondition"
                        id="condition"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required
                    >
                        <option
                            v-for="condition in conditionList"
                            :key="condition.id"
                            :value="condition.id"
                        >
                            {{ condition.condition }}
                        </option>
                    </select>
                </div>
                <div>
                    <label
                        for="quantity"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Quantity</label
                    >
                    <input
                        v-model="quantity"
                        type="number"
                        id="quantity"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Quantity"
                        required
                        min="0"
                        max="maxStock"
                    />
                </div>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "../component/Modal.vue";
export default {
    components: {
        Modal,
    },
    props: ["idReservation"],
    data() {
        return {
            Error: false,
            quantity: 0,
            selectedEquipment: null,
            reservations: [],
            equipmentList: [],
            conditionList: [],
            selectedCondition: null,
            maxStock: 0,
        };
    },
    mounted() {
        this.getterEquipment();
        this.getterCondition();
        this.getterReservation();
    },
    methods: {
        submitEquipmentOrder() {
            const { selectedEquipment, quantity, selectedCondition } = this;
            axios
                .post("/submit-equipment-order", {
                    equipment_id: selectedEquipment,
                    condition_id: selectedCondition,
                    reservationNumber: this.idReservation,
                    quantity,
                })
                .then(({ data }) => {
                    this.id = "";
                    this.quantity = "";
                    this.$emit("success");
                });
        },
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipmentList = data;
            });
        },
        getterCondition() {
            axios.get("/get-conditions").then(({ data }) => {
                this.conditionList = data;
            });
        },
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
    },
};
</script>
