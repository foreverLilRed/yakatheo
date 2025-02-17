<script>
import Paginator from "@/Components/Paginator.vue";
import ProcurementsTable from "@/Components/ProcurementsTable.vue";
import RegisterProcurement from "@/Components/RegisterProcurement.vue";
import TestChart from "@/Components/TestChart.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";
import BarChart from "@/Components/BarChart.vue";

export default {
    components: {
        AppLayout,
        Paginator,
        RegisterProcurement,
        ProcurementsTable,
        TestChart,
        BarChart
    },
    props: {
        procurements: {
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
        <div class="px-4 py-4">
            <h2 class="text-base-content text-3xl mb-8">Acopios</h2>
            <div class="flex flex-wrap items-center gap-4">
                <label class="input-group w-full sm:w-auto flex-grow">
                    <span class="input-group-text">
                        <span class="icon-[tabler--search] text-base-content/80 size-6"></span>
                    </span>
                    <input v-model="form.search" type="search" class="input w-full placeholder:italic"
                        placeholder="Buscar por nombre, apellidos o DNI..." />
                </label>
                <RegisterProcurement class="w-full sm:w-auto">
                    <div class="divider">Promedio de precios por kilo</div>
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-1 mb-4">
                        <div v-for="estimado in segmentacion.precios_promedios" class="rounded shadow text-center p-1">
                            <h1 class="underline text-xs">{{ estimado.producto }}</h1>
                            <p class="font-bold mt-1"><span class="font-normal">S/. </span>{{ estimado.promedio }}</p>
                        </div>
                    </div>
                </RegisterProcurement>
            </div>
            <ProcurementsTable :procurements="procurements.data" class="mt-6"></ProcurementsTable>
            <div class="flex justify-center mt-4">
                <Paginator :links="procurements.links"></Paginator>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
                <BarChart title="Acopios por producto" :data="segmentacion.acopios_por_producto" first_text="Mes actual"
                    :first_value="segmentacion.cantidad_mes_actual" second_text="Mes anterior"
                    :second_value="segmentacion.cantidad_mes_pasado" />
                <div>
                    <div class="w-full shadow-md rounded-md bg-gray-50 text-center flex flex-col p-3 gap-2">
                        <h1 class="text-lg">Costos del mes</h1>
                        <p class="font-semibold text-2xl">S/. {{ segmentacion.costo_mes }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="shadow rounded-md p-3">
                            <h2 class="text-center mb-2 text-lg font-semibold text-gray-900 dark:text-white">Top socios
                                del mes</h2>
                            <ol class="max-w-md space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
                                <h1 class="text-center" v-if="segmentacion.tops.mes.length == 0">Sin resultados</h1>
                                <li v-for="productor in segmentacion.tops.mes">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ productor.names }}</span>
                                    con <span
                                        class="font-semibold text-gray-900 dark:text-white">{{ productor.procurements_count }}</span>
                                    acopios
                                </li>
                            </ol>
                        </div>
                        <div class="shadow rounded-md p-3">
                            <h2 class="text-center mb-2 text-lg font-semibold text-gray-900 dark:text-white">Top socios
                                global</h2>
                            <ol class="max-w-md space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
                                <h1 class="text-center" v-if="segmentacion.tops.total.length == 0">Sin resultados</h1>
                                <li v-else v-for="productor in segmentacion.tops.total">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ productor.names }}</span>
                                    con <span
                                        class="font-semibold text-gray-900 dark:text-white">{{ productor.procurements_count }}</span>
                                    acopios
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
