<template>
    <div class="mb-2 relative">
        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ props.label }}</label>
        <div class="relative">
            <input v-model="searchQuery" v-if="!itemSelected" :placeholder="props.placeholder"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pr-10"
                @focus="dropdownVisible = true" />

            <button v-if="!itemSelected && dropdownVisible" @click="searchQuery = ''; dropdownVisible = false;"
                class="absolute right-2 top-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <select v-if="itemSelected" v-model="selectedItemId" @change="handleItemChange(selectedItemId)"
                @dblclick="resetItemSelection"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option disabled value="">Seleccione un Item</option>
                <option v-for="item in items" :key="item.id" :value="item.id">
                    {{ item.name }}
                </option>
            </select>

            <ul v-if="dropdownVisible"
                class="absolute w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg shadow-lg max-h-40 overflow-auto z-10">
                <li v-for="item in filteredItems" :key="item.id" @click="selectItem(item)"
                    class="p-2 cursor-pointer hover:bg-gray-100">
                    {{ item.name }}
                </li>
                <li v-if="filteredItems.length === 0" class="p-2 text-gray-500">
                    No se encontraron items
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, watch, defineProps, defineEmits } from 'vue';

const props = defineProps({
    items: Array,
    placeholder: String,
    label: String
});

const searchQuery = ref('');
const itemSelected = ref(false);
const dropdownVisible = ref(false);
const selectedItemId = ref('');

const filteredItems = computed(() => {
    if (!searchQuery.value) {
        return props.items;
    }
    return props.items.filter((item) =>
        item.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const emit = defineEmits(['item-selected']);

watch(searchQuery, (newValue) => {
    if (!newValue) {
        resetItemSelection(); 
        emit('item-selected', ''); 
    }
});

function handleItemChange(id) {
    const item = props.items.find((item) => item.id == id);
    selectItem(item);
}

function selectItem(item) {
    searchQuery.value = item.name;
    itemSelected.value = true;
    dropdownVisible.value = false;
    selectedItemId.value = item.id;
    emitItem(item);
}

function resetItemSelection() {
    itemSelected.value = false;
    searchQuery.value = '';
    selectedItemId.value = ''; 
    dropdownVisible.value = true;
    emitItem(''); 
}

function emitItem(item) {
    emit('item-selected', item);
}
</script>