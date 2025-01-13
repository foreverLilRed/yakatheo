<template>
    <button @click="modalStatus = true" class="btn btn-warning btn-xs">
        {{ data.sale.documento ? 'Reemplazar documento' : 'Subir documento' }}
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="3xl">
        <template #title>Subir documento</template>
        <template #content>
            <div v-if="data.sale.documento" class="alert alert-outline alert-warning flex items-center my-4" role="alert">
                <p><span class="text-lg font-semibold">Alerta:</span> Ya existe un documento previo, si subes otro el
                    anterior sera sobreescrito (eliminado)
                </p>
            </div>
            <form @submit.prevent="submitDocument" enctype="multipart/form-data">
                <input type="file" id="document" required accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                    @change="handleFileUpload"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none" />
                <InputError :message="form.errors.document" class="mt-2" />
                <div class="mt-4">
                    <SaveButton :disabled="form.processing">Subir</SaveButton>
                </div>
            </form>
        </template>
    </DialogModal>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import DialogModal from './DialogModal.vue';
import InputError from './InputError.vue';
import SaveButton from './SaveButton.vue';

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const data = defineProps({
    sale: Object,
})

const form = useForm({
    document: null,
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    form.document = file;
};

const submitDocument = () => {
    const formData = new FormData();
    formData.append('document', form.document);

    router.post(`/sales/${data.sale.id}/document/upload`, formData, {
        onSuccess: () => {
            form.reset();
            closeModal();
        },
    });
};

</script>
