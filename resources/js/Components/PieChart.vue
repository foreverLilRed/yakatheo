<template>

    <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between items-start w-full">
            <div class="flex-col items-center">
                <div class="flex items-center mb-1">
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">{{titulo}}</h5>
                </div>
            </div>
        </div>

        <!-- Line Chart -->
        <div class="py-6" id="pie-chart"></div>

    </div>

</template>
<script setup>
import { computed, onMounted } from 'vue';
import ApexCharts from 'apexcharts';

const data = defineProps({
    data: Array,
    labels: Array,
    titulo: String,
})

const defaultColors = ["#1C64F2", "#16BDCA", "#9061F9", "#FF5733", "#FFC300", "#33FF57", "#3357FF"];

const generateRandomColors = (count) => {
    return Array.from({ length: count }, () => `#${Math.floor(Math.random()*16777215).toString(16)}`);
};

const colors = computed(() => {
    return data.data.length > defaultColors.length 
        ? [...defaultColors, ...generateRandomColors(data.data.length - defaultColors.length)]
        : defaultColors.slice(0, data.data.length);
});

const getChartOptions = () => {
    return {
        series: data.data,
        colors: colors.value,
        chart: {
            height: 420,
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: ["white"],
            lineCap: "",
        },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                dataLabels: {
                    offset: -25
                }
            },
        },
        labels: data.labels,
        dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
    }
}

onMounted(() => {
    if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
    }
});
</script>