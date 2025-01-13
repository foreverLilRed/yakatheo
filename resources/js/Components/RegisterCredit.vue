<script setup>
import { onMounted, ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";
import axios from "axios";
import SealsSelector from "./SealsSelector.vue";
import CommunitySelector from "./CommunitySelector.vue";
import InstitutionSelector from "./InstitutionSelector.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const form = useForm({
    institution_id: "",
    credit: "",
    interest_rate: "",
    total_amount: "",
    remaining_balance: "",
    loan_date: "",
    due_date: '',
    status: '',
    currency: '',
    purpose: '',
});

const validateField = (field, event) => {
    let value = event.target.value;

    const regex = /^\d*(\.\d{0,2})?$/;

    if (!regex.test(value)) {
        value = value.slice(0, -1);
    }

    form[field] = value;
};

function registerInstitution() {
    form.post(route("credits-store"), {
        onSuccess: () => {
            form.reset();
            modalStatus.value = false;
        },
    });
}

function handleInstitutionSelect(institution) {
    form.institution_id = institution.id;
}

watch(
    [() => form.credit, () => form.interest_rate],
    ([newCredit, newInterestRate]) => {
        if (newCredit && newInterestRate) {
            form.total_amount = parseFloat(newCredit) * parseFloat(newInterestRate);
        } else {
            form.total_amount = "";
        }
    }
);

</script>

<template>
    <button @click="modalStatus = true" class="btn btn-primary">
        Registrar Credito
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="3xl">
        <template #title>Registrar Credito</template>

        <template #content>
            <form @submit.prevent="registerInstitution">
                <div class="mb-5 grid grid-cols-1 md:grid-cols-3 items-center gap-4">
                    <div class="mx-auto">
                        <label
                            for="institution"
                            class="block mb-2 text-sm font-medium"
                            >Institucion</label
                        >
                        <InstitutionSelector @emit-institution="handleInstitutionSelect" id="institution" />
                        <InputError :message="form.errors.institution_id" class="mt-2" />
                    </div>
                    <div>
                        <label for="credit" class="block mb-2 text-sm font-medium"
                            >Credito</label
                        >
                        <input
                            v-model="form.credit"
                            @input="validateField('credit', $event)"
                            type="number"
                            step="0.01"
                            id="credit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Credito"
                        />
                        <InputError :message="form.errors.credit" class="mt-2" />
                    </div>
                    <div>
                        <label
                            for="interest_rate"
                            class="block mb-2 text-sm font-medium"
                            >Interes</label
                        >
                        <input
                            v-model="form.interest_rate"
                            @input="validateField('interest_rate', $event)"
                            type="number"
                            id="interest_rate"
                            step="0.01"
                            placeholder="Interes"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <InputError
                            :message="form.errors.interest_rate"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <label
                            for="total_amount"
                            class="block mb-2 text-sm font-medium"
                            >Monto total</label
                        >
                        <input
                            v-model="form.total_amount"
                            @input="validateField('total_amount', $event)"
                            type="number"
                            step="0.001"
                            id="total_amount"
                            placeholder="Interes"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <InputError
                            :message="form.errors.total_amount"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <label
                            for="total_amount"
                            class="block mb-2 text-sm font-medium"
                            >Fecha de Prestamo</label
                        >
                        <input
                            v-model="form.loan_date"
                            type="date"
                            id="loan_date"
                            placeholder="Vencimiento"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <InputError
                            :message="form.errors.loan_date"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <label
                            for="total_amount"
                            class="block mb-2 text-sm font-medium"
                            >Fecha de Vencimiento</label
                        >
                        <input
                            v-model="form.due_date"
                            type="date"
                            id="due_date"
                            placeholder="Vencimiento"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <InputError
                            :message="form.errors.due_date"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-3">
                        <label
                            for="total_amount"
                            class="block mb-2 text-sm font-medium"
                            >Proposito (Opcional)</label
                        >
                        <textarea
                            v-model="form.purpose"
                            id="purpose"
                            style="resize: none;"
                            placeholder="Razon del prestamo"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <InputError
                            :message="form.errors.purpose"
                            class="mt-2"
                        />
                    </div>
                </div>

                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
