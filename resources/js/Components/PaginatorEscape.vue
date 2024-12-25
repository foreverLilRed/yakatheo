<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    links: Array,
});

const emit = defineEmits(["page-change"]);

const handlePageClick = (url) => {
    emit("page-change", url);
};
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div
                    v-if="link.url === null"
                    :key="key"
                    class="mb-1 mr-1 px-1 py-1 text-gray-400 text-sm leading-4 border rounded"
                    v-html="link.label"
                />
                <button
                    v-else
                    :key="`link-${key}`"
                    class="mb-1 mr-1 px-1.5 py-1 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded"
                    :class="{ 'bg-white': link.active }"
                    @click="handlePageClick(link.url)"
                    v-html="link.label"
                ></button>
            </template>
        </div>
    </div>
</template>
