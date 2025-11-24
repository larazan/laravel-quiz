<script setup>
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import FrontLayout from '@/Layouts/FrontLayout.vue';
import { formatUS } from '@/Utils/text';
import InputField from "@/Pages/Admin/Components/InputField.vue";
import { ref, reactive, watch } from 'vue';
import Pagination from "../Components/Pagination.vue";

const params = route().params;

const props = defineProps({
    quizzes: Object,
    categories: Object,
    search: Object
});

const username = params.user_id ? props.quizzes.data.find(i => i.user_id === Number(params.user_id)).user.username : null;

// const form = useForm({
//     search: props.searchTerm,
// });

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

// const search = () => {
//     router.get(route("quizzes"), {
//         search: form.search,
//         user_id: params.user_id,
//         cat: params.cat,
//     });
// };

// search
const search = ref(props.search ?? '');

watch(search, (value) => {
    router.get('/quizzes', { q: value }, { preserveState: true, replace: true })
});

</script>

<template>
    <FrontLayout>
        <!--  -->

        <Head title="- Latest Quizzes" />

        <section class="bg-[#F6F7FB] dark:bg-gray-800 border-t border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-screen-xl px-4 py-0 mx-auto lg:py-10">
                <!--  -->
                <div
                    class="flex md:hidden md:flex-wrap w-full md:w-auto overflow-x-auto md:overflow-none py-4  items-center gap-2 md:gap-3 mt-0 md:mt-2">
                    

                    <a v-for="category in props.categories" :key="category.id" href="#"
                        class=" border-primary-200 hover:bg-primary-500 inline-flex items-center justify-center text-xs md:text-sm rounded-full px-4 py-[6px] md:py-[9px] leading-[22px] font-bold md:font-medium border text-gray-700 hover:text-white whitespace-nowrap">
                        <div class="">{{ category.name }}</div>
                    </a>

                </div>
                <!--  -->
                <h2
                    class="mb-6 text-3xl font-extrabold leading-tight tracking-tight text-gray-900 lg:text-center dark:text-white md:text-4xl">
                    Flowbite in other technologies
                </h2>

                <div class="flex items-center justify-between mb-4 bg-[#F6F7FB]">
                    <div class="flex items-center gap-2">
                        <Link
                            class="inline-flex px-3 py-1 rounded-full border border-gray-300 shadow bg-gray-200 text-sm text-gray-500 font-medium flex2 items-center gap-2"
                            v-if="params.cat" :href="route('quizzes', { ...params, cat: null, page: null })">
                        {{ params.cat }}
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>

                        </span>
                        </Link>

                        <Link
                            class="px-3 py-1 rounded-full bg-indigo-500 text-white text-sm font-semibold capitalize flex items-center gap-1"
                            v-if="params.diff" :href="route('quizzes', { ...params, diff: null, page: null })">
                        {{ params.diff }}
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>

                        </span>
                        </Link>

                        <Link class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
                            v-if="params.search" :href="route('quizzes', { ...params, search: null, page: null })">
                        {{ params.search }}
                        <i class="fa-solid fa-xmark"></i>
                        </Link>

                        <Link class="px-2 py-1 rounded-md bg-indigo-500 text-white flex items-center gap-2"
                            v-if="params.user_id" :href="route('quizzes', { ...params, user_id: null, page: null })">
                        {{ username }}
                        <i class="fa-solid fa-xmark"></i>
                        </Link>
                    </div>

                    <div class="w-1/4">
                        <form @submit.prevent="search">
                            <select id="countries"
                                class="block w-full px-3 py-2.5 bg-white border border-gray-50 cursor-pointer hover:border-gray-500 text-heading text-sm rounded-lg focus:ring-brand focus:border-primary-400 shadow-xs placeholder:text-body">
                                <option selected>Choose a country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="FR">France</option>
                                <option value="DE">Germany</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="space-y-4 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-4 xl:gap-8 sm:space-y-0 md:mt-12">


                    <div v-for="quiz in quizzes.data" :key="quiz.id"
                        class="w-full max-w-sm bg-neutral-primary-soft p-0 border border-default rounded-base shadow-xs bg-white border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 hover:shadow-lg dark:hover:shadow-lg-light">

                        <a href="#">
                            <div class="relative h-56 rounded">
                                <img class="rounded-base" src="/frontend/images/apple-watch.png" alt="product image" />
                                <div
                                    class="absolute z-10 bottom-0 h-56 w-full bg-gradient-to-b from-transparent to-[#0a1016]">
                                </div>
                                <div class="absolute z-10 top-2 px-2 w-full">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="inline-flex items-center space-x-1 bg-green-100 border border-green-200 text-green-500 text-xs font-medium px-1.5 py-0.5 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                                            </svg>
                                            <span>{{ quiz.questions_count }}</span>
                                        </div>
                                        <div
                                            class="inline-flex items-center space-x-1 bg-violet-100 border border-violet-200 text-violet-500 text-xs font-medium px-1.5 py-0.5 rounded">
                                            <span class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="size-5">
                                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                        clip-rule="evenodd" />
                                                </svg>

                                            </span>
                                            <span class="text-xs">320</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute z-10 bottom-2 px-2 w-full">
                                    <div class="">

                                        <!--  time -->
                                        <div class="flex items-center justify-between">
                                            <div
                                                class="inline-flex items-center space-x-1 bg-primary-100 border border-primary-200 text-primary-500 text-xs font-medium px-1.5 py-0.5 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <span>{{ quiz.time_limit_seconds }} s</span>
                                            </div>

                                            <div class="flex flex-col justify-center items-center text-center">
                                                <button
                                                    class="flex items-center focus:outline-none h-8 w-8 bg-white rounded-full hover:bg-pink-500 p-1 text-pink-500 hover:text-white z-[10]">
                                                    <svg class="h-6 w-6 " xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <span class="text-white text-xs z-[10]">10</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 py-3">

                                <div class="flex items-center justify-between pb-1">
                                    <button @click="selectCat(quiz.category.name)"
                                        class="bg-slate-500 text-white text-xs font-medium px-3 py-1 rounded-full hover:bg-slate-700 dark:hover:bg-slate-900">
                                        {{ quiz.category.name }}
                                    </button>
                                    <button @click="selectLevel(quiz.difficulty)"
                                        class="bg-orange-400 text-white text-xs font-medium px-3 py-1 rounded-full capitalize hover:bg-orange-500 dark:hover:bg-orange-700">
                                        {{ quiz.difficulty }}
                                    </button>
                                </div>

                                <a href="#" class="text-gray-800 hover:text-primary-600 pb-4">
                                    <h5 class="text-xl text-heading font-semibold tracking-tight">{{ quiz.title }}</h5>
                                </a>
                                <p class="text-base leading-tight text-gray-700">{{ quiz.description }}</p>
                                <div class="flex w-full items-center justify-between mt-6">
                                    <div class="block absolute2 bottom-0 inset-0 pb-0  mt-auto flex2 justify-start">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10">
                                                <img :src="`https://ui-avatars.com/api/?name=${quiz.user.username}&background=random&color=fff`"
                                                    class="w-10 h-10 rounded-full" />
                                            </div>
                                            <div class="ml-3 leading-6">
                                                <div class="font-medium text-sm text-gray-600 capitalize">
                                                    {{ quiz.user.username }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <time datetime="2021-29-00">{{ formatUS(quiz.created_at) }}</time>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <Pagination :paginator="quizzes" />

            </div>
        </section>


    </FrontLayout>
</template>