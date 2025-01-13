<script setup>
import TestChart from '@/Components/TestChart.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="px-12 py-12">
            <TestChart></TestChart>
        </div>
    </AppLayout>
</template>
