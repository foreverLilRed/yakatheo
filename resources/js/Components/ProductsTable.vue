<script setup>

const data = defineProps({
    products: Array
})
</script>

<template>
  <div class="w-full overflow-x-auto">
    <table class="table-xs table">
      <thead>
        <tr>
          <th>Nombre</th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-200" v-for="product in data.products" :key="product.id">
          <td>{{ product.nombres }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
