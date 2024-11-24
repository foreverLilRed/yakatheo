<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    title: String,
});

const isSidebarOpen = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen flex flex-col lg:flex-row bg-gray-100">
        <Head :title="title" />

        <!-- Sidebar -->
        <aside
            class="bg-white shadow-lg w-full lg:w-64 flex flex-col fixed lg:relative lg:h-auto h-full transition-transform lg:translate-x-0"
            :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }"
        >
            <div class="flex items-center justify-between lg:justify-center p-4 border-b">
                <!-- Logo -->
                <Link :href="route('dashboard')">
                    <ApplicationMark class="h-10 w-auto" />
                </Link>

                <!-- Close button (mobile only) -->
                <button
                    class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none"
                    @click="isSidebarOpen = false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-4 flex-grow">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </NavLink>
                <NavLink :href="route('profile.show')" :active="route().current('profile.show')">
                    Profile
                </NavLink>
                <!-- Add more navigation links as needed -->
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow flex items-center justify-between p-4 lg:hidden">
                <button
                    class="text-gray-500 hover:text-gray-700 focus:outline-none"
                    @click="isSidebarOpen = !isSidebarOpen"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-semibold">{{ title }}</h1>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
aside {
    z-index: 10;
}
</style>
