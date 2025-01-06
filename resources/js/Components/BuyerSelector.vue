<template>
    <div ref="dropdownContainer" class="relative">
        <button
            data-dropdown-placement="bottom"
            class="btn btn-soft btn-primary btn-block"
            type="button"
            @click="toggleDropdown"
        >
            {{ selectedBuyer ? `${selectedBuyer.nombres}` : "Seleccionar Comprador" }}
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
            id="dropdownSearchBuyer"
            v-show="isDropdownVisible"
            class="relative z-10 overflow-visible bg-white rounded-lg shadow w-60 dark:bg-gray-700"
        >
            <div class="p-3">
                <label for="input-group-search-buyer" class="sr-only">Search</label>
                <div class="relative">
                    <input
                        type="text"
                        id="input-group-search-buyer"
                        v-model="search"
                        @input="searchBuyers()"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Buscar buyer"
                    />
                </div>
            </div>
            <ul
                class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchBuyerButton"
            >
                <li v-for="buyer in buyers.data" :key="buyer.id">
                    <div
                        @click="selectBuyer(buyer)"
                        class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600 hover:cursor-pointer"
                    >
                        <p
                            class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                        >
                            <span class="font-bold">{{ buyer.id }} - </span>
                            {{ buyer.nombres }}
                        </p>
                    </div>
                </li>
            </ul>
            <!--
            <PaginatorEscape class="m-2" :links="buyers.links" @page-change="searchBuyers"></PaginatorEscape>
            -->
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, onBeforeUnmount, defineEmits } from "vue";
import PaginatorEscape from "./PaginatorEscape.vue";

const emit = defineEmits(["emitBuyer"]);

const buyers = ref({
    data: [],
    links: [],
});
const search = ref("");
const isDropdownVisible = ref(false);
const selectedBuyer = ref(null); 
const dropdownContainer = ref(null);

const toggleDropdown = () => {
    isDropdownVisible.value = !isDropdownVisible.value;
};

const closeDropdown = (event) => {
    if (dropdownContainer.value && !dropdownContainer.value.contains(event.target)) {
        isDropdownVisible.value = false;
    }
};

const searchBuyers = async (url = "/buyers/fetch-query") => {
    if (typeof url !== "string") {
        console.error("Invalid URL passed to searchBuyers:", url);
        url = "/buyers/fetch-query"; 
    }

    try {
        const response = await axios.get(url, {
            params: { search: search.value },
        });
        buyers.value = response.data;
    } catch (error) {
        console.error("Error fetching buyers:", error);
    }
};

const selectBuyer = (buyer) => {
    selectedBuyer.value = buyer; 
    emit("emitBuyer", buyer);
    isDropdownVisible.value = false;
};

onMounted(() => {
    document.addEventListener("click", closeDropdown);
    searchBuyers();
});

onBeforeUnmount(() => {
    document.removeEventListener("click", closeDropdown);
});
</script>