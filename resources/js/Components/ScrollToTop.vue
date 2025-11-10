<template>
    <transition name="fade">
      <button
        v-if="visible"
        @click="scrollTop"
        class="fixed bottom-6 right-6 p-3 rounded-full shadow-lg bg-blue-600 text-white hover:bg-blue-700 transition z-50"
      >
        ↑
      </button>
    </transition>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from "vue";
  import { router } from "@inertiajs/vue3";
  
  const visible = ref(false);
  const threshold = 300; // px before showing button
  
  // show button only when scrolling down
  const handleScroll = () => {
    visible.value = window.scrollY > threshold;
  };
  
  onMounted(() => {
    window.addEventListener("scroll", handleScroll);
  
    // scroll to top after inertia navigation
    router.on("success", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  });
  
  onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
  });
  
  // on button click
  const scrollTop = () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  };
  </script>
  
  <style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.2s;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
  