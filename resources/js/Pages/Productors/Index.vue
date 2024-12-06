<script>
import Paginator from "@/Components/Paginator.vue";
import ProductorsTable from "@/Components/ProductorsTable.vue";
import RegisterProductor from "@/Components/RegisterProductor.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";

export default {
    components: {
        AppLayout,
        Paginator,
        ProductorsTable,
        RegisterProductor,
    },
    props: {
        productors: Array
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
                "/productors",
                { search: newSearch },
                { preserveState: true }
            );
        }, 150),
    },
};
</script>

<template>
    <AppLayout title="Productores">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productores
            </h2>
        </template>

        <div class="px-12 py-12">
            <div class="flex items-center space-x-4">
                <label class="input-group max-w-sm flex-grow">
                    <span class="input-group-text">
                        <span
                            class="icon-[tabler--search] text-base-content/80 size-6"
                        ></span>
                    </span>
                    <input
                        v-model="form.search"
                        type="search"
                        class="input grow"
                        placeholder="Buscar por nombre..."
                    />
                </label>
                <RegisterProductor></RegisterProductor>
            </div>

            <ProductorsTable :productors="productors.data" class="my-6"></ProductorsTable>
            <Paginator :links="productors.links"></Paginator>
        </div>
    </AppLayout>
</template>
