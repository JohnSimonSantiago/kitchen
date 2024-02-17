<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-300">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Reservations</h1>
                    <div class="space-x-1"></div>
                </div>
                <div class="my-2 gap-5">
                    <!-- <ReservationTable @success="getter"></ReservationTable> -->
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex min-h-screen flex-col w-1/4 p-4 bg-gray-20">
                <div>
                    <h2 class="border-b border-gray-300 text-l font-semibold">
                        Reservation Details
                    </h2>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>
import ReservationTable from "../component/ReservationTable.vue";

export default {
    components: {
        ReservationTable,
    },
    mounted() {
        this.getter();
    },
    methods: {
        getter() {
            axios.get("/get-equipments").then(({ data }) => {
                console.log(data);
                this.equipments = data;
                console.log(data);
            });
        },
    },
};
</script>
