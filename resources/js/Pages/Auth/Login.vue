<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />

    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-black">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
            <source src="/images/video.webm" type="video/mp4">
            Tu navegador no soporta videos en HTML5.
        </video>

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 w-full max-w-md p-8 bg-white/30 shadow-xl rounded-2xl backdrop-blur-md">
            <div class="flex flex-col items-center mb-6 text-2xl text-white font-semibold">
                <img src="/images/logo.jpg" class="rounded-full mb-2" style="width: 6vh;" alt="">
                <span>Sistema Yakatheo</span>
            </div>

            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>


            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <InputLabel for="email" value="Correo" />
                    <TextInput id="email" v-model="form.email" type="email"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        required autofocus autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput id="password" v-model="form.password" type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        required autocomplete="current-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="flex items-center justify-between">
                    <button class="btn btn-success btn-gradient btn-block" :disabled="form.processing">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</template>
