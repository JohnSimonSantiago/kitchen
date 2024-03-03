<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-gray-100 flex"
        >
            <div class="flex-1 flex flex-col p-5 bg-gray-300">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-4"
                >
                    <h1 class="text-l font-semibold">Orders</h1>
                </div>
                <div>
                    <ReservationTable2
                        class=""
                        @clicked="seeReservationDetails"
                    ></ReservationTable2>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import ReservationTable2 from "../component/ReservationTable2.vue";

export default {
    components: {
        ReservationTable2,
    },
    mounted() {
        this.getterReservation();
        this.getterReservationOrder();
    },
    data() {
        return {
            reservations: null,
            showReservationDetails: null,
        };
    },
    methods: {
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        seeReservationDetails(data) {
            this.showReservationDetails = data;
        },
        getterReservationOrder() {
            axios.get("/get-reservation-orders").then(({ data }) => {
                this.reservationOrder = data;
            });
        },
    },
};
</script>
