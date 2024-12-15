<script setup>
import { computed, onMounted, ref, toRaw, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import SaveButton from "./SaveButton.vue";
import axios from "axios";
import SealsSelector from "./SealsSelector.vue";
import InputSelect from "./InputSelect.vue";

const modalStatus = ref(false);
const closeModal = () => {
    modalStatus.value = false;
};

const products = ref([]);

onMounted(() => {
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
    weight: 0,
    unit_price: 0,
    humidity: 0,
    impurity: 0,
});

function registerProcurement() {
    form.post(route("product-store"), {
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

const adjustPrice = async () => {
    const data = { 
        weight: form.weight, 
        h: form.humidity,  
        i: form.impurity 
    };
    loadingAdjustement.value = true;

    try {
        const response = await axios.post("/fetch/adjustement", data);
        console.log(response.data); 
        form.weight = response.data.adjustedWeight; 
    } catch (error) {
        console.error("Error al ajustar el precio:", error);
    } finally {
        loadingAdjustement.value = false; 
    }
};

const estimatedTotal = computed(() => form.weight * form.unit_price);
</script>

<template>
    <button @click="modalStatus = true" class="btn btn-primary">
        Registrar Acopio
    </button>
    <DialogModal :show="modalStatus" @close="closeModal">
        <template #title>Registrar Acopio</template>

        <template #content>
            <form @submit.prevent="registerProcurement">
                <div class="mb-5">
                    <InputSelect :items="products" @item-selected="handleProductChange"
                        placeholder="Seleccionar un producto" label="Producto"></InputSelect>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="names" class="block mb-2 text-sm font-medium">
                                Cantidad (Kg)</label>
                            <input v-model="form.weight" type="number" id="names"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Kg" />
                        </div>
                        <div>
                            <div role="status" v-if="loadingAdjustement">
                                <svg aria-hidden="true"
                                    class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                            <label for="unit_price" class="block mb-2 text-sm font-medium">
                                Precio por Kilo</label>
                            <input v-model="form.unit_price" type="text" id="unit_price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="S/." />
                        </div>
                    </div>
                    <hr class="w-full h-[1px] bg-gray-500 border-[1px] border-gray-500 rounded-full my-3" />
                    <p class="font-thin text-sm">Paràmetros</p>
                    <div class="grid grid-cols-5 gap-4 items-center">
                        <div class="col-span-2">
                            <label for="names" class="block mb-2 text-sm font-medium">
                                Humedad (%)
                            </label>
                            <input v-model="form.humidity" type="number" id="names"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="%" />
                        </div>
                        <div class="col-span-2">
                            <label for="names" class="block mb-2 text-sm font-medium">
                                Impureza (%)
                            </label>
                            <input v-model="form.impurity" type="number" id="names"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="%" />
                        </div>
                        <button v-on:click="adjustPrice" class="btn btn-soft btn-accent waves waves-primary mt-6">
                            Ajustar
                        </button>
                    </div>
                    <InputError :message="form.errors.unit_price" class="mt-2" />
                </div>

                <p class="font-thin text-sm text-center">Estimado:</p>
                <p class="font-medium text-2xl text-center">
                    S/. {{ estimatedTotal }}
                </p>
                <SaveButton :disabled="form.processing">Registrar</SaveButton>
            </form>
        </template>
    </DialogModal>
</template>
