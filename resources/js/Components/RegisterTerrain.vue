<script setup>
import { onMounted, ref, toRaw, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
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
});

const area_total = ref("");
const area_production = ref("")

function registerTerrain() {
    form.hr_total = toRaw(area_total.value)
    form.hr_prod = toRaw(area_production.value)
    form.post((route("terrains-store")))
}

watch([area_total, area_production], ([newTotal, newProduction]) => {
    newProduction > newTotal ? area_production.value = area_total.value : null
})
</script>

<template>
    <button @click="modalStatus = true" class="btn btn-info btn-xs">
        Registrar tierra
    </button>
    <DialogModal :show="modalStatus" @close="closeModal">
        <template #title
            >Registrar Tierra para {{ data.productor.nombres }}</template
        >

        <template #content>
            <form @submit.prevent="registerTerrain">
                <div class="mb-5">
                    <label for="names" class="block mb-2 text-sm font-medium"
                        >Ubicacion</label
                    >
                    <input
                        v-model="form.place"
                        type="text"
                        id="names"
                        required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Lugar"
                    />
                    <InputError :message="form.errors.place" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-5">
                        <label
                            for="hr_total"
                            class="block mb-2 text-sm font-medium"
                            >Hectareas Totales</label
                        >
                        <input
                            v-model="area_total"
                            type="text"
                            id="hr_total"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Hectareas Totales"
                        />
                        <InputError
                            :message="form.errors.hr_total"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-5">
                        <label for="hr_prod" class="block mb-2 text-sm font-medium"
                            >Hectareas de Produccion</label
                        >
                        <input
                            v-model="area_production"
                            type="text"
                            id="hr_prod"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Hectareas de Produccion"
                        />
                        <InputError :message="form.errors.hr_prod" class="mt-2" />
                    </div>
                </div>

                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
