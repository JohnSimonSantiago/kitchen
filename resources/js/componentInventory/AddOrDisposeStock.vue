<template>
    <Button label="Edit" @click="visible = true" />
    <Dialog
        v-model:visible="visible"
        modal
        header="Edit Profile"
        :style="{ width: '25rem' }"
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
                label="Save"
                @click="DisposeOrAddStock = false"
            ></Button>
        </div>
    </Dialog>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Button from "primevue/button";
import Dialog from "primevue/dialog";

export default {
    data() {
        return {
            visible: false,
        };
    },
    props: ["id"],
    components: {
        Modal,
        Dialog,
        Button,
    },
    methods: {
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
