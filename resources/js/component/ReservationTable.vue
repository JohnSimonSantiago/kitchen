<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="px-6 py-3">Item</th>
                    <th scope="col" class="px-6 py-3">Quantity</th>
                    <th scope="col" class="px-6 py-3">Condition</th>
                    <th scope="col" class="px-6 py-3">Price</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(equipment, index) in equipments" key="index0">
                    <td class="py-2 px-4 border-r">
                        {{ equipment.equipmentName }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ equipment.quantity }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ equipment.condition }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ equipment.price }}
                    </td>
                    <td class="py-2 px-4"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getter();
    },
    data() {
        return {
            equipments: [],
        };
    },
    methods: {
        getter() {
            axios.get("/get-equipments").then(({ data }) => {
                console.log(data);
                this.equipments = data;
            });
        },
    },
};
</script>
