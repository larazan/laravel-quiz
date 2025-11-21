<template>
  <FrontLayout>

    <section class="py-8 bg-[#F6F7FB] lg:py-24 dark:bg-gray-900">
      <div class="px-4 mx-auto max-w-3xl lg:px-4">
        <div class="xl:mx-64 2xl:mx-80 text-center">
          <h1
            class="mb-4 text-4xl font-bold text-gray-900 lg:font-extrabold lg:text-5xl lg:leading-none dark:text-white lg:text-center lg:mb-7">
            FAQs</h1>
          <p class="mb-10 text-lg font-normal text-gray-500 dark:text-gray-400 lg:text-center lg:text-xl">Let
            us know what you need and we will get back to you in no time.</p>
        </div>
      </div>

      <div class="px-4 mx-auto max-w-8xl lg:px-4">
        <div class="p-4 mx-auto max-w-3xl dark:bg-gray-800 lg:p-8">
      <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-neutral-primary text-heading"
        data-inactive-classes="text-body">
        <div v-for="(faq, i) in items" :key="faq.id ?? i">
          <h2 :id="`accordion-flush-heading-${i}`">
            <button type="button"
              class="flex items-center text-left justify-between w-full py-5 font-semibold text-lg border-b border-default gap-3"
              :data-accordion-target="`#accordion-flush-body-${i}`" :aria-controls="`accordion-flush-body-${i}`">
              <span class="text-body">{{ faq.question }}</span>
              <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m5 15 7-7 7 7" />
              </svg>
            </button>
          </h2>
          <div :id="`accordion-flush-body-${i}`" class="hidden" :aria-labelledby="`accordion-flush-heading-${i}`">
            <div class="py-5 border-b border-default text-body">
              <div v-html="faq.answer"></div>
            </div>
          </div>
        </div>
      </div>

      </div>
      </div>
    </section>
  </FrontLayout>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { initAccordions } from 'flowbite';
import FrontLayout from '@/Layouts/FrontLayout.vue';

const props = defineProps({
  faqs: {
    type: [Array, Object],
    default: () => [],
  },
});

const items = computed(() => {
  if (Array.isArray(props.faqs)) return props.faqs;
  if (props.faqs?.data) return props.faqs.data;
  return [];
});

onMounted(() => {
  initAccordions();
});
</script>