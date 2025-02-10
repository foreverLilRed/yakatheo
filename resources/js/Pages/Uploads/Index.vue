<template>
    <AppLayout>
        <form @submit.prevent="submitFile" class="flex flex-col space-y-4">
            <div class="grid grid-cols-3 gap-4">
                <!-- Campo de archivo -->
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="file_input" type="file" accept=".xlsx"
                    @change="handleFileUpload"
                />
                
                <!-- Campo de fecha -->
                <input
                    v-model="fecha"
                    type="date"
                    class="block w-full p-2 border border-gray-300 rounded-lg"
                />
                
                <!-- Checkbox de socios -->
                <label class="flex items-center space-x-2">
                    <input v-model="socios" type="checkbox" class="w-4 h-4 text-green-600" />
                    <span>Socios</span>
                </label>
                
                <!-- Campo de inicio -->
                <input
                    v-model.number="inicio"
                    type="number"
                    placeholder="Inicio"
                    class="block w-full p-2 border border-gray-300 rounded-lg"
                />
                
                <!-- Campo de fin -->
                <input
                    v-model.number="fin"
                    type="number"
                    placeholder="Fin"
                    class="block w-full p-2 border border-gray-300 rounded-lg"
                />
            </div>

            <button class="btn btn-success" :disabled="!file">
                Subir
            </button>
        </form>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const file = ref(null);
const fecha = ref("");
const socios = ref(false);
const inicio = ref(null);
const fin = ref(null);

const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile && selectedFile.type === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
        file.value = selectedFile;
    } else {
        alert("Por favor, selecciona un archivo válido (.xlsx)");
        event.target.value = "";
    }
};

const submitFile = () => {
    if (!file.value) return;

    const formData = new FormData();
    formData.append("file", file.value);
    formData.append("fecha", fecha.value);
    formData.append("socios", socios.value ? 1 : 0);
    formData.append("inicio", inicio.value);
    formData.append("fin", fin.value);

    router.post('/uploads/store', formData, {
        onSuccess: () => {
            alert("Archivo subido correctamente");
        },
        onError: (errors) => {
            alert("Error al subir el archivo");
        }
    });
};
</script>
