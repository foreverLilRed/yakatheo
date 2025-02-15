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

    <div class="relative flex min-h-screen items-center justify-center bg-white overflow-hidden">
        <!-- Círculos en movimiento -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-40 h-40 bg-green-300 rounded-full blur-3xl opacity-30 animate-floating-1"></div>
            <div class="absolute top-1/2 left-20 w-32 h-32 bg-green-400 rounded-full blur-2xl opacity-20 animate-floating-2"></div>
            <div class="absolute bottom-10 right-10 w-52 h-52 bg-green-200 rounded-full blur-3xl opacity-25 animate-floating-3"></div>
            <div class="absolute bottom-1/3 right-20 w-36 h-36 bg-green-300 rounded-full blur-2xl opacity-30 animate-floating-4"></div>
            <div class="absolute top-1/4 right-1/4 w-44 h-44 bg-green-400 rounded-full blur-3xl opacity-20 animate-floating-5"></div>
        </div>

        <div class="relative z-10 w-full max-w-md p-8 bg-white shadow-xl rounded-2xl">
            <div class="flex justify-center mb-6">
                <AuthenticationCardLogo />
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

                <div class="flex items-center">
                    <input id="remember" type="checkbox" v-model="form.remember"
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                    <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                </div>

                <div class="flex items-center justify-between">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition shadow-md">
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
@keyframes floating-1 {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-20px) translateX(10px); }
    100% { transform: translateY(0) translateX(0); }
}

@keyframes floating-2 {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(15px) translateX(-15px); }
    100% { transform: translateY(0) translateX(0); }
}

@keyframes floating-3 {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-10px) translateX(-10px); }
    100% { transform: translateY(0) translateX(0); }
}

@keyframes floating-4 {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(25px) translateX(5px); }
    100% { transform: translateY(0) translateX(0); }
}

@keyframes floating-5 {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-15px) translateX(-5px); }
    100% { transform: translateY(0) translateX(0); }
}

.animate-floating-1 {
    animation: floating-1 6s infinite ease-in-out;
}

.animate-floating-2 {
    animation: floating-2 5s infinite ease-in-out;
}

.animate-floating-3 {
    animation: floating-3 7s infinite ease-in-out;
}

.animate-floating-4 {
    animation: floating-4 6.5s infinite ease-in-out;
}

.animate-floating-5 {
    animation: floating-5 5.5s infinite ease-in-out;
}
</style>
