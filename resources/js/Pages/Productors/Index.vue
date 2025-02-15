<script>
import Paginator from "@/Components/Paginator.vue";
import ProductorsTable from "@/Components/ProductorsTable.vue";
import RegisterProductor from "@/Components/RegisterProductor.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";
import axios from "axios";
import ReportProductors from "@/Components/ReportProductors.vue";
import RegisterCommunity from "@/Components/RegisterCommunity.vue";

export default {
    components: {
        AppLayout,
        Paginator,
        ProductorsTable,
        RegisterProductor,
        ReportProductors,
        RegisterCommunity
    },
    props: {
        productors: {
            type: Object,
            required: true,
        },
        segmentacion: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: {
                search: "",
            },
            searchFilters: {
                birthday: "",
            }
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
        <div class="px-4 py-4">
            <h2 class="text-base-content text-3xl mb-8">Productores</h2>
            <div class="flex flex-wrap items-center gap-4">
                <label class="input-group w-full sm:w-auto flex-grow">
                    <span class="input-group-text">
                        <span class="icon-[tabler--search] text-base-content/80 size-6"></span>
                    </span>
                    <input v-model="form.search" type="search" class="input w-full placeholder:italic"
                        placeholder="Buscar por nombre, apellidos o DNI..." />
                </label>
                <div class="flex flex-wrap w-full sm:w-auto gap-2">
                    <div class="w-full sm:w-auto">
                        <RegisterProductor />
                    </div>
                    <div class="w-full sm:w-auto">
                        <RegisterCommunity />
                    </div>
                    <div class="w-full sm:w-auto">
                        <ReportProductors />
                    </div>
                </div>
            </div>
            <ProductorsTable :productors="productors.data" class="my-6"></ProductorsTable>
            <div class="flex justify-center">
                <Paginator :links="productors.links"></Paginator>
            </div>
        </div>
    </AppLayout>
</template>
