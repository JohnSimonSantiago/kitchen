<template>
    <Layout>
        <div
            class="min-h-screen w-full border-t border-gray-300 mt-11 bg-white-200 flex"
        >
            <!-- Middle Section -->
            <div class="flex-1 mt-4 flex flex-col p-5 bg-gray-50">
                <div
                    class="border-b border-gray-400 flex items-center justify-between mb-5"
                >
                    <h1 class="text-l mb-3 mt-3 font-semibold">
                        Equipment List
                    </h1>
                </div>
                <div class="my-2 grid grid-cols-4 gap-5">
                    <div v-for="equipment in equipments" class="">
                        <AddItemToReservationCard
                            :equipmentDetails="equipment"
                        />
                    </div>
                </div>
            </div>

            <!-- Right Section -->

            <div
                class="border-l border-gray-400 flex min-h-screen flex-col w-1/4 p-4 bg-gray-50"
            >
                <div v-for="equipment in equipments" class="mx-5">
                    <EditQuantityOrderCard
                        :equipmentDetails="equipment"
                    ></EditQuantityOrderCard>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import EditQuantityOrderCard from "../Card_small/EditQuantityOrderCard.vue";
import AddItemToReservationCard from "../Cards/AddItemToReservationCard.vue";

export default {
    components: {
        EditQuantityOrderCard,
        AddItemToReservationCard,
    },
    mounted() {
        this.getterEquipment();
    },
    data() {
        return {
            equipments: [],
        };
    },
    methods: {
        getterEquipment() {
            axios.get("/get-equipments").then(({ data }) => {
                console.log(data);
                this.equipments = data;
            });
        },
    },
};
</script>
