<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-b from-indigo-600 to-purple-800 text-white">
  
      <div class="max-w-2xl w-full p-6 bg-white/10 backdrop-blur rounded-2xl shadow-2xl text-center">
  
        <!-- Progress -->
        <div class="text-sm mb-2 text-gray-200">
          Question {{ currentIndex + 1 }} / {{ questions.length }}
        </div>
  
        <!-- Timer Circle -->
        <div class="relative mx-auto mb-4" style="width: 100px; height: 100px;">
          <svg class="w-full h-full transform -rotate-90">
            <circle
              class="text-gray-700"
              stroke-width="8"
              stroke="currentColor"
              fill="transparent"
              r="45"
              cx="50"
              cy="50"
            />
            <circle
              class="text-yellow-400 transition-all duration-1000 ease-linear"
              stroke-width="8"
              stroke-linecap="round"
              stroke="currentColor"
              fill="transparent"
              :r="45"
              cx="50"
              cy="50"
              :stroke-dasharray="circumference"
              :stroke-dashoffset="dashOffset"
            />
          </svg>
          <div class="absolute inset-0 flex items-center justify-center text-2xl font-bold">
            {{ timeLeft }}
          </div>
        </div>
  
        <!-- Question -->
        <motion-div
          v-motion
          :initial="{ opacity: 0, y: 30 }"
          :enter="{ opacity: 1, y: 0 }"
          class="text-xl font-semibold mb-4"
          key="question-text"
        >
          {{ currentQuestion.question_text }}
        </motion-div>
  
        <!-- Image -->
        <div v-if="currentQuestion.image_path" class="mb-4">
          <img :src="currentQuestion.image_path" class="mx-auto rounded-xl max-h-48">
        </div>
  
        <!-- Options -->
        <div class="grid gap-3">
          <motion-div
            v-for="opt in currentQuestion.options"
            :key="opt.id"
            v-motion
            :initial="{ opacity: 0, x: 50 }"
            :enter="{ opacity: 1, x: 0 }"
          >
            <button
              @click="selectOption(opt.id)"
              class="w-full py-3 rounded-xl text-lg font-medium bg-white/20 hover:bg-white/40 transition"
              :disabled="loading"
            >
              {{ opt.label }}. {{ opt.text }}
            </button>
          </motion-div>
        </div>
  
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, onBeforeUnmount } from "vue";
  import axios from "axios";
  
  const props = defineProps({
    questions: Array,
    attempt: Object,
  });
  
  const questions = props.questions;
  const attempt = props.attempt;
  
  const currentIndex = ref(0);
  const currentQuestion = computed(() => questions[currentIndex.value]);
  
  // timer
  const defaultTime = computed(() => currentQuestion.value.time_limit_seconds ?? 10);
  const timeLeft = ref(defaultTime.value);
  const circumference = 2 * Math.PI * 45;
  const dashOffset = computed(() => circumference * (1 - timeLeft.value / defaultTime.value));
  
  let timer = null;
  const loading = ref(false);
  
  // beep
  const playBeep = () => {
    const ctx = new AudioContext();
    const osc = ctx.createOscillator();
    osc.frequency.value = 900;
    osc.connect(ctx.destination);
    osc.start();
    setTimeout(() => osc.stop(), 200);
  };
  
  // timer start
  const startTimer = () => {
    clearInterval(timer);
    timeLeft.value = defaultTime.value;
  
    timer = setInterval(() => {
      if (timeLeft.value <= 0) {
        clearInterval(timer);
        autoSubmit();
      } else {
        timeLeft.value--;
        if (timeLeft.value === 3) playBeep();
      }
    }, 1000);
  };
  
  // submit answer
  const selectOption = async (optionId) => {
    loading.value = true;
    clearInterval(timer);
  
    await axios.post(route("quiz.saveAnswer"), {
      attempt_id: attempt.id,
      question_id: currentQuestion.value.id,
      option_id: optionId,
    });
  
    loading.value = false;
    nextQuestion();
  };
  
  // auto skip unanswered
  const autoSubmit = async () => {
    await axios.post(route("quiz.saveAnswer"), {
      attempt_id: attempt.id,
      question_id: currentQuestion.value.id,
      option_id: null,
    });
    nextQuestion();
  };
  
  const nextQuestion = () => {
    if (currentIndex.value < questions.length - 1) {
      currentIndex.value++;
      startTimer();
    } else {
      finishQuiz();
    }
  };
  
  // finish
  const finishQuiz = async () => {
    await axios.post(route("quiz.submit"), { attempt_id: attempt.id });
    window.location = route("quiz.results", attempt.id);
  };
  
  // boot
  onMounted(() => startTimer());
  onBeforeUnmount(() => clearInterval(timer));
  </script>
  