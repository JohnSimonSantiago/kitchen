<template>
    <Layout>
        <div
            class="w-full border-t border-gray-300 fixed top-11 ml-64 min-h-screen bg-gray-100 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 flex flex-col p-5 bg-gray-300">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-5"
                >
                    <h1 class="text-l mb-3 mt-3 font-semibold">
                        Equipment List
                    </h1>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5">
                    <div v-for="equipment in equipments" class="">
                        <AddToReservationCard :equipmentDetails="equipment" />
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="min-h-screen flex-col w-1/4 bg-gray-200">
                <div v-for="reservation in reservations" class="mx-5">
                    <EditQuantityCard
                        :reservationDetails="reservation"
                    ></EditQuantityCard>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import EditQuantityCard from "../Card_small/EditQuantityCard.vue";
import AddToReservationCard from "../Cards/AddToReservationCard.vue";

export default {
    props: ["reservationDetails"],
    components: {
        EditQuantityCard,
        AddToReservationCard,
    },
    mounted() {
        this.getterEquipment();
        this.getterReservation();
    },
    data() {
        return {
            equipments: [],
            reservations: [],
            showCardDetails: null,
        };
    },
    methods: {
        showDetails(data) {
            this.showCardDetails = data;
        },
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                console.log(data);
                this.equipments = data;
            });
        },
        seeReservationDetails() {
            this.$emit("clicked", this.reservationDetails);
        },
        getterReservation() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
    },
};
</script>
