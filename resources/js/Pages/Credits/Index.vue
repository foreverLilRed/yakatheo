<script>
import RegisterInstitution from "@/Components/RegisterInstitution.vue";
import RegisterCredit from "@/Components/RegisterCredit.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";
import CreditsTable from "@/Components/CreditsTable.vue";
import Paginator from "@/Components/Paginator.vue";

export default {
    components: {
        AppLayout,
        RegisterInstitution,
        RegisterCredit,
        CreditsTable,
        Paginator
    },
    props: {
        credits: {
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
                "/credits",
                { search: newSearch },
                { preserveState: true }
            );
        }, 150),
    },
};
</script>

<template>
    <AppLayout title="Créditos">
        <div class="px-4 py-4">
            <h2 class="text-base-content text-3xl mb-8">Creditos</h2>
            <div class="flex flex-wrap items-center gap-4">
                <label class="input-group w-full sm:w-auto flex-grow">
                    <span class="input-group-text">
                        <span class="icon-[tabler--search] text-base-content/80 size-6"></span>
                    </span>
                    <input
                        v-model="form.search"
                        type="search"
                        class="input w-full placeholder:italic"
                        placeholder="Buscar por proveedor, producto..."
                    />
                </label>
                <div class="flex flex-wrap w-full sm:w-auto gap-2">
                    <RegisterCredit class="w-full sm:w-auto"></RegisterCredit>
                    <RegisterInstitution class="w-full sm:w-auto"></RegisterInstitution>
                </div>
            </div>
            <CreditsTable :credits="credits.data" class="mt-6"></CreditsTable>
            <div class="flex justify-center mt-4">
                <Paginator :links="credits.links"></Paginator>
            </div>
        </div>
    </AppLayout>
</template>
