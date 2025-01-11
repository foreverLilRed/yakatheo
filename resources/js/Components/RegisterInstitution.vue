<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const form = useForm({
    name: ""
});

function registerProduct() {
    form.post(route("institution-store"), {
        onSuccess: () => {
            form.reset();
            modalStatus.value = false;
        },
    });
}

</script>

<template>
    <button @click="modalStatus = true" class="btn btn-secondary">
        Registrar Institucion Financiera
    </button>
    <DialogModal :show="modalStatus" @close="closeModal">
        <template #title>Registrar Institucion Financiera</template>

        <template #content>
            <form @submit.prevent="registerProduct">
                <div class="mb-5">
                    <label for="names" class="block mb-2 text-sm font-medium"
                        >Nombre</label
                    >
                    <input
                        v-model="form.name"
                        type="text"
                        id="names"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombres"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
