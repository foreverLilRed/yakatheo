<script setup>
import { computed } from "vue";

const props = defineProps({
    procurements: Array,
});

const procurementsWithTotal = computed(() =>
    props.procurements.map((procurement) => ({
        ...procurement,
        total: procurement.weight * procurement.unit_price,
    }))
);
</script>

<template>
    <div class="border-base-content/25 w-full rounded-lg border">
        <div class="overflow-x-auto">
            <table class="table rounded">
                <thead>
                    <tr>
                        <th>ID de Compra</th>
                        <th>Producto</th>
                        <th>Socio</th>
                        <th>Comunidad</th>
                        <th>Cantidad (Kg)</th>
                        <th>Precio Unitario (S/)</th>
                        <th>Total (S/)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="procurement in procurementsWithTotal"
                        :key="procurement.id"
                    >
                        <td class="text-nowrap">{{procurement.id}}</td>
                        <td>{{procurement.product.name}}</td>
                        <td>{{procurement.productor.names}}</td>
                        <td>{{procurement.productor.community.name}}</td>
                        <td>{{procurement.weight}}</td>
                        <td>{{procurement.unit_price}}</td>
                        <td>{{procurement.total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
