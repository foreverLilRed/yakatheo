<template>

    <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">{{ title }}</h5>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2">
            <dl class="flex items-center">
                <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">{{first_text}}:</dt>
                <dd class="text-gray-900 text-base dark:text-white font-semibold">{{first_value}}</dd>
            </dl>
            <dl class="flex items-center justify-end">
                <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">{{second_text}}:</dt>
                <dd class="text-gray-900 text-base dark:text-white font-semibold">{{second_value}}</dd>
            </dl>
        </div>

        <div id="column-chart" class="mt-4"></div>
    </div>

</template>
<script setup>
import ApexCharts from 'apexcharts';
import { onMounted } from 'vue';

const props = defineProps({
    data: Array,
    title: String,
    first_text: String,
    first_value: String,
    second_text: String,
    second_value: String,
})

const getChartOptions = () => {
    return {
        colors: ["#1A56DB", "#FDBA8C"],
        series: [
            {
                name: "Cantidad",
                color: "#FDBA8C",
                data: props.data,
            },
        ],
        chart: {
            type: "bar",
            height: "320px",
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: true,  // Habilita el toolbar
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 8,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -14
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            floating: false,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: true,  // Ahora se muestran los valores del eje Y
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            }
        },
        fill: {
            opacity: 1,
        },
    }
}

onMounted(() => {
    if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart"), getChartOptions());
        chart.render();
    }
})
</script>
