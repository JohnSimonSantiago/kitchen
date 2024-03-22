<template>
    <Layout>
        <div class="min-h-screen w-full border-t border-gray-300 mt-11 flex">
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Dashboard</h1>
                    <div class="space-x-1"></div>
                </div>


                <div class="my-2 grid grid-cols-4 gap-5"></div>
            </div>

            <!-- Right Section -->
            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            ></div>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";

export default {
}
</script>
