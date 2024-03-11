<template>
    <Button
        label="Create Condition"
        icon="pi pi-plus"
        @click="visible = true"
        class="border border-green-500 p-2 hover:bg-green-600 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Create Condition"
        :style="{ width: '25rem' }"
    >
        <div v-if="Error">Error</div>
        <form>
            <div class="grid gap-6 mb-6">
                <div>
                    <div>
                        <label
                            for="condition"
                            class="block mb-5 text-sm font-medium text-gray-900 dark:text-white"
                            >Please Fill up the form:
                        </label>
                        <input
                            v-model="condition"
                            type="text"
                            id="condition"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Condition Name"
                            required
                        />
                    </div>
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
            </div>
        </form>
    </Dialog>
    <Toast />
</template>

<script>
import Modal from "../component/Modal.vue";
import Toast from "primevue/toast";
import Button from "primevue/button";
import Dialog from "primevue/dialog";

export default {
    components: {
        Modal,
        Button,
        Toast,
        Dialog,
    },
    data() {
        return {
            condition: "",
            visible: false,
        };
    },
    methods: {
        saveAndSubmit() {
            this.visible = false;
            this.submitCondition();
        },
        submitCondition() {
            const { condition } = this;
            axios
                .post("/submit-condition", {
                    condition,
                })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success!",
                        detail: "Condition Created Successfully!",
                        life: 3000,
                    });
                    this.$emit("returned");
                });
        },
    },
};
</script>
