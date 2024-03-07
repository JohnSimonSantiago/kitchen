<template>
    <Button
        label="Delete"
        icon="pi pi-delete-left"
        @click="visible = true"
        class="border border-red-500 p-2 hover:bg-red-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Delete Equipment"
        :style="{ width: '25rem' }"
    >
        <Message :closable="false" severity="error"
            >Warning: You cannot undo this action</Message
        >
        <div class="flex justify-content-end gap-2">
            <Button
                type="button"
                label="Cancel"
                severity="secondary"
                @click="visible = false"
            ></Button>
            <Button
                type="button"
                label="Delete"
                @click="saveAndSubmit"
            ></Button>
        </div>
    </Dialog>
    <Toast />
</template>

<script>
import axios from "axios";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import Button from "primevue/button";
import Message from "primevue/message";
export default {
    props: ["id"],
    components: {
        Dialog,
        Toast,
        Button,
        Message,
    },
    data() {
        return {
            visible: false,
        };
    },
    methods: {
        saveAndSubmit() {
            (this.visible = false), this.deleteEquipment();
        },
        deleteEquipment() {
            axios
                .post("/delete-equipment", { ID: this.id })
                .then(({ data }) => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Equpment Deleted Successfully!",
                        life: 3000,
                    });
                    this.$emit("deleted");
                });
        },
    },
};
</script>
