<template>
    <Modal
        :modalContent="{
            title: 'Create Category',
            content: 'Please fill out the form below:',
        }"
        buttonLabel="Create New Category +"
        cancelLabel="Cancel"
        saveLabel="Create"
        :saveOption="true"
        @save="submitCategory"
    >
        <div v-if="Error">Error</div>
        <form>
            <div class="grid gap-6 mb-6">
                <div>
                    <div>
                        <label
                            for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Category</label
                        >
                        <input
                            v-model="category"
                            type="text"
                            id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Category"
                            required
                        />
                    </div>
                </div>
            </div>
        </form>
        <Button
            class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
            label="Return"
            @click="submitCategory()"
        />
        <Toast />
    </Modal>
</template>

<script>
import Modal from "../component/Modal.vue";
import Toast from "primevue/toast";
import Button from "primevue/button";
export default {
    components: {
        Modal,
        Button,
        Toast,
    },
    data() {
        return {
            category: "",
        };
    },
    methods: {
        submitCategory() {
            const { category } = this;
            axios
                .post("/submit-category", {
                    category,
                })
                .then(() => {
                    this.$toast.add({
                        severity: "info",
                        summary: "Info",
                        detail: "Category Created Successfully!",
                        life: 3000,
                    });
                    this.$emit("returned");
                });
        },
    },
};
</script>
