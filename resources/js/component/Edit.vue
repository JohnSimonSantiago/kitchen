<template>
    <div class="">
        <h1>Edit</h1>
        <form @submit.prevent="updateDetails">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label
                        for="first_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Name</label
                    >
                    <input
                        v-model="data.name"
                        type="text"
                        id="first_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Student Name"
                        required
                    />
                </div>
                <div>
                    <label
                        for="last_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Course</label
                    >
                    <input
                        v-model="data.course"
                        type="text"
                        id="last_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Course"
                        required
                    />
                </div>
            </div>
            <button
                type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                Submit
            </button>
        </form>
    </div>
</template>

<script>
export default {
    props: ["id"],
    data() {
        return {
            edit_id: 0,
            data: {
                id: 0,
                name: "",
                course: "",
            },
        };
    },
    methods: {
        getStudent() {
            const { edit_id } = this;
            axios.post("/get-student", { edit_id }).then(({ data }) => {
                this.data = data;
            });
        },
        updateDetails() {
            const { data } = this;
            axios.post("/update-student", { data }).then(({ data }) => {
                this.data = {
                    id: 0,
                    name: "",
                    course: "",
                };

                this.$emit("success");
            });
        },
    },
    mounted() {
        this.edit_id = this.id;
        this.getStudent();
    },
    watch: {
        edit_id(New, Old) {
            this.data.id = New;
            this.getStudent();
        },
    },
};
</script>
