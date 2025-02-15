<script>
import Paginator from "@/Components/Paginator.vue";
import PieChart from "@/Components/PieChart.vue";
import ProductsTable from "@/Components/ProductsTable.vue";
import RegisterProduct from "@/Components/RegisterProduct.vue";
import RegisterProductor from "@/Components/RegisterProductor.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";

export default {
    components: {
        AppLayout,
        Paginator,
        ProductsTable,
        RegisterProduct,
        RegisterProductor,
        PieChart
    },
    props: {
        products: {
            type: Object,
            required: true,
        },
        segmentacion: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: {
                search: "",
            },
        };
    },
    watch: {
        "form.search": throttle(function (newSearch) {
            this.$inertia.get(
                "/products",
                { search: newSearch },
                { preserveState: true }
            );
        }, 150),
    },
};
</script>

<template>
    <AppLayout title="Productos">
        <div class="px-4 py-4">
            <h2 class="text-base-content text-3xl mb-8">Productos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="flex items-center space-x-4 mb-6">
                        <label class="input-group max-w-sm flex-grow">
                            <span class="input-group-text">
                                <span class="icon-[tabler--search] text-base-content/80 size-6"></span>
                            </span>
                            <input v-model="form.search" type="search" class="input grow placeholder:italic"
                                placeholder="Buscar por nombre,..." />
                        </label>
                        <RegisterProduct></RegisterProduct>
                    </div>
                    <ProductsTable :products="products.data"></ProductsTable>
                    <Paginator :links="products.links"></Paginator>
                </div>
                <div>
                    <PieChart titulo="Porcentajes de stock" :labels="segmentacion.productos" :data="segmentacion.porcentajes"></PieChart>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
