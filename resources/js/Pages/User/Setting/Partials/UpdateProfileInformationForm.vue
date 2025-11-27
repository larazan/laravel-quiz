<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ImageUploadMod from '@/Pages/Admin/Components/ImageUploadMod.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    username: user.username,
    name: user.name,
    email: user.email,
    // image: user.image,
    // old_image_url: user.image
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6">
                    <InputLabel for="first_name" value="First Name" />
                    <TextInput id="first_name" type="text"
                        class="block w-full border-gray-300 rounded-md focus:border-lio-300 focus:ring-3 focus:ring-lio-200 focus:ring-opacity-50 sm:text-sm sm:leading-5 mt-1"
                        v-model="form.first_name" required autofocus autocomplete="first_name" />
                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <InputLabel for="last_name" value="Last Name" />
                    <TextInput id="last_name" type="text"
                        class="block w-full border-gray-300 rounded-md focus:border-lio-300 focus:ring-3 focus:ring-lio-200 focus:ring-opacity-50 sm:text-sm sm:leading-5 mt-1"
                        v-model="form.last_name" required autofocus autocomplete="last_name" />
                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
            </div>
            <div class="py-4">
                <p class="block text-sm leading-5 font-medium text-gray-700" aria-hidden="true">
                    Profile Image
                </p>

                <div class="flex items-center mt-2">
                    <ImageUploadMod
                        v-model="form.image"
                        label="Image"
                        :error="form.errors?.image"
                        :preview-url="form.old_image_url"
                    />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 sm:col-span-6">
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="email"
                        class="block w-full border-gray-300 rounded-md focus:border-lio-300 focus:ring-3 focus:ring-lio-200 focus:ring-opacity-50 sm:text-sm sm:leading-5 mt-1"
                        v-model="form.email" required autofocus autocomplete="email" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="col-span-12 sm:col-span-6">
                    <InputLabel for="username" value="Username" />
                    <TextInput id="username" type="text"
                        class="block w-full border-gray-300 rounded-md focus:border-lio-300 focus:ring-3 focus:ring-lio-200 focus:ring-opacity-50 sm:text-sm sm:leading-5 mt-1"
                        v-model="form.username" required autofocus autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.username" />
                </div>
            </div>
            <!--  -->

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex mt-4 items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
