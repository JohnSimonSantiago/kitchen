<template>
    <Modal
        class=""
        :modalContent="{
            title: 'Delete Equipment',
            content: 'Are you sure you want to delete?',
        }"
        buttonLabel="Delete"
        cancelLabel="Cancel"
        saveLabel="Delete"
        :saveOption="true"
        @save="deleteEquipment"
    >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "./Modal.vue";

export default {
    props: ["id"],
    components: {
        Modal,
    },
    methods: {
        deleteEquipment() {
            axios
                .post("/delete-equipment", { ID: this.id })
                .then(({ data }) => {
                    this.$emit("deleted");
                });
        },
    },
};
</script>
