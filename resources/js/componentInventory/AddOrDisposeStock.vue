<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Dispose/Add Equipment',
            content: 'Are you sure you want to Add/Dispose these items?',
        }"
        buttonLabel="Dispose/Add Stock"
        cancelLabel="Cancel"
        saveLabel="Confirm"
        :saveOption="true"
        @save="deleteEquipment"
    >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
export default {
    props: ["id"],
    components: {
        Modal,
    },
    methods: {
        DisposeOrAddStock() {
            axios
                .post("/delete-equipment", { ID: this.id })
                .then(({ data }) => {
                    this.$emit("deleted");
                });
        },
    },
};
</script>
