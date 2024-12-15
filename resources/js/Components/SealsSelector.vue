<script setup>
import { ref, onMounted, watch } from "vue";

const seals = ref([]); 
const selectedSeals = ref([]);  

const emit = defineEmits(['selectedSeals'])
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
