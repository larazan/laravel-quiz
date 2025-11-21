<script setup>
import { router } from "@inertiajs/vue3";

const params = route().params;

defineProps({
    quiz: Object,
});

const selectUser = (id) => {
    router.get(route("quizzes"), {
        user_id: id,
        search: params.search,
        cat: params.cat,
    });
};

const selectCat = (cat) => {
    router.get(route("quizzes"), {
        user_id: params.user_id,
        search: params.search,
        cat: cat,
    });
};

const selectLevel = (diff) => {
    router.get(route("quizzes"), {
        user_id: params.user_id,
        search: params.search,
        diff: diff,
    });
};
</script>

<template>
    <a href="#">
        <img class="rounded-base mb-6" src="/frontend/images/apple-watch.png" alt="product image" />
    
    <div>
        <div class="py-2 space-y-2 ">
            <div class="flex items-center justify-between">
                <button
                    @click="selectCat(quiz.category.id)"
                    class="bg-slate-500 text-white text-xs font-medium px-3 py-1 rounded-full hover:bg-slate-700 dark:hover:bg-slate-900"
                >
                    {{ quiz.category.name }}
                </button>
                <button
                    @click="selectLevel(quiz.difficulty)"
                    class="bg-orange-400 text-white text-xs font-medium px-3 py-1 rounded-full capitalize hover:bg-orange-500 dark:hover:bg-orange-700"
                >
                    {{ quiz.difficulty }}
                </button>
            </div>
            <!--  difficulty -->
            <div class="flex items-center justify-between">
                <div class="inline-flex items-center space-x-1 bg-primary-100 border border-primary-200 text-primary-500 text-xs font-medium px-1.5 py-0.5 rounded-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>{{ quiz.time_limit_seconds }} s</span>
                </div>
                <div class="inline-flex items-center space-x-2 bg-green-100 border border-green-200 text-green-500 text-xs font-medium px-1.5 py-0.5 rounded-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
</svg>

                    <span>{{ quiz.questions_count }}</span>
                </div>
            </div>
        </div>

        <a href="#" class="text-gray-800 hover:text-primary-600 pb-4">
            <h5 class="text-xl text-heading font-semibold tracking-tight">{{ quiz.title }}</h5>
        </a>
        <p class="text-base leading-tight text-gray-700">{{ quiz.description }}</p>
        <div class="flex w-full items-center mt-6">
            <button type="button" class="flex w-full font-semibold text-white bg-primary-600 rounded-full hover:bg-primary-700  focus:ring-4 focus:ring-brand-medium shadow-xs text-base px-3 py-2 focus:outline-none">
                <span class="w-full text-center">
                    Read more
                </span>
            </button>
        </div>
    </div>
</a>
</template>
