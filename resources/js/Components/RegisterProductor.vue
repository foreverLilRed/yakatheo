<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";
import axios from "axios";
import SealsSelector from "./SealsSelector.vue";
import CommunitySelector from "./CommunitySelector.vue";
import NormasSelector from "./NormasSelector.vue";
import CondicionesSelector from "./CondicionesSelector.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const form = useForm({
    names: "",
    surnames: "",
    dni: "",
    birthday: "",
    seal: "",
    normas: "",
    condiciones: "",
    community_id: "",
});

const seals = ref([]);

function registerProductor() {
    form.post(route("productors-store"), {
        onSuccess: () => {
            form.reset();
            modalStatus.value = false;
        },
    });
}

function handleSelectedSeals(selectedSeals) {
    form.seal = selectedSeals;
}

function handleSelectedNormas(selectedNormas){
    form.normas = selectedNormas
}

function handleSelectedCondiciones(selectedCondiciones){
    form.condiciones = selectedCondiciones
}

function handleCommunitySelect(community) {
    form.community_id = community.id;
    console.log(form.community_id);
}
</script>

<template>
    <button @click="modalStatus = true" class="btn btn-primary">
        Registrar productor
    </button>
    <DialogModal :show="modalStatus" @close="closeModal">
        <template #title>Registrar Productor</template>

        <template #content>
            <form @submit.prevent="registerProductor">
                <div class="mb-5">
                    <label for="names" class="block mb-2 text-sm font-medium"
                        >Nombres</label
                    >
                    <input
                        v-model="form.names"
                        type="text"
                        id="names"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombres"
                    />
                    <InputError :message="form.errors.names" class="mt-2" />
                </div>

                <div class="mb-5">
                    <label for="surnames" class="block mb-2 text-sm font-medium"
                        >Apellidos</label
                    >
                    <input
                        v-model="form.surnames"
                        type="text"
                        id="surnames"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Apellidos"
                    />
                    <InputError :message="form.errors.surnames" class="mt-2" />
                </div>

                <div class="mb-5 grid grid-cols-1 md:grid-cols-3 items-center gap-x-3">
                    <div>
                        <label
                            for="community"
                            class="block mb-2 text-sm font-medium"
                            >Comunidad</label
                        >
                        <CommunitySelector @emitcommunity="handleCommunitySelect" id="community" />
                    </div>
                    <div>
                        <label for="dni" class="block mb-2 text-sm font-medium"
                            >DNI</label
                        >
                        <input
                            v-model="form.dni"
                            type="text"
                            id="dni"
                            minlength="8"
                            maxlength="8"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="DNI"
                        />
                        <InputError :message="form.errors.dni" class="mt-2" />
                    </div>
                    <div>
                        <label
                            for="birthday"
                            class="block mb-2 text-sm font-medium"
                            >Fecha de Nacimiento</label
                        >
                        <input
                            v-model="form.birthday"
                            type="date"
                            id="birthday"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <InputError
                            :message="form.errors.birthday"
                            class="mt-2"
                        />
                    </div>
                </div>

                <div class="mb-5">
                    <p class="block mb-2 text-sm font-medium">
                        Certificaciones
                    </p>
                    <SealsSelector
                        @selectedSeals="handleSelectedSeals"
                    ></SealsSelector>
                </div>

                <div class="mb-5">
                    <p class="block mb-2 text-sm font-medium">
                        Normas
                    </p>
                    <NormasSelector
                        @selectedNormas="handleSelectedNormas"
                    ></NormasSelector>
                </div>

                <div class="mb-5">
                    <p class="block mb-2 text-sm font-medium">
                        Condiciones
                    </p>
                    <CondicionesSelector
                        @selectedCondiciones="handleSelectedCondiciones"
                    ></CondicionesSelector>
                </div>

                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
