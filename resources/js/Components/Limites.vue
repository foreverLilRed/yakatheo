<template>
    <div class="flex flex-col gap-4">
        <form @submit.prevent="actualizarLimites">
            <div class="grid grid-cols-2 gap-3">
                <div v-for="limite in form.limites" :key="limite.id" class="w-full">
                    <label class="label label-text" :for="`limite-${limite.id}`">{{ limite.nombre }}</label>
                    <input v-model.number="limite.limite" type="number" class="input" :id="`limite-${limite.id}`" />
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-sm mt-3 btn-block">Guardar límites nuevos</button>
        </form>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    productor: String,
    limites: Array
});

const form = reactive({
    limites: props.limites
});

async function actualizarLimites() {
    const data = form.limites.map(limite => ({
        productor_id: props.productor,
        product_id: limite.id,
        limit: limite.limite
    }));

    axios.post(`/productors/actualizar-limites/${props.productor}`, { limites: data })
        .then(response => {
            alert(response.data.message); 
        })
        .catch(error => {
            console.error("Ocurrió un error al actualizar los límites:", error);
            alert("Ocurrió un error al actualizar los límites.");
        });
}

</script>
