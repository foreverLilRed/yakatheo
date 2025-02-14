<script setup>
import { ref, onMounted, watch } from "vue";

const data = defineProps({
    sellos: {
        type: Array,
        required: false,
        default: () => [] 
    },
})
const seals = ref([]); 
const selectedSeals = ref([]);  

const emit = defineEmits(['selectedSeals'])
onMounted(() => {
    fetchSeals();
    if (data.sellos.length > 0) {
        selectedSeals.value = data.sellos;
    }
});

const fetchSeals = async () => {
    try {
        const response = await axios.get("/fetch/seals");
        seals.value = response.data;  
    } catch (error) {
        alert("No se pudo cargar los sellos: " + error);
    }
};

const emitSelectedSeals = () => {
    emit("selectedSeals", selectedSeals.value);
};

</script>

<template>
    <div class="flex gap-4 flex-wrap"> 
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
