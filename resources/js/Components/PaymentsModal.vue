<template>
    <button @click="modalStatus = true" class="btn btn-primary btn-xs">
        Historial de pagos
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="sm">
        <template #title>Historial de pagos</template>
        <template #content>
            <div v-if="credit.pagos.length > 0">
                <div class="w-full overflow-x-auto">
                    <table class="table-xs table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pago in credit.pagos" :key="pago.id">
                                <th>{{ pago.id }}</th>
                                <td>{{ pago.amount }}</td>
                                <td>{{ pago.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else>
                Este credito aun no registra pagos
            </div>
        </template>
    </DialogModal>
</template>
<script setup>
import { ref } from 'vue';
import DialogModal from './DialogModal.vue';

const data = defineProps({
    credit: Object,
});

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

</script>