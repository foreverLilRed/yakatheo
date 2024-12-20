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
    f1: 0,
    f2: 0,
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
</script>

<template>
    <button @click="modalStatus = true" class="btn btn-primary">
        Registrar Acopio
    </button>
    <DialogModal :show="modalStatus" @close="closeModal" maxWidth="3xl">
        <template #title>Registrar Acopio</template>

        <template #content>
            <form @submit.prevent="registerProcurement">
                
<button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown search <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
</svg>
</button>

<!-- Dropdown menu -->
<div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow w-60 dark:bg-gray-700">
    <div class="p-3">
      <label for="input-group-search" class="sr-only">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </div>
        <input type="text" id="input-group-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search user">
      </div>
    </div>
    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
      <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
          <input id="checkbox-item-11" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          <label for="checkbox-item-11" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Bonnie Green</label>
        </div>
      </li>
      <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
            <input checked id="checkbox-item-12" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
            <label for="checkbox-item-12" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Jese Leos</label>
          </div>
      </li>
      <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
          <input id="checkbox-item-13" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          <label for="checkbox-item-13" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Michael Gough</label>
        </div>
      </li>
      <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
          <input id="checkbox-item-14" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          <label for="checkbox-item-14" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Robert Wall</label>
        </div>
      </li>
      <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
          <input id="checkbox-item-15" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          <label for="checkbox-item-15" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Joseph Mcfall</label>
        </div>
      </li>
      <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
          <input id="checkbox-item-16" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          <label for="checkbox-item-16" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Leslie Livingston</label>
        </div>
      </li>
            <li>
        <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
          <input id="checkbox-item-17" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          <label for="checkbox-item-17" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Roberta Casas</label>
        </div>
      </li>
    </ul>
    <a href="#" class="flex items-center p-3 text-sm font-medium text-red-600 border-t border-gray-200 rounded-b-lg bg-gray-50 dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-red-500 hover:underline">
      <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
        <path d="M6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Zm11-3h-6a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2Z"/>
      </svg>
      Delete user
  </a>
</div>

                <div class="mb-5">
                    <InputSelect :items="products" @item-selected="handleProductChange"
                        placeholder="Seleccionar un producto" label="Producto"></InputSelect>
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
                <div class="grid grid-cols-3 gap-x-4">
                    <div>
                        <label for="payment" class="block mb-2 text-sm font-medium">
                            Contado
                        </label>
                        <input type="number" min="0.00" max="100.00" id="payment"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" />
                    </div>
                    <div>
                        <label data-popover-target="popover-default" for="credit" class="block mb-2 text-sm font-medium">
                            Agregar Credito
                        </label>
                        <input type="number" min="0.00" max="100.00" id="credit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="" />
                    </div>
                    <div>
                        <label for="payment" class="block mb-2 text-sm font-medium">
                            Recupero
                        </label>
                        <input type="number" min="0.00" max="100.00" id="payment"
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
