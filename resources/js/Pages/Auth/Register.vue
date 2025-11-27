<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';

const form = useForm({
    first_name: '',
    last_name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

// Real-time username validation
const usernameStatus = ref(null); // "valid" | "invalid" | null
const usernameMessage = ref('');

let debounceTimer = null;

watch(() => form.username, (newVal) => {
    usernameStatus.value = null;
    usernameMessage.value = '';

    if (!newVal || newVal.length < 3) return;

    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(async () => {
        try {
            const res = await axios.get(route('validate.username'), {
                params: { username: newVal }
            });

            if (res.data.valid) {
                usernameStatus.value = "valid";
                usernameMessage.value = res.data.message;
            } else {
                usernameStatus.value = "invalid";
                usernameMessage.value = res.data.message;
            }
        } catch (error) {
            usernameStatus.value = "invalid";
            usernameMessage.value = "Invalid username format.";
        }
    }, 500); // debounce 0.5s
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <h5 class="text-xl font-semibold text-heading mb-6">Create an account</h5>
            <div class="flex gap-2">
                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="first_name" value="First Name" />

                    <TextInput
                        id="first_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.first_name"
                        required
                        autofocus
                        autocomplete="first_name"
                    />

                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="last_name" value="Last Name" />

                    <TextInput
                        id="last_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.last_name"
                        required
                        autofocus
                        autocomplete="last_name"
                    />
                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
            </div>

            <div class="mt-4">
                <InputLabel for="username" value="Username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />

                <!-- Realtime validation -->
                <p v-if="usernameStatus === 'valid'" class="text-green-600 text-sm mt-1">
                    {{ usernameMessage }}
                </p>
                <p v-if="usernameStatus === 'invalid'" class="text-red-600 text-sm mt-1">
                    {{ usernameMessage }}
                </p>

            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>
            <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || usernameStatus === 'invalid'"
                    class="mt-4 text-white bg-blue-600 box-border border rounded border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3 uppercase">
                    Create Account
                </button>
            <div class="mt-0 flex items-center justify-center">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link> 
            </div>
        </form>
    </GuestLayout>
</template>
