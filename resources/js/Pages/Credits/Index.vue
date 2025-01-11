<script>
import RegisterBuyer from "@/Components/RegisterBuyer.vue";
import RegisterSale from "@/Components/RegisterSale.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import throttle from "lodash/throttle";
import Register from "../Auth/Register.vue";
import SalesTable from "@/Components/SalesTable.vue";
import RegisterInstitution from "@/Components/RegisterInstitution.vue";
import RegisterCredit from "@/Components/RegisterCredit.vue";
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
    <AppLayout title="Creditos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Creditos
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
                <RegisterCredit></RegisterCredit>
                <RegisterInstitution></RegisterInstitution>
            </div>
            <CreditsTable :credits="credits.data" class="mt-6"></CreditsTable>
            <Paginator :links="credits.links"></Paginator>
        </div>
    </AppLayout>
</template>
