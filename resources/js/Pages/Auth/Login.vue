<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div class="w-full ">
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>
            <form @submit.prevent="submit">
                <h5 class="text-xl font-semibold text-heading mb-6">Sign in to your account</h5>
                <div class="mb-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                        autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div>
                    <InputLabel for="password" value="Password" />

                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                        autocomplete="current-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="flex items-start my-6">
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="ms-auto text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Forgot
                    Password?</Link>
                </div>
                <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="text-white bg-blue-600 box-border border rounded border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3 uppercase">Log
                    in</button>
                <div class="text-sm font-semibold text-gray-500">Not registered?
                    <Link :href="route('register')" class="text-blue-600 hover:text-blue-700 hover:underline">Create
                    account</Link>
                </div>
            </form>
        </div>


    </GuestLayout>
</template>
