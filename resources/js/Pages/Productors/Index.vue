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
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productores
            </h2>
        </template>

        <div class="px-4 sm:px-8 md:px-12 py-8 md:py-12">
            <div class="flex flex-wrap items-center gap-4">
                <label class="input-group w-full sm:w-auto flex-grow">
                    <span class="input-group-text">
                        <span class="icon-[tabler--search] text-base-content/80 size-6"></span>
                    </span>
                    <input
                        v-model="form.search"
                        type="search"
                        class="input w-full sm:w-auto placeholder:italic"
                        placeholder="Buscar por nombre, apellidos o DNI..."
                    />
                </label>
                <div class="flex flex-wrap w-full sm:w-auto gap-2">
                    <RegisterProductor class="w-full sm:w-auto"></RegisterProductor>
                    <RegisterCommunity class="w-full sm:w-auto"></RegisterCommunity>
                    <ReportProductors class="w-full sm:w-auto"></ReportProductors>
                </div>
            </div>
            <ProductorsTable :productors="productors.data" class="my-6"></ProductorsTable>
            <div class="flex justify-center">
                <Paginator :links="productors.links"></Paginator>
            </div>
        </div>
    </AppLayout>
</template>
