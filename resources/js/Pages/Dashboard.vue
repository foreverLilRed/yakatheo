<script setup>
import CreditsChart from '@/Components/CreditsChart.vue';
import TestChart from '@/Components/TestChart.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const data = defineProps({
    segmentacion: Array,
    sales: Array,
    credits: Array,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="px-12 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <TestChart title="Productores por comunidad" :segmentacion="data.segmentacion"></TestChart>
                <TestChart title="Ganancias por Producto (En Soles)" :segmentacion="data.sales"></TestChart>
            </div>
            <CreditsChart :credits="data.credits"/>
        </div>
    </AppLayout>
</template>
