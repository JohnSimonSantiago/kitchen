<template>
    <div class="card">
        <DataTable
            v-model:expandedRows="expandedRows"
            :value="products"
            dataKey="id"
            @rowExpand="onRowExpand"
            @rowCollapse="onRowCollapse"
            tableStyle="min-width: 60rem"
        >
            <template #header>
                <div class="flex flex-wrap justify-content-end gap-2">
                    <Button
                        text
                        icon="pi pi-plus"
                        label="Expand All"
                        @click="expandAll"
                    />
                    <Button
                        text
                        icon="pi pi-minus"
                        label="Collapse All"
                        @click="collapseAll"
                    />
                </div>
            </template>
            <Column expander style="width: 5rem" />
            <Column field="name" header="Name"></Column>
            <Column header="Image">
                <template #body="slotProps">
                    <img
                        :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`"
                        :alt="slotProps.data.image"
                        class="shadow-4"
                        width="64"
                    />
                </template>
            </Column>
            <Column field="price" header="Price">
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.price) }}
                </template>
            </Column>
            <Column field="category" header="Category"></Column>
            <Column field="rating" header="Reviews">
                <template #body="slotProps">
                    <Rating
                        :modelValue="slotProps.data.rating"
                        readonly
                        :cancel="false"
                    />
                </template>
            </Column>
            <Column header="Status">
                <template #body="slotProps">
                    <Tag
                        :value="slotProps.data.inventoryStatus"
                        :severity="getSeverity(slotProps.data)"
                    />
                </template>
            </Column>
            <template #expansion="slotProps">
                <div class="p-3">
                    <h5>Orders for {{ slotProps.data.name }}</h5>
                    <DataTable :value="slotProps.data.orders">
                        <Column field="id" header="Id" sortable></Column>
                        <Column
                            field="customer"
                            header="Customer"
                            sortable
                        ></Column>
                        <Column field="date" header="Date" sortable></Column>
                        <Column field="amount" header="Amount" sortable>
                            <template #body="slotProps">
                                {{ formatCurrency(slotProps.data.amount) }}
                            </template>
                        </Column>
                        <Column field="status" header="Status" sortable>
                            <template #body="slotProps">
                                <Tag
                                    :value="slotProps.data.status.toLowerCase()"
                                    :severity="getOrderSeverity(slotProps.data)"
                                />
                            </template>
                        </Column>
                        <Column headerStyle="width:4rem">
                            <template #body>
                                <Button icon="pi pi-search" />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>
        </DataTable>
        <Toast />
    </div>
</template>

<script>
import axios from "axios";
import Modal from "../component/Modal.vue";
import ReturnReservation from "../componentReservations/ReturnReservation.vue";
import RejectReservation from "../componentReservations/RejectReservation.vue";
import ApproveReservation from "../componentReservations/ApproveReservation.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Toast from "primevue/toast";
import Rating from "primevue/rating";
import Button from "primevue/button";

export default {
    components: {
        Modal,
        Button,
        Rating,
        ReturnReservation,
        RejectReservation,
        ApproveReservation,
        DataTable,
        Toast,

        Column,
    },
    mounted() {
        this.getterReservations();
    },
    data() {
        return {
            reservations: [],
        };
    },
    props: ["reservationDetails"],
    methods: {
        getterReservations() {
            axios.get("/get-reservations").then(({ data }) => {
                this.reservations = data;
            });
        },
        readMore(data) {
            this.$emit("clicked", data);
        },
        onRowExpand(event) {
            this.$toast.add({
                severity: "info",
                summary: "Product Expanded",
                detail: event.data.name,
                life: 3000,
            });
        },
        onRowCollapse(event) {
            this.$toast.add({
                severity: "success",
                summary: "Product Collapsed",
                detail: event.data.name,
                life: 3000,
            });
        },
        expandAll() {
            this.expandedRows = this.products.reduce(
                (acc, p) => (acc[p.id] = true) && acc,
                {}
            );
        },
        collapseAll() {
            this.expandedRows = null;
        },
        formatCurrency(value) {
            return value.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
        getSeverity(product) {
            switch (product.inventoryStatus) {
                case "INSTOCK":
                    return "success";

                case "LOWSTOCK":
                    return "warning";

                case "OUTOFSTOCK":
                    return "danger";

                default:
                    return null;
            }
        },
        getOrderSeverity(order) {
            switch (order.status) {
                case "DELIVERED":
                    return "success";

                case "CANCELLED":
                    return "danger";

                case "PENDING":
                    return "warning";

                case "RETURNED":
                    return "info";

                default:
                    return null;
            }
        },
    },
};
</script>
