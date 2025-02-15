<template>
    <div ref="dropdownContainer" class="relative">
        <button
            data-dropdown-placement="bottom"
            class="btn btn-block btn-soft btn-accent"
            type="button"
            @click="toggleDropdown"
        >
            {{ selectedcommunity ? `${selectedcommunity.name}` : "Seleccionar" }}
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
            class="z-10 bg-white rounded-lg shadow mt-2 w-full dark:bg-gray-700"
        >
            <div class="p-3">
                <label for="input-group-search" class="sr-only">Search</label>
                <div class="relative">
                    <input
                        type="text"
                        id="input-group-search"
                        v-model="search"
                        @input="searchcommunitys()"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Buscar Comunidad"
                    />
                </div>
            </div>
            <ul
                class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton"
            >
                <li v-for="community in communitys.data" :key="community.id">
                    <div
                        @click="selectcommunity(community)"
                        class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600 hover:cursor-pointer"
                    >
                        <p
                            class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                        >
                            <span class="font-bold">{{ community.id }} - </span>
                            {{ community.name }}
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, onBeforeUnmount, defineEmits } from "vue";
import PaginatorEscape from "./PaginatorEscape.vue";

const data = defineProps({
    comunidad: { type: Object, required: false, default: null },
});

const emit = defineEmits(["emitcommunity"]);

const communitys = ref({
    data: [],
    links: [],
});
const search = ref("");
const isDropdownVisible = ref(false);
const selectedcommunity = ref(null); 
const dropdownContainer = ref(null);

const toggleDropdown = () => {
    isDropdownVisible.value = !isDropdownVisible.value;
};

const closeDropdown = (event) => {
    if (dropdownContainer.value && !dropdownContainer.value.contains(event.target)) {
        isDropdownVisible.value = false;
    }
};

const searchcommunitys = async (url = "/communities/fetch-query") => {
    if (typeof url !== "string") {
        console.error("Invalid URL passed to searchcommunitys:", url);
        url = "/communities/fetch-query"; 
    }

    try {
        const response = await axios.get(url, {
            params: { search: search.value },
        });
        communitys.value = response.data;
    } catch (error) {
        console.error("Error al consultar comunidades:", error);
    }
};

const selectcommunity = (community) => {
    selectedcommunity.value = community; 
    emit("emitcommunity", community);
    isDropdownVisible.value = false;
};

onMounted(() => {
    document.addEventListener("click", closeDropdown);
    searchcommunitys();
    if(data.comunidad){
        selectcommunity(data.comunidad);
    }
});

onBeforeUnmount(() => {
    document.removeEventListener("click", closeDropdown);
});
</script>
