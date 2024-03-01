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
        <Message :closable="false" severity="error"
            >Warning: You cannot undo this action</Message
        >
    </Modal>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import Message from "primevue/message";
export default {
    props: ["id"],
    components: {
        Modal,
        Message,
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
