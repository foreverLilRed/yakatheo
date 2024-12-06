<script setup>
const data = defineProps({
    productors: Array
})
</script>

<template>
  <div class="w-full overflow-x-auto">
    <table class="table-xs table">
      <thead>
        <tr>
          <th v-for="(value, key) in data.productors[0]" :key="key">{{ key }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="productor in data.productors" :key="productor.id">
          <td v-for="(value, key) in productor" :key="key">{{ value }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
