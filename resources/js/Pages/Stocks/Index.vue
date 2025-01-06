<script>
import Paginator from "@/Components/Paginator.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";

export default {
    components: {
        AppLayout,
        Paginator,
    },
    props: {
        stocks: {
            type: Object, 
            required: true,
        },
    },
    data() {
        return {
            form: {
                search: "",
            },
        };
    },
    watch: {
        "form.search": throttle(function (newSearch) {
            this.$inertia.get(
                "/productors",
                { search: newSearch },
                { preserveState: true }
            );
        }, 150),
    },
};
</script>

<template>
    <AppLayout title="Stocks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stocks / Inventario
            </h2>
        </template>

        <div class="px-12 py-12">
            <div class="flex items-center space-x-4">
                <label class="input-group max-w-sm flex-grow">
                    <span class="input-group-text">
                        <span
                            class="icon-[tabler--search] text-base-content/80 size-6"
                        ></span>
                    </span>
                    <input
                        v-model="form.search"
                        type="search"
                        class="input grow placeholder:italic"
                        placeholder="Buscar por nombre, apellidos o dni..."
                    />
                </label>
            </div>
        </div>
    </AppLayout>
</template>
