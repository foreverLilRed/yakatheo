<template>
    <button @click="modalStatus = true" class="btn btn-success">
        Descargar reporte
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="2xl">
        <template #title>Descargar reporte de personas</template>
        <template #content>

                <CommunitySelector @emitcommunity="handleCommunityChange" />
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 my-4">
                    <div class="w-full">
                        <label class="label label-text">Minima fecha de nacimiento</label>
                        <input v-model="form.min_birthday" type="date" placeholder="John Doe" class="input" />
                    </div>
                    <div class="w-full">
                        <label class="label label-text">Minimo de certificaciones</label>
                        <input v-model="form.min_certifications" type="number" step="1" placeholder="0" class="input" />
                    </div>
                    <div class="w-full">
                        <label class="label label-text">Minimo de terrenos</label>
                        <input v-model="form.min_lands" type="number" step="1" placeholder="0" class="input" />
                    </div>
                </div>
                <button @click="downloadExcel" class="btn btn-success btn-gradient btn-block">Descargar</button>

        </template>
    </DialogModal>
</template>
<script setup>
import CommunitySelector from './CommunitySelector.vue';
import DialogModal from './DialogModal.vue';
import { ref } from 'vue';

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};


const form = ref({
    community_id: '',
    min_birthday: '',
    min_certifications: '',
    min_lands: '',
})

async function downloadExcel() {
    console.log('si')
    try {
        const response = await axios({
            url: "/reports/productors",
            method: "GET",
            responseType: "blob",
            params: {
                birthday: form.value.min_birthday,
                community: form.value.community_id,
                certifications: form.value.min_certifications,
                terrains: form.value.min_lands,
            },
        });

        const url = window.URL.createObjectURL(new Blob([response.data]));
        console.log(url);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "productores.xlsx");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error("Error al descargar el archivo Excel:", error);
        alert("Hubo un problema al generar el archivo Excel.");
    }
}

function handleCommunityChange(community) {
    form.community_id = community
}
</script>