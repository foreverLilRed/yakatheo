<script setup>
import { computed } from 'vue';


const props = defineProps({
    sales: Array,
});

const grandTotal = computed(() => {
    return props.sales.reduce((sum, sale) => sum + sale.total, 0);
});

const totalWeight = computed(() => {
    return props.sales.reduce((sum, sale) => sum +  parseFloat(sale.weight), 0);
});
</script>

<template>
    <div class="border-base-content/25 w-full rounded-lg border">
        <div class="overflow-x-auto">
            <table class="table rounded">
                <thead>
                    <tr>
                        <th>ID de la Venta</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Comprador</th>
                        <th>Numero de Documento</th>
                        <th>Peso (Kg)</th>
                        <th>Precio Unitario (S/)</th>
                        <th>Total (S/)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales" :key="sale.id">
                        <td class="text-nowrap">{{ sale.id }}</td>
                        <td>{{ sale.fecha }}</td>
                        <td>{{ sale.product.name }}</td>
                        <td>{{ sale.buyer.name }}</td>
                        <td>{{ sale.document_number }}</td>
                        <td>{{ sale.weight }}</td>
                        <td>{{ sale.unit_price }}</td>
                        <td>{{ sale.total }}</td>
                        <td>
                            <a :href="`/documents/procurement/${sale.id}`"
                                class="text-sm text-gray-600 font-thin hover:underline">Ver documento</a>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ totalWeight }}</td>
                        <td></td>
                        <td>{{ grandTotal }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
