<script setup>
import { onMounted, ref, toRaw, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";
import axios from "axios";
import SealsSelector from "./SealsSelector.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const data = defineProps({
    productor: Object,
});
const form = useForm({
    productor_id: data.productor.id,
    place: "",
    hr_total: "",
    hr_prod: "",
    latitud: '',
    longitud: '',
    altitud: '',
    zona: '',
    este: '',
    norte: ''
});

const terrains = ref({})
const isLoading = ref(false);

const area_total = ref("");
const area_production = ref("");

watch(modalStatus, (newStatus) => {
    if (newStatus) {
        isLoading.value = true;
        axios
            .get(`/fetch/terrains/${data.productor.id}`)
            .then((response) => {
                terrains.value = response.data;
            })
            .catch((error) => {
                console.error("Error al obtener los datos:", error);
            })
            .finally(() => {
                isLoading.value = false;
            });
    }
});


function registerTerrain() {
    form.hr_total = toRaw(area_total.value);
    form.hr_prod = toRaw(area_production.value);
    form.post(route("terrains-store"), {
        onSuccess: () => {
            form.reset();
            area_total.value = '';
            area_production.value = ''
            modalStatus.value = false;
        },
    });
}

watch([area_total, area_production], ([newTotal, newProduction]) => {
    newProduction > newTotal
        ? (area_production.value = area_total.value)
        : null;
});
</script>

<template>
    <button @click="modalStatus = true" class="btn btn-info btn-xs">
        Registrar tierra
    </button>
    <DialogModal :show="modalStatus" @close="closeModal">
        <template #title>Registrar Tierra para {{ data.productor.nombres }}</template>

        <template #content>
            <div v-if="isLoading" class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full text-blue-500"></div>
                <span class="ml-2 text-blue-500">Cargando...</span>
            </div>

            <div v-else>
                <h5 class="text-base-content/90 text-lg font-semibold mb-3">Terrenos registrados</h5>
                <ul v-if="terrains.length > 0" class="list-inside list-disc">
                    <li v-for="terrain in terrains" :key="terrain.id" class="mb-1">
                        {{ terrain.place }} - {{ terrain.hr_total }} ha (Producción: {{ terrain.hr_prod }} ha)
                    </li>
                </ul>
                <p v-else class="text-gray-500">No hay terrenos registrados.</p>
            </div>
            <hr class="w-full h-[1.5px] bg-black my-3">
            <form @submit.prevent="registerTerrain">
                <div class="mb-5">
                    <label for="names" class="block mb-2 text-sm font-medium">Ubicacion</label>
                    <input v-model="form.place" type="text" id="names" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Lugar" />
                    <InputError :message="form.errors.place" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-5">
                        <label for="hr_total" class="block mb-2 text-sm font-medium">Hectareas Totales</label>
                        <input v-model="area_total" type="text" id="hr_total" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Hectareas Totales" />
                        <InputError :message="form.errors.hr_total" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="hr_prod" class="block mb-2 text-sm font-medium">Hectareas de Produccion</label>
                        <input v-model="area_production" type="text" id="hr_prod" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Hectareas de Produccion" />
                        <InputError :message="form.errors.hr_prod" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="latitud" class="block mb-2 text-sm font-medium">Latitud</label>
                        <input v-model="form.latitud" type="text" id="latitud" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Latitud" />
                        <InputError :message="form.errors.latitud" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="longitud" class="block mb-2 text-sm font-medium">Longitud</label>
                        <input v-model="form.longitud" type="text" id="longitud" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Latitud" />
                        <InputError :message="form.errors.longitud" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="altitud" class="block mb-2 text-sm font-medium">Altitud</label>
                        <input v-model="form.altitud" type="text" id="altitud" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Latitud" />
                        <InputError :message="form.errors.altitud" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="zona" class="block mb-2 text-sm font-medium">Zona</label>
                        <input v-model="form.zona" type="text" id="zona" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Latitud" />
                        <InputError :message="form.errors.zona" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="este" class="block mb-2 text-sm font-medium">Este</label>
                        <input v-model="form.este" type="text" id="este" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Latitud" />
                        <InputError :message="form.errors.este" class="mt-2" />
                    </div>
                    <div class="mb-5">
                        <label for="norte" class="block mb-2 text-sm font-medium">Norte</label>
                        <input v-model="form.norte" type="text" id="norte" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Latitud" />
                        <InputError :message="form.errors.norte" class="mt-2" />
                    </div>
                </div>

                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
