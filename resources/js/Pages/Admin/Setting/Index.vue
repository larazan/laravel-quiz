<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  settings: Object
});

const form = useForm({ ...props.settings });

const submit = () => {
  form.put(route('settings.update'));
};
</script>

<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Site Settings</h1>

    <form @submit.prevent="submit" class="space-y-4">

      <div v-for="(value, key) in form" :key="key" class="space-y-1">
        <label class="font-semibold capitalize">{{ key.replace('_', ' ') }}</label>

        <!-- multiline -->
        <textarea v-if="key.includes('description') || key.includes('about') || key.includes('terms') || key.includes('privacy')"
                  v-model="form[key]"
                  class="w-full h-32 border rounded p-2"></textarea>

        <!-- normal input -->
        <input v-else
               type="text"
               v-model="form[key]"
               class="w-full border rounded p-2" />
      </div>

      <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded">
        Save Changes
      </button>

    </form>
  </div>
</template>
