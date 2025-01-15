<template>
    <h1 class="text-2xl font-bold mb-6">Créditos</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="credit in credits" :key="credit.id" class="rounded-xl shadow-2xl border p-4">
                <h2 class="text-lg font-semibold">{{ credit.institution }} - Crédito {{ credit.id }}</h2>
                <p class="font-thin text-base text-gray-600">Registrado el {{ credit.creado }}</p>
                <apexchart 
                    type="donut" 
                    :options="getChartOptions(credit)"
                    :series="[credit.paid_amount, credit.remaining_balance]" 
                    height="350" 
                />
            </div>
        </div>
</template>

<script>
import ApexCharts from "vue3-apexcharts";

export default {
    components: {
        apexchart: ApexCharts,
    },
    props: {
        credits: Array,
    },
    methods: {
        getChartOptions(credit) {
            return {
                labels: [`Pagado: ${credit.paid_amount}`, `Restante ${credit.remaining_balance}`],
                title: {
                    align: "center",
                },
                colors: ["#00C853", "#D50000"],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: "Total",
                                    formatter: () => credit.total_amount.toFixed(2),
                                },
                            },
                        },
                    },
                },
            };
        },
    },
};
</script>

<style scoped>
.credit-chart {
    margin-bottom: 2rem;
    border: 1px solid #ccc;
    padding: 1rem;
    border-radius: 8px;
}
</style>
