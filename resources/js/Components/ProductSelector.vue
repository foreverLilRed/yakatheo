<template>
    <div ref="dropdownContainer" class="relative">
        <button
            data-dropdown-placement="bottom"
            class="btn btn-soft btn-accent btn-block"
            type="button"
            @click="toggleDropdown"
        >
            {{ selectedProduct ? `${selectedProduct.nombres}` : "Seleccionar producto" }}
            <svg
                class="w-2.5 h-2.5 ms-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 10 6"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4"
                />
            </svg>
        </button>

        <div
            id="dropdownSearch"
            v-show="isDropdownVisible"
            class="relative z-10 overflow-visible bg-white rounded-lg shadow w-60 dark:bg-gray-700"
        >
            <div class="p-3">
                <label for="input-group-search" class="sr-only">Search</label>
                <div class="relative">
                    <input
                        type="text"
                        id="input-group-search"
                        v-model="search"
                        @input="searchProducts()"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Buscar product"
                    />
                </div>
            </div>
            <ul
                class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton"
            >
                <li v-for="product in products.data" :key="product.id">
                    <div
                        @click="selectProductor(product)"
                        class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600 hover:cursor-pointer"
                    >
                        <p
                            class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                        >
                            <span class="font-bold">{{ product.id }} - </span>
                            {{ product.nombres }}
                        </p>
                    </div>
                </li>
            </ul>
            <!--
            <PaginatorEscape class="m-2" :links="products.links" @page-change="searchProducts"></PaginatorEscape>
            -->
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, onBeforeUnmount, defineEmits } from "vue";
import PaginatorEscape from "./PaginatorEscape.vue";

const emit = defineEmits(["emitProductor"]);

const products = ref({
    data: [],
    links: [],
});
const search = ref("");
const isDropdownVisible = ref(false);
const selectedProduct = ref(null); 
const dropdownContainer = ref(null);

const toggleDropdown = () => {
    isDropdownVisible.value = !isDropdownVisible.value;
};

const closeDropdown = (event) => {
    if (dropdownContainer.value && !dropdownContainer.value.contains(event.target)) {
        isDropdownVisible.value = false;
    }
};

const searchProducts = async (url = "/products/fetch-query") => {
    if (typeof url !== "string") {
        console.error("Invalid URL passed to searchProducts:", url);
        url = "/products/fetch-query"; 
    }

    try {
        const response = await axios.get(url, {
            params: { search: search.value },
        });
        products.value = response.data;
    } catch (error) {
        console.error("Error fetching products:", error);
    }
};

const selectProductor = (product) => {
    selectedProduct.value = product; 
    emit("emitProductor", product);
    isDropdownVisible.value = false;
};

onMounted(() => {
    document.addEventListener("click", closeDropdown);
    searchProducts();
});

onBeforeUnmount(() => {
    document.removeEventListener("click", closeDropdown);
});
</script>