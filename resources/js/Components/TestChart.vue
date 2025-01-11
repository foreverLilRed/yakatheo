<template>
    <Line id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>

<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale);

export default {
    name: 'BarChart',
    components: { Line },
    data() {
        return {
            chartData: {
                datasets: [{
                    data: [{x: 10, y: 20}, {x: 15, y: 0}, {x: 20, y: 10}]
                }]
            },
            chartOptions: {
                responsive: true
            }
        }
    }
}
</script>