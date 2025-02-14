<script>
import Paginator from "@/Components/Paginator.vue";
import ProcurementsTable from "@/Components/ProcurementsTable.vue";
import RegisterProcurement from "@/Components/RegisterProcurement.vue";
import TestChart from "@/Components/TestChart.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";

export default {
    components: {
        AppLayout,
        Paginator,
        RegisterProcurement,
        ProcurementsTable,
        TestChart
    },
    props: {
        procurements: {
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
                "/procurements",
                { search: newSearch },
                { preserveState: true }
            );
        }, 150),
    },
};
</script>

<template>
    <AppLayout title="Acopios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Acopios
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
                <RegisterProcurement class="w-full sm:w-auto"></RegisterProcurement>
            </div>
            <ProcurementsTable :procurements="procurements.data" class="mt-6"></ProcurementsTable>
            <div class="flex justify-center mt-4">
                <Paginator :links="procurements.links"></Paginator>
            </div>
        </div>
    </AppLayout>
</template>
