<template>
    <div class="card flex justify-content-center">
        <Button
            label="Add Stock"
            icon="pi pi-file-edit"
            @click="visible = true"
            class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
        />
        <Dialog
            v-model:visible="visible"
            modal
            header="Add/Dispose Stock"
            :style="{ width: '30rem' }"
        >
            <div v-for="equipment in equipments" class="mx-5">
                <EditQuantityStockCard
                    :equipmentDetails="equipment"
                ></EditQuantityStockCard>
            </div>
            <div class="flex justify-content-end gap-2">
                <Button
                    type="button"
                    label="Cancel"
                    severity="secondary"
                    @click="visible = false"
                ></Button>
                <Button
                    type="button"
                    label="Save"
                    @click="saveAndSubmit"
                ></Button>
            </div>
        </Dialog>
        <Toast />
    </div>
</template>

<script>
import axios from "axios";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import EditQuantityStockCard from "../Card_small/EditQuantityStockCard.vue";
import Toast from "primevue/toast";

export default {
    data() {
        return {
            visible: false,
            equipmentList: [],
            edit_id: 0,
        };
    },
    props: ["id"],
    components: {
        Toast,
        Dialog,
        EditQuantityStockCard,
        InputText,
        Button,
    },
    mounted() {
        this.getterEquipment();
        this.addEquipmenStock();
    },
    methods: {
        saveAndSubmit() {
            this.visible = false;
            this.DisposeOrAddStock();
        },
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                this.equipments = data;
            });
        },
        addEquipmenStock() {
            axios
                .post("/add-equipment-stock", { ID: this.id })
                .then(({ data }) => {
                    this.$emit("updated");
                });
        },
    },
};
</script>
<style></style>
