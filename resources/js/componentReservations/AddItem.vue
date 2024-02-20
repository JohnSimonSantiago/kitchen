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
            quantity: "",
            selectedEquipment: null,
            reservations: [],
            equipmentList: [],
            maxStock: 0,
        };
    },
    mounted() {
        this.getterEquipment();
        this.getterReservation();
        this.getterMaxStock();
    },
    methods: {
        submitEquipmentOrder() {
            const { selectedEquipment, quantity } = this;
            axios
                .post("/submit-equipment-order", {
                    equipment_id: selectedEquipment,
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
                console.log(equipmentList);
            });
        },
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        getterMaxStock() {
            axios.get("/get-max-stock").then(({ data }) => {
                this.maxStock = data;
            });
        },
    },
};
</script>
