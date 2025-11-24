<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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
                    <div class="shrink-0 inline-block overflow-hidden" aria-hidden="true">
                        <div class="flex justify-center lg:justify-start">
                            <div class="relative inline-block">

                                <div data-flux-avatar="data-flux-avatar" data-slot="avatar" data-size="md"
                                    class="[:where(&amp;)]:size-10 [:where(&amp;)]:text-sm [--avatar-radius:calc(infinity*1px)] relative flex-none isolate flex items-center justify-center [:where(&amp;)]:font-medium rounded-[var(--avatar-radius)] [:where(&amp;)]:bg-zinc-200 [:where(&amp;)]:dark:bg-zinc-600 [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white  after:absolute after:inset-0 after:inset-ring-[1px] after:inset-ring-black/7 dark:after:inset-ring-white/10 after:rounded-full bg-gray-50 h-32 w-32 mt-4"
                                    data-circle="true" loading="lazy">
                                    <img src="https://avatars.githubusercontent.com/u/25819944" alt="zamroni"
                                        class="rounded-[var(--avatar-radius)] size-full object-cover">
                                </div>


                                <div class="absolute bottom-0 right-0 transform translate-x-1 translate-y-1">
                                    <div>
                                        <button wire:click="refresh" wire:loading.attr="disabled" type="button"
                                            class="flex items-center justify-center w-10 h-10 bg-white border-2 border-gray-300 rounded-full shadow-sm hover:bg-gray-50 hover:border-lio-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lio-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            title="Refresh avatar from GitHub">
                                            <svg wire:loading.remove="" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            <svg wire:loading="" class="animate-spin h-5 w-5 text-gray-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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
