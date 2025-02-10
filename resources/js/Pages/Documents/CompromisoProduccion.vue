<template>
    <AppLayout>
        <h2 class="text-base-content text-3xl mb-3">Compromiso de producción</h2>
        <form @submit.prevent="generateDocument" class="w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-5">
                <label for="nombres" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres del
                    productor</label>
                <input v-model="form.nombres" type="text" id="nombres"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                    placeholder="Nombres..." required />
                <InputError :message="form.errors.nombres" class="mt-2" />
            </div>
            <div class="mb-5">
                <label for="dni" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI del
                    productor</label>
                <input v-model="form.dni" type="text" id="dni"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                    placeholder="DNI..." required />
                <InputError :message="form.errors.dni" class="mt-2" />
            </div>
            <div class="mb-5">
                <label for="domicilio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domicilio
                    del productor</label>
                <input v-model="form.domicilio" type="text" id="domicilio"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                    placeholder="Domicilio..." required />
                <InputError :message="form.errors.domicilio" class="mt-2" />
            </div>
            <div class="mb-5">
                <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha del
                    documento</label>
                <input v-model="form.fecha" type="date" id="fecha"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                    required />
                <InputError :message="form.errors.fecha" class="mt-2" />
            </div>
            </div>
            <button type="submit" class="btn btn-success btn-block btn-outline mt-8">Generar</button>
        </form>
    </AppLayout>
</template>

<script setup>
import { onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    data: Object
});

const form = useForm({
    nombres: '',
    dni: '',
    domicilio: '',
    fecha: ''
});

onMounted(() => {
    form.fecha = props.data.actualDate;
});

function generateDocument() {
    window.open(route('store-compromiso-produccion') + '?' + new URLSearchParams(form.data()).toString(), '_blank');
}

</script>
