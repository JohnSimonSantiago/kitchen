<template>
    <div>
        <table class="table-auto">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(student, index) in students" :key="index">
                    <td>{{ student.name }}</td>
                    <td>{{ student.course }}</td>
                    <td>
                        <button
                            class=" bg-blue-500 py-2 px-4 rounded text-white"
                            @click="$emit('editStudent', student.id)"
                        >
                            Edit
                        </button>
                        <button
                            class="bg-red-500 py-2 px-4 rounded text-white"
                            @click="deleteStudent(student.id)"
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
    props: ["students"],
    methods: {
        deleteStudent(Id) {
            axios.post("/delete-student", { Id }).then(({ data }) => {
                this.$emit("success");
            });
        },
    },
};
</script>
