<script setup>
import { computed } from 'vue';

const props = defineProps({
  products: Array
})

const calculatedTotal = computed(() => {
  return props.products.reduce((acc, product) => acc + product.stock, 0);
});
</script>

<template>
  <div class="w-full overflow-x-auto">
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3 rounded-s-lg">
              Nombres
            </th>
            <th scope="col" class="px-6 py-3 rounded-e-lg">
              Stock
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in props.products" :key="product.id" class="bg-white dark:bg-gray-800">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ product.nombres }}
            </th>
            <td class="px-6 py-4">
              {{ product.stock }} Kg
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="font-semibold text-gray-900 dark:text-white">
            <th scope="row" class="px-6 py-3 text-base">Total</th>
            <td class="px-6 py-3">{{ calculatedTotal }} Kg</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>
