<template>
    <UserLayout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-l font-semibold">Home</h1>
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

    mounted() {},

    data() {
        return {};
    },

    methods: {},
};
</script>
