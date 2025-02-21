<template>
    <form @submit.prevent="updateProductor" class="needs-validation peer grid gap-y-4">
        <div class="w-full">
            <h6 class="text-lg font-semibold">1. Informacion personal</h6>
            <hr class="mb-4 mt-2" />
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label label-text" for="names">Nombres</label>
                <input v-model="form.names" id="names" type="text" placeholder="Nombres..." class="input" required />
                <InputError :message="form.errors.names" class="mt-2" />
            </div>
            <div>
                <label class="label label-text" for="surnames">Apellidos</label>
                <input v-model="form.surnames" id="surnames" type="text" placeholder="Apellidos" class="input" />
                <InputError :message="form.errors.surnames" class="mt-2" />
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label label-text" for="birthday">Nacimiento</label>
                <input v-model="form.birthday" id="birthday" type="date" class="input" />
                <InputError :message="form.errors.birthday" class="mt-2" />
            </div>
            <div>
                <label class="label label-text" for="dni">DNI</label>
                <input v-model="form.dni" id="dni" type="text" placeholder="DNI" class="input" />
                <InputError :message="form.errors.dni" class="mt-2" />
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="label label-text">Comunidad</label>
            <CommunitySelector
                    :comunidad="comunidad"
                    @emitcommunity="handleCommunitySelect"/>
            </div>
        </div>
        <div class="w-full">
            <h6 class="text-lg font-semibold">2. Sellos</h6>
            <hr class="mb-4 mt-2" />
        </div>
        <SealsSelector
                :sellos="props.sellos"
                @selectedSeals="handleSelectedSeals"
        ></SealsSelector>
        <div class="w-full">
            <h6 class="text-lg font-semibold">3. Normas</h6>
            <hr class="mb-4 mt-2" />
        </div>
        <NormasSelector
                :normas="props.normas"
                @selectedNormas="handleSelectedNormas"
        ></NormasSelector>
        <div class="w-full">
            <h6 class="text-lg font-semibold">4. Condiciones</h6>
            <hr class="mb-4 mt-2" />
        </div>
        <CondicionesSelector
                :condiciones="props.condiciones"
                @selectedCondiciones="handleSelectedCondiciones"
        ></CondicionesSelector>
        <div class="w-full">
            <h6 class="text-lg font-semibold">5. Organizacion</h6>
            <hr class="mb-4 mt-2" />
        </div>
        <div>
            <div class="flex items-center gap-3">
                <input v-model="form.socio" type="checkbox" class="checkbox checkbox-primary" id="socio" />
                <label class="label text-base" for="socio">Socio</label>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-block btn-primary">Guardar</button>
        </div>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from './InputError.vue';
import SealsSelector from './SealsSelector.vue';
import CommunitySelector from './CommunitySelector.vue';
import { onMounted } from 'vue';
import NormasSelector from './NormasSelector.vue';
import CondicionesSelector from './CondicionesSelector.vue';

const props = defineProps({
    data: Object,
    sellos: Array,
    normas: Array,
    condiciones: Array,
    comunidad: Object,
})

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
}

const form = useForm({
    names: props.data?.names ?? '',
    surnames: props.data?.surnames ?? '',
    dni: props.data?.dni ?? '',
    birthday: props.data?.birthday ?? '',
    socio: props.data?.socio ?? '',
    community_id: props.comunidad?.id ?? '',
    seal: props.sellos ?? [],
    normas: props.normas ?? [],
    condiciones: props.condiciones ?? []
})

function updateProductor() {
    form.put(`/productors/${props.data.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Productor actualizado');
        }
    });
}
</script>