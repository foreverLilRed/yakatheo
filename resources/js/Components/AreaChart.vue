<template>
    <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between">
            <div>
                <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">{{ titulo }}</h5>
                <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{descripcion}}</p>
            </div>
        </div>
        <div id="area-chart" ref="chartContainer"></div>

    </div>
</template>

<script>
import { onMounted, ref } from "vue";
import ApexCharts from "apexcharts";

export default {
    props: {
        nameSeries: String,
        titulo: String,
        descripcion: {
            type: String,
            required: false,
        },
        labels: Array,
        data: Array
    },
    setup(props) { 
        const chartContainer = ref(null);

        const options = {
            chart: {
                height: "100%",
                maxWidth: "100%",
                type: "area",
                fontFamily: "Inter, sans-serif",
                dropShadow: { enabled: false },
                toolbar: { show: true },
            },
            tooltip: { enabled: true, x: { show: false } },
            fill: {
                type: "gradient",
                gradient: {
                    opacityFrom: 0.55,
                    opacityTo: 0,
                    shade: "#1C64F2",
                    gradientToColors: ["#1C64F2"],
                },
            },
            dataLabels: { enabled: false },
            stroke: { width: 6 },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: { left: 2, right: 2, top: 0 },
            },
            series: [
                {
                    name: props.nameSeries,
                    data: props.data, 
                    color: "#1A56DB",
                },
            ],
            xaxis: {
                categories: props.labels, 
                labels: { show: true },
                axisBorder: { show: true },
                axisTicks: { show: true },
            },
            yaxis: { show: true },
        };

        onMounted(() => {
            if (chartContainer.value) {
                const chart = new ApexCharts(chartContainer.value, options);
                chart.render();
            }
        });

        return { chartContainer };
    },
};
</script>
