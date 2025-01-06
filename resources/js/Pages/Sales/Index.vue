<script>
import RegisterBuyer from "@/Components/RegisterBuyer.vue";
import RegisterSale from "@/Components/RegisterSale.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";
import Register from "../Auth/Register.vue";
import SalesTable from "@/Components/SalesTable.vue";

export default {
    components: {
        AppLayout,
        RegisterBuyer,
        RegisterSale,
        SalesTable
    },
    props: {
        sales: {
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
                "/sales",
                { search: newSearch },
                { preserveState: true }
            );
        }, 150),
    },
};
</script>

<template>
    <AppLayout title="Ventas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ventas
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
                        placeholder="Buscar por proveedor, producto..."
                    />
                </label>
                <RegisterSale></RegisterSale>
                <RegisterBuyer></RegisterBuyer>
            </div>
            <SalesTable :sales="sales.data"></SalesTable>
        </div>
    </AppLayout>
</template>
