<template>
    <AppLayout>
        {{limites}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-base-100 w-full rounded-lg shadow">
                <h5 class="bg-base-300 rounded-t-lg p-4 text-base font-bold">{{ data.names }} {{ data.surnames }}</h5>
                <div class="w-full p-4">
                    <UpdateProductorForm :data="data" :sellos="sellos" :condiciones="condiciones" :normas="normas" :comunidad="comunidad" />
                </div>
            </div>
            <div>
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <h1 class="text-base-content text-2xl">Tierras</h1>
                        <RegisterTerrain :productor="data" :with-search="false"></RegisterTerrain>
                    </div>
                    <h1 v-if="tierras.length == 0" class="text-center">
                        No hay terrenos registrados.
                    </h1>
                    <div v-else class="border-base-content/25 w-full rounded-lg border">
                        <div class="overflow-x-auto">

                            <table class="table rounded">
                                <thead>
                                    <tr>
                                        <th>Lugar</th>
                                        <th>Total</th>
                                        <th>Produccion</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="terrain in tierras" :key="terrain.id">
                                        <td class="text-nowrap">{{ terrain.place }}</td>
                                        <td>{{ terrain.hr_total }}</td>
                                        <td>{{ terrain.hr_prod }}</td>
                                        <!--
                                        <td><span class="badge badge-soft badge-success text-xs">Professional</span>
                                        </td>
                                        <td class="text-nowrap">March 1, 2024</td>
                                        -->
                                        
                                        <td>
                                            <button @click="deleteTerrain(terrain.id)"
                                                class="btn btn-circle btn-text btn-sm" aria-label="Action button"><span
                                                    class="icon-[tabler--trash] size-5"></span></button>
                                            <button class="btn btn-circle btn-text btn-sm"
                                                aria-label="Action button"><span
                                                    class="icon-[tabler--dots-vertical] size-5"></span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center gap-4 mb-4">
                        <h1 class="text-base-content text-2xl">Acopios</h1>
                    </div>
                    <h1 v-if="acopios.length == 0" class="text-center">Sin acopios registrado</h1>
                    <div v-else class="flex flex-col gap-4">
                        <div v-for="acopio in acopios" :key="acopio.id">
                            <AreaChart :titulo="acopio.nombre" nameSeries="KG" :labels="acopio.fechas"
                                :data="acopio.totales" />
                        </div>
                    </div>

                </div>
                <Limites :productor="data.id" :limites="limites"></Limites>
            </div>
        </div>
    </AppLayout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateProductorForm from '@/Components/UpdateProductorForm.vue';
import RegisterTerrain from '@/Components/RegisterTerrain.vue';
import AreaChart from '@/Components/AreaChart.vue';
import Limites from '@/Components/Limites.vue';

export default {
    components: {
        AppLayout, UpdateProductorForm, RegisterTerrain, AreaChart, Limites
    },
    props: {
        data: Object,
        comunidad: Object,
        tierras: Object,
        sellos: Object,
        normas: Object,
        condiciones: Object,
        acopios: Object,
        limites: Object
    },
    methods: {
        deleteTerrain(id) {
            if (confirm('¿Estas seguro de eliminar este terreno?')) {
                this.$inertia.delete(`/terrains/${id}`, {
                    onSuccess: () => {
                        this.$emit('refresh');
                    },
                    onError(error) {
                        alert(error);
                    }
                });
            }
        }
    }
}
</script>