<script setup>
import { computed, onMounted, ref, toRaw, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";
import axios from "axios";
import SealsSelector from "./SealsSelector.vue";
import InputSelect from "./InputSelect.vue";
import { initFlowbite } from "flowbite";
import ProductorSelector from "./ProductorSelector.vue";

const modalStatus = ref(false);

const selectedProductor = ref();

const openModal = () => {
    modalStatus.value = true;
};

const closeModal = () => {
    modalStatus.value = false;
};

const products = ref([]);

onMounted(() => {
    initFlowbite();
    axios
        .get("/fetch/products")
        .then((response) => {
            products.value = response.data;
        })
        .catch((error) => {
            console.log("Error al obtener productos: ", error);
        });
});

const form = useForm({
    product_id: "",
    productor_id: "",
    weight: 0,
    unit_price: 0,
});

function registerProcurement() {
    form.productor_id = selectedProductor.value.id;
    form.post(route("procurement-store"), {
        onSuccess: () => {
            form.reset();
            modalStatus.value = false;
        },
    });
}

function handleProductChange(product) {
    form.product_id = product.id;
}

const loadingAdjustement = ref(false);

const validateField = (field, event) => {
    let value = event.target.value;

    const regex = /^\d*(\.\d{0,2})?$/;

    if (!regex.test(value)) {
        value = value.slice(0, -1);
    }

    form[field] = value;
};

const estimatedTotal = computed(() => {
    const total = form.weight * form.unit_price;
    return parseFloat(total.toFixed(2));
});

const handleProductorSelect = (productor) => {
    selectedProductor.value = productor;
};
</script>

<template>
    <button @click="openModal" class="btn btn-primary">
        Registrar Acopio
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="3xl">
        <template #title>Registrar Acopio</template>
        <template #content>
            <form @submit.prevent="registerProcurement" >
                <div class="mb-5">
                    <div class="grid grid-cols-2">
                    <InputSelect :items="products" @item-selected="handleProductChange"
                        placeholder="Seleccionar un producto" label="Producto"></InputSelect>
                        <div class="mx-auto my-auto">
                            <ProductorSelector @emit-productor="handleProductorSelect"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="weight" class="block mb-2 text-sm font-medium">
                                Cantidad (Kg)</label>
                            <span class="loading loading-dots loading-lg" v-if="loadingAdjustement"></span>
                            <input v-if="!loadingAdjustement" @input="validateField('weight', $event)"
                                v-model="form.weight" type="number" id="weight"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Kg" />
                        </div>
                        <div>
                            <label for="unit_price" class="block mb-2 text-sm font-medium">
                                Precio por Kilo</label>
                            <input v-model="form.unit_price" @input="validateField('unit_price', $event)" type="text"
                                id="unit_price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="S/." />
                            <InputError :message="form.errors.unit_price" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div class="divider">Resultados</div>
                <div class="my-3">
                    <p class="font-thin text-sm text-center">Estimado:</p>
                    <p class="font-medium text-2xl text-center">
                        S/. {{ estimatedTotal }}
                    </p>
                </div>
                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
