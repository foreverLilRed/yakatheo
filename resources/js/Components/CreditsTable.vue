<script setup>
import { computed } from 'vue';
import PaymentsModal from './PaymentsModal.vue';
import RegisterPayment from './RegisterPayment.vue';


const props = defineProps({
    credits: Array,
});

</script>

<template>
    <div class="border-base-content/25 w-full rounded-lg border">
        <div class="overflow-x-auto">
            <table class="table rounded">
                <thead>
                    <tr>
                        <th>ID del credito</th>
                        <th>Institucion</th>
                        <th>Credito</th>
                        <th>Tasa de Interes</th>
                        <th>Monto Total</th>
                        <th>Saldo Restante</th>
                        <th>Fecha del prestamo</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="credit in credits" :key="credit.id">
                        <td class="text-nowrap">{{ credit.id }}</td>
                        <td class="text-nowrap">{{ credit.institucion }}</td>
                        <td class="text-nowrap">{{ credit.credito }}</td>
                        <td class="text-nowrap">{{ credit.tasa_interes }}</td>
                        <td class="text-nowrap">{{ credit.monto_total }}</td>
                        <td class="text-nowrap">{{ credit.saldo_restante }}</td>
                        <td class="text-nowrap">{{ credit.fecha_prestamo }}</td>
                        <td class="text-nowrap">{{ credit.fecha_vencimiento }}</td>
                        <td class="text-nowrap">{{ credit.estado }}</td>
                        <td class="flex items-center gap-x-2">
                            <RegisterPayment :credit="credit" :key="credit.id"/>
                            <PaymentsModal :credit="credit" :key="credit.id"/>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
