<script setup>
import RegisterTerrain from './RegisterTerrain.vue';

const data = defineProps({
    productors: Array
})
</script>

<template>
  <div class="w-full overflow-x-auto">
    <table class="table-xs table">
      <thead>
        <tr>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>DNI</th>
          <th>Nacimiento</th>
          <th>Certificaciones</th>
          <th>Terrenos</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-200" v-for="productor in data.productors" :key="productor.id">
          <td>{{ productor.nombres }}</td>
          <td>{{ productor.apellidos }}</td>
          <td>{{ productor.dni }}</td>
          <td>{{ productor.nacimiento }}</td>
          <td>{{ productor.certificaciones }}</td>
          <td>{{ productor.tierras ? productor.tierras : 0}}</td>
          <td><RegisterTerrain :productor="productor"/></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
