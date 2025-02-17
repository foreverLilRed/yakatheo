<script setup>
import { onMounted, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { initFlowbite } from 'flowbite';

defineProps({
    title: String,
});

onMounted(() => initFlowbite())

const isSidebarOpen = ref(false);
const currentYear = ref(new Date().getFullYear()); 

const logout = () => {
    router.post(route('logout'));
};

onMounted(() => initFlowbite())
</script>

<template>

    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
        aria-controls="sidebar-multi-level-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="sidebar-multi-level-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-green-500 dark:bg-gray-800">
            <div class="flex items-center gap-4 mb-6">
                <img src="/images/logo.jpg" class="rounded-full" style="width: 6vh;" alt="">
                <h1 class="text-white font-semibold text-xl">Yakatheo</h1>
            </div>
            <ul class="space-y-2 font-medium">
                <li>
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </NavLink>
                </li>
                <li>
                    <NavLink :href="route('productors')" :active="route().current('productors')">
                        Productores
                    </NavLink>
                </li>
                <li>
                    <NavLink :href="route('products')" :active="route().current('products')">
                        Productos
                    </NavLink>
                </li>
                <li>
                    <NavLink :href="route('procurements')" :active="route().current('procurements')">
                        Acopios
                    </NavLink>
                </li>
                <li>
                    <NavLink :href="route('sales')" :active="route().current('sales')">
                        Ventas
                    </NavLink>
                </li>
                <li>
                    <NavLink :href="route('credits')" :active="route().current('credits')">
                        Creditos
                    </NavLink>
                </li>
                <!--
                <li>
                    <NavLink :href="route('uploads')" :active="route().current('uploads')">
                        Carga de Archivos
                    </NavLink>
                </li>
                -->
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <span class="flex-1 text-white ms-3 text-left rtl:text-right whitespace-nowrap">Generar Documentos</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <NavLink :href="route('compromiso-produccion')"
                            :active="route().current('compromiso-produccion')">
                            Compromiso de producciòn
                        </NavLink>
                    </ul>
                </li>
                <li>
                    <button @click="logout"
                        class="flex items-center w-full p-2 text-base text-red-300 transition duration-75 rounded-lg group hover:text-white hover:bg-red-500 dark:text-red-400 dark:hover:bg-gray-700">
                        <span class="flex-1 ms-3 text-left whitespace-nowrap">Cerrar sesión</span>
                    </button>
                </li>
            </ul>
        </div>
    </aside>

    <div class="flex flex-col min-h-screen md:ml-64">
        <main class="flex-1 p-4">
            <slot />
        </main>

        <footer class="footer bg-base-200/60 px-6 py-4">
            <div class="flex w-full flex-wrap items-center justify-between">
                <div class="flex items-center gap-2 text-xl font-bold">
                    <img src="/images/logo.jpg" class="rounded-full" style="width: 3vh;" alt="">
                    <span>Coopayakat</span>
                </div>
                <aside class="grid-flow-col items-center">
                    <p> ©{{ currentYear }} <a class="link link-hover font-medium" href="https://coopayakat.com/home">Yakatheo</a> </p>
                </aside>
                <div class="flex h-5 gap-4">
                    <a href="https://www.facebook.com/CoopayakatAmazonas" class="link" aria-label="Facebook Link">
                        <span class="icon-[tabler--brand-facebook] size-5"></span>
                    </a>
                </div>
            </div>
        </footer>
    </div>

</template>

<style scoped>
aside {
    z-index: 10;
}
</style>
