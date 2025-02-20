<script setup>
import { ref, onMounted, watch } from "vue";

const data = defineProps({
    normas: {
        type: Array,
        required: false,
        default: () => [] 
    },
})
const normas = ref([]); 
const selectedNormas = ref([]);  

const emit = defineEmits(['selectedNormas'])
onMounted(() => {
    fetchNormas();
    if (data.normas.length > 0) {
        selectedNormas.value = data.normas;
    }
});

const fetchNormas = async () => {
    try {
        const response = await axios.get("/fetch/normas");
        normas.value = response.data;  
    } catch (error) {
        alert("No se pudieron cargar las normas: " + error);
    }
};

const emitSelectedNormas = () => {
    emit("selectedNormas", selectedNormas.value);
};

</script>

<template>
    <div class="flex gap-4 flex-wrap"> 
        <label v-for="norma in normas" :key="norma.id" class="form-control flex items-center gap-2">
            <input 
                type="checkbox" 
                class="checkbox checkbox-primary" 
                :value="norma.id" 
                v-model="selectedNormas" 
                @change="emitSelectedNormas" 
            />
            <span class="label cursor-pointer flex-col items-start">
                <span class="label-text text-base">{{ norma.name }}</span>
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
