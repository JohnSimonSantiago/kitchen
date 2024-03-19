<template>
    <Button
        label="Add/Dispose Stock"
        icon="pi pi-database"
        @click="visible = true"
        class="border border-yellow-500 p-2 hover:bg-yellow-400 hover:text-white"
    />
    <Dialog
        v-model:visible="visible"
        modal
        header="Choose Category"
        :style="{ width: '25rem' }"
    >
        <div v-if="Error">Error</div>
        <form>
            <select
                v-model="selectedCondition"
                id="category"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required
            >
                <option value="good">Good</option>
                <option value="slightly-damaged">Slightly Damaged</option>
                <option value="bad">Bad</option>
            </select>
            <div class="grid gap-6 mb-6">
                <div class="flex justify-content-end gap-2">
                    <Button
                        type="button"
                        label="Cancel"
                        severity="secondary"
                        @click="visible = false"
                    ></Button>
                    <Button
                        type="button"
                        label="Add/Dispose"
                        @click="saveAndSubmit"
                    ></Button>
                </div>
            </div>
        </form>
    </Dialog>
    <Toast />
</template>

<script>
import Dialog from "primevue/Dialog";
import Toast from "primevue/toast";
import Button from "primevue/button";

export default {
    components: {
        Button,
        Toast,
        Dialog,
    },
    data() {
        return {
            selectedCondition: "",
            visible: false,
        };
    },
    methods: {
        saveAndSubmit() {
            let conditionValue = 0; // Default value if no condition matches
            switch (this.selectedCondition) {
                case "good":
                    conditionValue = 1;
                    break;
                case "slightly-damaged":
                    conditionValue = 2;
                    break;
                case "bad":
                    conditionValue = 3;
                    break;
                default:
                    conditionValue = 0;
                    break;
            }
            this.visible = false;
            this.$emit("conditionSelected", conditionValue);
        },
    },
};
</script>
