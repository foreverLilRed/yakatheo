<template>
    <button :disabled="data.credit.saldo_restante == 0" @click="modalStatus = true" class="btn btn-success btn-xs">
        Registrar pago
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="sm">
        <template #title>Registrar pago</template>
        <template #content>
            <p class="my-2 text-center font-thin text-base">
                Saldo restante: {{ saldo_formateado }}
            </p>
            <form @submit.prevent="registerPay">
                <div>
                    <label for="amount" class="block mb-2 text-sm font-medium">Monto a Pagar</label>
                    <input v-model="form.amount" type="number" step="0.001" id="amount" placeholder="Monto"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <InputError :message="form.errors.amount" class="mt-2" />
                </div>
                <SaveButton :disabled="form.processing" class="mt-4">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>

<script setup>
import { onMounted, ref, watch, computed } from "vue";
import DialogModal from "./DialogModal.vue";
import { useForm } from "@inertiajs/vue3";
import SaveButton from "./SaveButton.vue";
import InputError from "./InputError.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const saldo_restante = ref(0);
const original_saldo_restante = ref(0);

onMounted(() => {
    const initialSaldo = parseFloat(data.credit.saldo_restante) || 0; 
    saldo_restante.value = initialSaldo;
    original_saldo_restante.value = initialSaldo;
});

const data = defineProps({
    credit: Object,
});

const form = useForm({
    credit_id: data.credit.id,
    amount: ''
});

function registerPay() {
    form.post('/payments/store', {
        onSuccess: () => {
            form.reset();
            closeModal();
        }
    });
}

watch(() => form.amount, (newAmount) => {
    const amount = parseFloat(newAmount) || 0; 

    if (!newAmount) {
        saldo_restante.value = original_saldo_restante.value;
        form.errors.amount = '';
    } else if (amount > original_saldo_restante.value) {
        form.errors.amount = 'El monto no puede ser mayor al saldo restante';
    } else {
        saldo_restante.value = parseFloat((original_saldo_restante.value - amount).toFixed(2));
        form.errors.amount = '';
    }
});

const saldo_formateado = computed(() => {
    return typeof saldo_restante.value === "number"
        ? saldo_restante.value.toFixed(2)
        : "0.00"; 
});
</script>

