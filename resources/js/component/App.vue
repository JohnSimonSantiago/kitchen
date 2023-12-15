<template>
    <Layout1 :authenticated="authenticated">
        <div class="h-screen w-screen flex items-center justify-center">
            <div class="shadow-lg p-5 rounded-xl">
                <CreateEquipment @success="getter" v-if="!is_edit" />
                <EditEquipment :id="editId" @success="editSuccess" v-else />
                <EquipmentTable
                    :equipments="equipments"
                    @editEquipment="editEquipment"
                    @success="getter"
                />
            </div>
        </div>
    </Layout1>
</template>

<script>
import Layout1 from "../Layout/Layout1.vue";
import CreateEquipment from "./CreateEquipment.vue";
import EditEquipment from "./EditEquipment.vue";
import EquipmentTable from "./EquipmentTable.vue";

export default {
    components: {
        Layout1,
        CreateEquipment,
        EditEquipment,
        EquipmentTable,
    },
    data() {
        return {
            equipments: [],
            authenticated: 0,
            is_edit: false,
            editId: 0,
        };
    },
    methods: {
        getter() {
            axios.get("/get-equipments").then(({ data }) => {
                console.log(data);
                this.equipments = data;
            });
        },
        editEquipment(id) {
            this.editId = id;
            this.is_edit = true;
        },
        editSuccess() {
            this.edit_id = 0;
            this.is_edit = false;
            this.getter();
        },
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                console.log(data);
                this.authenticated = data;
                console.log(this.authenticated);
                if (this.authenticated === 0) {
                    this.$router.push("/login");
                }
            });
        },
    },
    mounted() {
        this.getter();
        this.checkAuth();
    },
    watch: {
        authenticated(newValue) {
            if (!newValue) {
                this.$router.push("/login");
            }
        },
    },
};
</script>
