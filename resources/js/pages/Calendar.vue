<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-200">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Calendar</h1>
                    <div class="space-x-1"></div>
                </div>

                <Calendar inline></Calendar>

                <div class="my-2 grid grid-cols-4 gap-5"></div>
            </div>

            <!-- Right Section -->
            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-100"
            >
                <div>
                    <h2 class="border-b border-gray-300 text-l font-semibold">
                        Reservation Details
                    </h2>
                    <div class="card flex justify-content-center">
                        <Button label="Show" @click="visible = true" />
                        <Dialog
                            v-model:visible="visible"
                            modal
                            header="Edit Profile"
                            :style="{ width: '25rem' }"
                        >
                            <span class="p-text-secondary block mb-5"
                                >Update your information.</span
                            >
                            <div class="flex align-items-center gap-3 mb-3">
                                <label
                                    for="username"
                                    class="font-semibold w-6rem"
                                    >Username</label
                                >
                                <InputText
                                    id="username"
                                    class="flex-auto"
                                    autocomplete="off"
                                />
                            </div>
                            <div class="flex align-items-center gap-3 mb-5">
                                <label for="email" class="font-semibold w-6rem"
                                    >Email</label
                                >
                                <InputText
                                    id="email"
                                    class="flex-auto"
                                    autocomplete="off"
                                />
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
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import Calendar from "primevue/calendar";

export default {
    components: {
        Dialog,
        Calendar,

        Button,
    },
    data() {
        return {
            value: 0,
            visible: false,
        };
    },
};
</script>
