<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'text-emerald-500 text-base px-2 pt-1 border-b-2 border-green-200 font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'flex items-center w-full p-2 text-base text-white transition duration-75 rounded-lg group hover:underline dark:text-white dark:hover:bg-gray-700"';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
