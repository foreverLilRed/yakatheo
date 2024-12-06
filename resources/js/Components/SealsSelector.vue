<script setup>
import { ref, onMounted, watch } from "vue";

const seals = ref([]);  // Para almacenar los sellos (opciones)

const selectedSeals = ref([]);  // Para almacenar los sellos seleccionados

const emit = defineEmits(['selectedSeals'])
// Método para recuperar los sellos
onMounted(() => {
    fetchSeals();
});

const fetchSeals = async () => {
    try {
        const response = await axios.get("/fetch/seals");
        seals.value = response.data;  // Asigna la respuesta a seals
        console.log("Respuesta:", response.data);
    } catch (error) {
        console.error("Error:", error);
    }
};

// Emitir los sellos seleccionados al componente padre
const emitSelectedSeals = () => {
    emit("selectedSeals", selectedSeals.value);
};

</script>

<template>
    <div class="flex gap-4 flex-wrap"> <!-- Cambié aquí para permitir el wrap -->
        <!-- Iterar sobre los sellos y crear un checkbox para cada uno -->
        <label v-for="seal in seals" :key="seal.id" class="form-control flex items-center gap-2">
            <input 
                type="checkbox" 
                class="checkbox checkbox-primary" 
                :value="seal.id" 
                v-model="selectedSeals" 
                @change="emitSelectedSeals" 
            />
            <span class="label cursor-pointer flex-col items-start">
                <span class="label-text text-base">{{ seal.name }}</span>
            </span>
        </label>
    </div>
</template>

<style scoped>
/* Asegúrate de que el contenedor tenga un wrap */
.flex-wrap {
    flex-wrap: wrap;
}

.form-control {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 10px;
    flex: 1 1 200px; /* Esto asegura que cada checkbox tenga un tamaño flexible */
}

</style>
