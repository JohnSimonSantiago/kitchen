<template>
    <UserLayout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-300">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Rent Equipment</h1>
                    <div class="space-x-1"></div>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5"></div>
            </div>

            <!-- Right Section -->
            <div class="flex min-h-screen flex-col w-1/4 p-4 bg-gray-200">
                <div>
                    <h2 class="border-b border-gray-300 text-l font-semibold">
                        Rent
                    </h2>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script>
import UserLayout from "../Layout/UserLayout.vue";

export default {
    components: {
        UserLayout,
    },
};
</script>
