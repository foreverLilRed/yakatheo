<template>
    <button @click="modalStatus = true" class="btn btn-primary btn-xs">
        Ver
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="3xl">
        <template #title>Informacion de {{ productor.nombres }}</template>
        <template #content>
            <div class="grid grid-cols-2">
                <div>
                    <p><strong>Nombres:</strong> {{ productor.nombres }}</p>
                    <p><strong>Apellidos:</strong> {{ productor.apellidos }}</p>
                    <p><strong>DNI:</strong> {{ productor.dni }}</p>
                    <p><strong>Fecha de nacimiento:</strong> {{ productor.nacimiento }}</p>
                    <p><strong>Certificaciones:</strong> {{ productor.info.certificaciones.join(', ') }}</p>
                    <p><strong>Terrenos:</strong> {{ productor.tierras ? productor.tierras : 0 }}</p>
                </div>
                <div>
                    Otra nota
                </div>
            </div>
        </template>
    </DialogModal>
</template>
<script setup>
import { ref } from 'vue';
import DialogModal from './DialogModal.vue';

const data = defineProps({
    productor: Object
})

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};
</script>