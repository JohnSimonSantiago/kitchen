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
        buttonClass="yellow-button"
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
<style scoped>
.yellow-button button {
    background-color: yellow !important;
    /* Add any additional styling you need for the yellow button */
}
</style>
