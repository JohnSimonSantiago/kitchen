<template>
    <div class="card flex justify-content-center">
        <Button
            label="Add/Dispose Stock"
            icon="pi pi-file-edit"
            @click="visible = true"
            class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
        />
        <Dialog
            v-model:visible="visible"
            modal
            header="Edit Profile"
            :style="{ width: '25rem' }"
        >
            <span class="p-text-secondary block mb-2"
                >Update your information.</span
            >
            <div class="flex align-items-center gap-3 mb-3">
                <label for="username" class="font-semibold w-6rem"
                    >Username</label
                >
                <InputText id="username" class="flex-auto" autocomplete="off" />
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
                    @click="visible = false"
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
        InputText,
        Button,
    },
    mounted() {
        this.getEquipments();
    },
    methods: {
        getEquipments() {
            const { edit_id } = this;
            axios.post("/get-equipments", { edit_id }).then(({ data }) => {
                this.equipmentList = data;
            });
        },
        DisposeOrAddStock() {
            axios
                .post("/add-dispose-equipment", { ID: this.id })
                .then(({ data }) => {
                    this.$emit("updated");
                });
        },
    },
};
</script>
<style></style>
