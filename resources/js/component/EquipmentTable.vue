<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead>
                <tr
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <th scope="col" class="px-6 py-3">Equipment Name</th>
                    <th scope="col" class="px-6 py-3">Quantity</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Barcode</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(equipment, index) in equipments" key="index0">
                    <td class="py-2 px-4 border-r">
                        {{ equipment.equipmentName }}
                    </td>
                    <td class="py-2 px-4 border-r">
                        {{ equipment.description }}
                    </td>
                    <td class="py-2 px-4 border-r">{{ equipment.quantity }}</td>
                    <td class="py-2 px-4 border-r">{{ equipment.barcode }}</td>
                    <td class="py-2 px-4">
                        <button
                            class="bg-blue-500 py-2 px-4 rounded text-white mr-2"
                            @click="$emit('editEquipment', equipment.id)"
                        >
                            Edit
                        </button>
                        <button
                            class="bg-red-500 py-2 px-4 rounded text-white"
                            @click="deleteEquipment(equipment.id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["equipments"],
    methods: {
        deleteEquipment(Id) {
            axios.post("/delete-equipment", { Id }).then(({ data }) => {
                this.$emit("success");
            });
        },
    },
};
</script>
