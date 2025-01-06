<script setup>
import { computed, ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";
import ProductSelector from "./ProductSelector.vue";
import BuyerSelector from "./BuyerSelector.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const data = defineProps({
    errors: {
        type: Object,
        required: false,
    },
});

const form = useForm({
    product_id: "",
    buyer_id: "",
    weight: "",
    unit_price: "",
    document_number: "",
});

const avaliableStock = ref(0);
function registerProduct() {
    form.post(route("sales-store"), {
        onSuccess: () => {
            form.reset();
            modalStatus.value = false;
        },
    });
}

function handleProductChange(product) {
    form.product_id = product.id;
    avaliableStock.value = product.stock;
}

function handleBuyerChange(buyer) {
    form.buyer_id = buyer.id;
}

watch(
    () => form.weight,
    (newValue) => {
        if (newValue > avaliableStock.value) {
            form.errors.weight = "La cantidad supera el stock disponible";
            setTimeout(() => {
                form.weight = avaliableStock.value;
            }, 1500);
        } else {
            form.errors.weight = "";
        }
    }
);


const validateField = (field, event) => {
    let value = event.target.value;

    const regex = /^\d*(\.\d{0,2})?$/;

    if (!regex.test(value)) {
        value = value.slice(0, -1);
    }

    form[field] = value;
};

const isSubmitDisabled = computed(() => {
    return (
        form.errors.weight !== "" ||
        form.processing ||
        form.product_id === "" ||
        form.buyer_id === "" ||
        form.weight === "" ||
        form.unit_price === "" ||
        form.document_number === ""
    );
});

function registerSale() {
    form.post(route("sales-store"), {
        onSuccess: () => {
            form.reset();
            modalStatus.value = false;
        },
    });
}
</script>

<template>
    <button @click="modalStatus = true" class="btn btn-success">
        Registrar Venta
    </button>
    <DialogModal :show="modalStatus" @close="closeModal">
        <template #title>Registrar Venta</template>

        <template #content>
            <form @submit.prevent="registerSale">
                <div class="mb-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <ProductSelector @emit-productor="handleProductChange"></ProductSelector>
                            <InputError :message="form.errors.product_id" class="mt-2" />
                        </div>
                        <div>
                            <BuyerSelector @emit-buyer="handleBuyerChange"></BuyerSelector>
                            <InputError :message="form.errors.buyer_id" class="mt-2" />
                        </div>
                    </div>
                    <h1 class="text-center font-thin text-lg text-gray-500 my-5">
                        Stock disponible: {{ avaliableStock }}
                    </h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label for="weight" class="block mb-2 text-sm font-medium">
                                Cantidad (Kg)</label>
                            <input @input="validateField('weight', $event)" v-model="form.weight" type="number"
                                id="weight"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Kg" />
                            <InputError :message="form.errors.weight" class="mt-2" />
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
                        <div>
                            <label for="document_number" class="block mb-2 text-sm font-medium">
                                Numero de documento</label>
                            <input v-model="form.document_number" type="text" id="unit_price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="000000" />
                            <InputError :message="form.errors.document_number" class="mt-2" />
                        </div>
                    </div>
                </div>

                <SaveButton :disabled="isSubmitDisabled">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
