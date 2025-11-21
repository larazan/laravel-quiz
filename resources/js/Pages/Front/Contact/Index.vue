<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import FrontLayout from '@/Layouts/FrontLayout.vue';

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: '',
});

function submit() {
  form.post(route('contact.send'));
}
</script>

<template>

  <FrontLayout>
    <!--  -->
    <section class="py-8 bg-[#F6F7FB] lg:py-24 dark:bg-gray-900">
    <div class="px-4 mx-auto max-w-8xl lg:px-4">
        <div class="xl:mx-64 2xl:mx-80">
            <h1 class="mb-4 text-4xl font-bold text-gray-900 lg:font-extrabold lg:text-5xl lg:leading-none dark:text-white lg:text-center lg:mb-7">
                Contact us</h1>
            <p class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-center lg:text-xl">Let us know what you need and we will get back to you in no time.</p>
        </div>
    </div>
    <div class="px-4 mx-auto max-w-8xl lg:px-4">
        <div class="p-4 mx-auto max-w-3xl rounded-lg border-gray-50 shadow-md dark:bg-gray-800 lg:p-8">

            <!-- <!-- Success message -->
            <transition name="fade">
                <div v-if="$page.props.flash.success" class="mb-4 p-3 rounded bg-green-100 text-green-700">
                    {{ $page.props.flash.success }}
                </div>
            </transition> 

            <form @submit.prevent="submit">
                <div class="grid md:gap-8 md:grid-cols-2">
                    <div class="mb-6">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                          Name
                        </label>
                        <input v-model="form.name" required="" type="text" id="first_name" placeholder="John" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                            {{ form.errors.name }}
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                      Email address
                    </label>
                    <input v-model="form.email" required="" type="email" id="email" placeholder="john.doe@company.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="mb-6">
                    <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
                    <input v-model="form.subject" required="" type="text" id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Subject">
                    <div v-if="form.errors.subject" class="text-red-500 text-sm mt-1">
                        {{ form.errors.message }}
                    </div>
                </div>
                <div class="mb-6">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Message</label>
                    <textarea v-model="form.message" required="" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Your message..."></textarea>
                    <div v-if="form.errors.message" class="text-red-500 text-sm mt-1">
                        {{ form.errors.message }}
                    </div>
                </div>
                
                <p class="mb-6 text-sm text-gray-500">By submitting this form you agree to our <a class="text-blue-600 dark:text-blue-500 hover:underline" href="/terms-and-conditions/">Terms &amp;
                conditions</a> and our <a class="text-blue-600 dark:text-blue-500 hover:underline" href="/privacy-policy/">Privacy
                Policy</a> which explains how we may collect, use and disclose your personal information including to third parties.</p>
                
                <button :disabled="form.processing" class="text-white font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center bg-blue-700" type="submit">
                  <span class="flex justify-center items-center">Send message</span>
                </button>
            </form>
        </div>
    </div>
</section>

  </FrontLayout>

  
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
