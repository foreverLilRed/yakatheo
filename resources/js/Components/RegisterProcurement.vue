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

const recovery = ref(0);

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
    humidity: 0,
    impurity: 0,
    f1: 0,
    f2: 0,
    cash: 0,
    credit: 0,
    recovery: 0,
});

function registerProcurement() {
    form.productor_id = selectedProductor.value.id;
    form.recovery = recovery.value;
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

const adjustPrice = async () => {
    const data = {
        weight: form.weight,
        h: form.humidity,
        i: form.impurity,
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
    console.log(selectedProductor.value);
};

const discount = computed(() => {
    const balance = selectedProductor.value.balance || 0;

    const result = balance - recovery.value;
    return result >= 0 ? result : 0;
});

watch(recovery, (newValue) => {
    if (!selectedProductor.value) {
        recovery.value = 0;
        return;
    }

    const balance = selectedProductor.value.balance || 0;
    if (newValue > balance) {
        recovery.value = balance;
    }
});


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
                    <!--Si lo coloco dentro del form no funciona el productorselector-->
                    <InputSelect :items="products" @item-selected="handleProductChange"
                        placeholder="Seleccionar un producto" label="Producto"></InputSelect>
                        <div class="mx-auto my-auto">
                            <ProductorSelector @emitProductor="handleProductorSelect"/>
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
                    <div class="divider">Parametros de calidad</div>
                    <div class="grid grid-cols-4 gap-4 items-center">
                        <div>
                            <label for="humidity" class="block mb-2 text-sm font-medium">
                                Humedad (%)
                            </label>
                            <input v-model="form.humidity" type="number" id="humidity"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="%" />
                        </div>
                        <div>
                            <label for="impurity" class="block mb-2 text-sm font-medium">
                                Impureza (%)
                            </label>
                            <input v-model="form.impurity" type="number" min="0.00" max="100.00" id="impurity"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="%" />
                        </div>
                        <div>
                            <label for="f1" class="block mb-2 text-sm font-medium">
                                Factor 1
                            </label>
                            <input v-model="form.f1" type="number" min="0.00" max="100.00" id="f1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0.00" />
                        </div>
                        <div>
                            <label for="f2" class="block mb-2 text-sm font-medium">
                                Factor 2
                            </label>
                            <input v-model="form.f2" type="number" min="0.00" max="100.00" id="f2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0.00" />
                        </div>
                    </div>
                </div>
                <button v-on:click="adjustPrice" class="btn-block btn btn-soft btn-accent waves waves-primary mt-1">
                    Ajustar
                </button>
                <div class="divider">Gestionar pago</div>
                <p v-if="selectedProductor" class="text-center font-thin text-xl mb-4">
                    Balance del Productor: <span class="font-bold">S/. {{ discount }}</span>
                </p>
                <div class="grid grid-cols-3 gap-x-4">
                    <div>
                        <label for="cash" class="block mb-2 text-sm font-medium">
                            Contado
                        </label>
                        <input v-model="form.cash" type="number" min="0.00" id="cash"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" />
                    </div>
                    <div>
                        <label for="credit" class="block mb-2 text-sm font-medium">
                            Agregar Credito
                        </label>
                        <input v-model="form.credit" type="number" min="0.00" id="credit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" />
                    </div>
                    <div>
                        <label for="recovery" class="block mb-2 text-sm font-medium">
                            Recupero
                        </label>
                        <input v-model="recovery" type="number" min="0.00" id="recovery"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" />
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
