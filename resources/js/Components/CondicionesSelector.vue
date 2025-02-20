<script setup>
import { ref, onMounted, watch } from "vue";

const data = defineProps({
    condiciones: {
        type: Array,
        required: false,
        default: () => [] 
    },
})
const condiciones = ref([]); 
const selectedCondiciones = ref([]);  

const emit = defineEmits(['selectedCondiciones'])
onMounted(() => {
    fetchCondiciones();
    if (data.condiciones.length > 0) {
        selectedCondiciones.value = data.condiciones;
    }
});

const fetchCondiciones = async () => {
    try {
        const response = await axios.get("/fetch/condiciones");
        condiciones.value = response.data;  
    } catch (error) {
        alert("No se pudieron cargar las condiciones: " + error);
    }
};

const emitSelectedCondiciones = () => {
    emit("selectedCondiciones", selectedCondiciones.value);
};

</script>

<template>
    <div class="flex gap-4 flex-wrap"> 
        <label v-for="condicion in condiciones" :key="condicion.id" class="form-control flex items-center gap-2">
            <input 
                type="checkbox" 
                class="checkbox checkbox-primary" 
                :value="condicion.id" 
                v-model="selectedCondiciones" 
                @change="emitSelectedCondiciones" 
            />
            <span class="label cursor-pointer flex-col items-start">
                <span class="label-text text-base">{{ condicion.name }}</span>
            </span>
        </label>
    </div>
</template>

<style scoped>
.flex-wrap {
    flex-wrap: wrap;
}

.form-control {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 10px;
    flex: 1 1 200px; 
}

</style>
