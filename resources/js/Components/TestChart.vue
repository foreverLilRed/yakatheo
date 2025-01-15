<template>
    <div>
        <apexchart 
            id="grafico-productores-por-comunidad" 
            type="bar" 
            :options="chartOptions" 
            :series="chartData"
            height="400" 
        />
    </div>
</template>

<script>
import ApexCharts from "vue3-apexcharts";

export default {
    name: 'TestChart',
    components: {
        apexchart: ApexCharts
    },
    props: {
        segmentacion: Array,
        title: {
            type: String,
            default: 'Productores por Comunidad', 
        },
    },
    data() {
        return {
            chartData: [
                {
                    name: 'Total',
                    data: [],
                },
            ],
            chartOptions: {
                chart: {
                    id: 'grafico-productores-por-comunidad',
                    type: 'bar',
                },
                xaxis: {
                    categories: [],
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                    },
                },
                title: {
                    text: this.title, // Usar el valor de la prop
                    align: 'center',
                },
            },
        };
    },
    watch: {
        segmentacion(newSegmentacion) {
            if (newSegmentacion && newSegmentacion.length) {
                this.chartOptions.xaxis.categories = newSegmentacion.map(item => item.name);
                this.chartData[0].data = newSegmentacion.map(item => item.count);
            }
        },
        title(newTitle) {
            this.chartOptions.title.text = newTitle; // Actualizar dinámicamente el título si cambia la prop
        },
    },
    mounted() {
        if (this.segmentacion && this.segmentacion.length) {
            this.chartOptions.xaxis.categories = this.segmentacion.map(item => item.name);
            this.chartData[0].data = this.segmentacion.map(item => item.count);
        }
    },
};
</script>

<style scoped>
#grafico-productores-por-comunidad {
    width: 100%;
    height: 400px;
}
</style>
