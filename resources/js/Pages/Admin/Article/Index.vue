<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '../Components/Pagination.vue';
import ToggleSwitch from '../Components/ToggleSwitch.vue';
import { ref, reactive, watch } from 'vue';
import { router, Head, useForm } from '@inertiajs/vue3';
import ConfirmModal from '../Components/ConfirmModal.vue';
import PaginationMod from '../Components/PaginationMod.vue';

const props = defineProps({
    page: Number,
    articles: Object,
    categories: Object,
    search: Object
});

const resetForm = () => {
    formArticle.categoryId = null;
    formArticle.title = null;
    formArticle.body = null;
    formArticle.publishedAt = null;
    formArticle.tags = null;
} 

const form = useForm({
    title: props.articles.title,
    article_tags: props.articles.article_tags
        ? props.articles.article_tags.split(',').map(t => t.trim())
        : []
})

const formArticle = reactive({
    title: null,
    categoryId: null,
    body: null,
    publishedAt: null,
    tags: [],
    article_image: null,
});

const idArticle = ref('');
const idDeleteArticle = ref('');

const showEditModal = ref(false);
const showCreateModal = ref(false);
const showDeleteModal = ref(false);

const closeModal = () => {
    if (showEditModal.value) showEditModal.value = false;
    if (showCreateModal.value) showCreateModal.value = false;
    if (showDeleteModal.value) showDeleteModal.value = false;
}

// open edit modal
const openEditModal = (article) => {
    showEditModal.value = true;
    formArticle.categoryId = article.category_id;
    formArticle.title = article.title;
    formArticle.body = article.body;
    formArticle.publishedAt = article.published_at;
    formArticle.tags = article.article_tags ? article.article_tags.split(',').map(t => t.trim()) : [];
    idArticle.value = article.id;
}

// update method
const updateArticle = async () => {
    try {
        await router.put('/admin/article/update/' + idArticle.value, formArticle, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
                closeModal();
                resetForm();
            },
        });
    } catch (error) {
        console.log();
    }
}

// open add modal
const openAddModal = () => {
    resetForm();
    
    showCreateModal.value = true;
}

// add method
const addArticle = async () => {
    try {
        await router.post('/admin/article/create', formArticle, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
                closeModal();
                resetForm();
            },
        });
    } catch (error) {
        console.log(error);
    }

}

// open delete modal
const openDeleteModal = (id) => {
    showDeleteModal.value = true;
    idDeleteArticle.value = id;
}

// delete method
const deleteArticle = async () => {
    try {
        await router.delete('/admin/article/delete/' + idDeleteArticle.value, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
                closeModal();
                resetForm();
            },
        });
    } catch (error) {
        console.log(error);
    }

}

// search
const search = ref(props.search ?? '');

watch(search, (value) => {
    router.get('/admin/articles', { q: value }, { preserveState: true, replace: true })
});

//  pagination
const pageTo = (url) => {
    router.get(url, search.value ? { q:search.value }: '', { preserveState: true });
}
</script>

<template>

    <AdminLayout>

        <Head>
            <title>Articles</title>
        </Head>
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <!-- breadcrumb -->

                    <!-- end breadcrumb -->
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All articles</h1>
                </div>
                <div class="sm:flex">
                    <div
                        class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                        <div class="lg:pr-3">
                            <label for="articles-search" class="sr-only">Search</label>
                            <div class="relative mt-1 lg:w-64 xl:w-96">
                                <input v-model="search" type="text" name="email" id="articles-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search for articles">
                            </div>
                        </div>
                        <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                        <button @click="openAddModal" type="button"
                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add article
                        </button>
                        <a href="#"
                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Export
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        IMG
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Title
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Category
                                    </th>

                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Active
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Publish
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                                <tr v-for="(article,index) in props.articles.data" :key="article.id"
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-1" aria-describedby="checkbox-1" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-1" class="sr-only">checkbox</label>
                                            <div class="px-2 text-sm font-semibold text-gray-600">
                                            {{ ((props.articles.current_page - 1) * props.articles.per_page) + index + 1 }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w-10 h-10  rounded border-2 ">
                                            <span class="flex items-center p-1">
                                                <svg viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                                    role="img" class="iconify iconify--noto"
                                                    preserveAspectRatio="xMidYMid meet" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <radialGradient id="IconifyId17ecdb2904d178eab14345" cx="48.378"
                                                            cy="86.785" r="81.003" gradientUnits="userSpaceOnUse">
                                                            <stop offset=".283" stop-color="#afe4fe"></stop>
                                                            <stop offset=".702" stop-color="#84d4f9"></stop>
                                                            <stop offset=".965" stop-color="#67c9f6"></stop>
                                                        </radialGradient>
                                                        <path
                                                            d="M116.62 124.26H11.32c-4.15 0-7.52-3.37-7.52-7.52V11.44c0-4.15 3.37-7.52 7.52-7.52h105.3c4.15 0 7.52 3.37 7.52 7.52v105.3c.01 4.15-3.36 7.52-7.52 7.52z"
                                                            fill="url(#IconifyId17ecdb2904d178eab14345)"></path>
                                                        <path
                                                            d="M124.15 76.05V117c0 4.15-3.37 7.52-7.52 7.52H11.32c-4.15 0-7.52-3.37-7.52-7.52V75.65s38.09-1 64.1-1.4c26-.4 56.25 1.8 56.25 1.8z"
                                                            fill="#b4d218"></path>
                                                        <path
                                                            d="M106.1 124.49H11.32c-3.82 0-6.97-2.85-7.46-6.53c0 0 5.14-2.57 10.16-3.98c5.01-1.41 19.27-5.17 18.8-11.75c-.47-6.58-13.85-6.2-13-13.47c.38-3.27 6.07-6.89 12.55-9.07c8.4-2.83 18.21-3.73 18.3-3.58c.1.18-3.22 4.78-1.81 9.95c1.41 5.17 7.88 8.44 19.94 11.1s24.03 5.23 31.08 14.16c6.86 8.69 6.22 13.17 6.22 13.17z"
                                                            fill="#00c1ed"></path>
                                                        <radialGradient id="IconifyId17ecdb2904d178eab14346" cx="55.276"
                                                            cy="66.733" r="114.301" gradientUnits="userSpaceOnUse">
                                                            <stop offset=".307" stop-color="#8cdbfc"></stop>
                                                            <stop offset=".412" stop-color="#54d1f5"></stop>
                                                            <stop offset=".514" stop-color="#23c7ee"></stop>
                                                            <stop offset=".564" stop-color="#10c4ec"></stop>
                                                        </radialGradient>
                                                        <path
                                                            d="M7.73 123.58c1.07.58 2.29.91 3.59.91h88.24s-1.09-6.37-11.28-14.43c-6.74-5.33-13.39-6.77-20.76-8.49c-12.02-2.81-20.32-4.55-22.99-13.16c-1.58-5.12.66-7.95.35-8.42c-.31-.47-19.78 3.68-19.95 8.75c-.17 5.27 12.82 4.26 12.77 13.42c-.05 8.62-11.97 12.8-16.32 14.32c-9.4 3.3-13.65 7.1-13.65 7.1z"
                                                            fill="url(#IconifyId17ecdb2904d178eab14346)"></path>
                                                        <path
                                                            d="M3.8 75.39l49.26.04l-5.24-7.95s-2.43-.84-6.36-5.24s-14.31-20.1-17.11-24.59s-7.01-9.35-10.94-9.16c-3.93.19-9.61 2.52-9.61 2.52v44.38z"
                                                            fill="#79a5ab"></path>
                                                        <path
                                                            d="M3.79 26.33s2.35-.63 4.9-.49c3.55.19 7.56 3.31 7.56 3.31s-4.61-.04-7.47 2.58C6.37 33.94 3.8 37.7 3.8 37.7l-.01-11.37z"
                                                            fill="#e0e0e0"></path>
                                                        <path fill="#86b4bb"
                                                            d="M64.08 42.75L51.1 70.74l1.95 3.98l18.39-1.42l11.63-38.05l-8.93-2.4z">
                                                        </path>
                                                        <path
                                                            d="M74.51 48.83l-3.08 9.08L70 68.79l34 2.93s14.48-33.09 14.41-33.32c-.08-.23-15.68-22.74-15.68-22.74L90.72 19.9l-9.83 12.53l-6.38 16.4z"
                                                            fill="#3e727b"></path>
                                                        <path
                                                            d="M124.14 20.58s-5.21-4.62-8.21-5.67c-3-1.05-14.63-1.58-14.63-1.58l-10.2 3.69l-8.78 10.21L77.06 39l-2.7 10.13s1.75 2.02 2.59-1.71c.66-2.9 1.53-6.62 5.21-14.72s11.27-15.49 17.56-14.71c4.92.61 7.24 7.79 8.36 12.97c1.13 5.18 1.69 15.32 1.69 15.32l-7.28 3.9l-4.35 12.46s-.23 1.73-.6 4.2c-.38 2.48-.38 5.18-.38 5.18l20.19.68l6.79-4.87V20.58z"
                                                            fill="#79a5ab"></path>
                                                        <path
                                                            d="M51.18 68.23l3.15.45s2.48-6.23 3.6-9.08c1.13-2.85 2.03-5.1 2.85-6c.83-.9 3.08-1.13 3.68-2.1c.6-.98 2.85-8.25 4.5-10.96c1.65-2.7 3.68-5.1 5.4-5.78c1.73-.68 3.08-.23 3.08-.23s-2.1 5.78-3.15 10.36s-2.85 13.02-2.85 13.02s1.8-.86 2.55-1.91s.93-2.66 1.14-4.12c1.01-7.08 2.28-10.63 3.16-13.6c1.16-3.91 4-9.65 5.36-11.86c3.08-5 5.29-6.87 7.99-8.74c2.7-1.88 7.54-3.9 13.1-3.6c5.55.3 14.05 2.38 14.05 2.38s-6.21-4.82-14.69-4.74s-14.13 3.47-18.63 8.65s-6.98 12.31-6.98 12.31s-2.63-1.73-5.93-.98s-6.38 1.95-9.68 7.58s-7.43 17.71-7.43 17.71l-4.27 11.24z"
                                                            fill="#e0e0df"></path>
                                                        <path
                                                            d="M111.66 51.05s-4.65-1.2-7.13.6c-1.77 1.29-3.22 3.93-4.73 8.93c-1.37 4.53-2.06 5.1-2.1 4.97c-.18-.54.59-8.53 1.5-12.17c.68-2.7 2.54-6.94 6.68-7.88c4.65-1.06 5.63 2.92 5.78 5.55z"
                                                            fill="#e0e0df"></path>
                                                        <path
                                                            d="M93.72 26.66c-1.27-.1-1.59 1.27-1.64 5.04c-.06 4.13-.38 7.65-.38 7.65s-3.08 4.42-4.05 7.27c-.98 2.85-1.88 5.63-2.4 8.33c-.39 2-.92 4.71.3 5.18c1.58.6 3.15-6.53 4.58-10.96c1.52-4.73 4.8-8.78 4.8-8.78s.09-4.51 0-8.19c-.04-1.27.12-5.44-1.21-5.54z"
                                                            fill="#79a5ab"></path>
                                                        <path
                                                            d="M86.29 30.71c-1.13.14-1.49 1.94-1.58 4.2c-.09 2.25-.08 3.83-.08 3.83s-1.58 3.38-1.95 4.88s.83 2.18 1.88.9c1.05-1.28 3.3-5.48 3.3-5.48s.08-3 .08-4.2c0-1.2.23-4.35-1.65-4.13z"
                                                            fill="#79a5ab"></path>
                                                        <path
                                                            d="M14.21 41.36c-.1 0 .42 1.2.71 2.77c.36 1.93.73 6.36.85 13.4s.47 14.6.47 14.6l5.12-1.51s-.17-10.65-.76-16.17s-1.42-8.35-2.91-10.75c-.71-1.14-2.56-2.36-3.48-2.34z"
                                                            fill="#ace4fe"></path>
                                                        <path
                                                            d="M16.78 50.62c.93-.12.92 1.74.99 4.83c.06 2.68.17 4.3-.47 4.36c-.87.08-.75-.75-.93-5c-.12-2.73-.27-4.1.41-4.19z"
                                                            fill="#fcfdfe"></path>
                                                        <path
                                                            d="M18.86 52.47c-.58.13-.23 2.03-.12 5.29c.12 3.49-.12 5.7.99 5.7c1.05 0 .58-2.09.47-5.93c-.11-3.37-.3-5.29-1.34-5.06z"
                                                            fill="#fcfdfe"></path>
                                                        <path
                                                            d="M15.6 72.37s1.11-1.63 2.5-1.92c1.4-.29 1.92-.12 1.92-.12s.81-2.33 3.9-2.27c3.08.06 4.13 4.36 4.13 4.36l-12.39 1.63l-.06-1.68z"
                                                            fill="#fcfdfe"></path>
                                                        <path
                                                            d="M17.24 76.21s24.82-.65 39.97-.52c15.15.13 31.22.13 31.22.13s-8.62-17.24-9.28-17.11c-.65.13-5.75 9.01-5.75 9.01s-5.55-9.64-6.07-9.9s-6.35 13.07-6.35 13.07l-2.53-3.92l-2.98 4.75l-3.88-8.43l-6.92 9.67s-1.37-.43-3.07-.51c-2.56-.12-5.55 1.29-5.55 1.29s-5.49-1.83-9.28-1.83s-14.63 3-14.63 3l5.1 1.3z"
                                                            fill="#0a7e1d"></path>
                                                        <path
                                                            d="M50.49 61.52c.58.14 1.58 2.82 1.58 2.82L48.11 74l-3.45-1.01c.01 0 5.19-11.63 5.83-11.47z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M55.46 71.75l1.02 1.97l2.82-5.43s-.85-1.57-1.04-1.56c-.4.03-2.8 5.02-2.8 5.02z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M67.37 57.72c-1.09.05-6.39 13.14-6.39 13.14s1.4 2.04 1.52 2.06c.76.11 5.95-13.53 5.95-13.53s-.81-1.69-1.08-1.67z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M82.64 78.76s-.46 1.19.28 1.38s6.25 1.01 15.15.64c8.91-.37 26.07-.73 26.07-.73l.01-12.22s-7.35-16.99-8.27-16.81c-.92.18-7.29 15.14-7.29 15.14s-2.58-4.72-3.03-4.9c-.46-.18-7.68 8.78-7.68 8.78s-4.68-13.32-5.42-13.41c-.73-.09-9.82 22.13-9.82 22.13z"
                                                            fill="#0a7e1d"></path>
                                                        <path
                                                            d="M91.41 54.25c-.82 0-6.85 14.14-7.68 16.16c-.83 2.02-3.65 8.57-3.28 9.12c.37.55 3.8.82 3.8.82s3.89-11.32 5.54-15c1.65-3.67 3.51-7.31 3.51-7.31s-1.04-3.79-1.89-3.79z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M104.13 59.76c.49-.25 2.11 2.39 2.11 2.39s-6.15 10.65-6.61 10.84c-.46.18-1.75-2.94-1.75-2.94s5.14-9.74 6.25-10.29z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M3.81 112.79s4.02.57 7.08-1.55c4.41-3.06 4.66-6.34 4.66-6.34s1.17 1.64 5.73 1.73c4.56.09 6.52-3.79 6.42-4.32c-.05-.26-4.54-5.73-4.54-5.73L17.9 85.99l.61-2.57l-7.7-10.29l-3.04-17.9s-.81-1.7-1.34-1.25s-2.6 4.48-2.6 4.48l-.02 54.33z"
                                                            fill="#0a7e1d"></path>
                                                        <path
                                                            d="M11.52 87.45c-1.78-.18-3.49-2.69-3.85-8.95c-.36-6.27.36-16.47-.09-19.24c-.45-2.77-1.16-5.28-1.16-5.28s.36-.9 1.07.09s4.48 7.52 6.27 11.99c1.79 4.48 7.84 15.23 8.77 16.83c1.62 2.78 2.87 5.13.72 5.22c-2.15.09-5.11-1.82-5.11-1.82s3.58 7.43 4.65 8.95s4.12 6 4.12 6s-.54 1.79-3.4.98s-6.21-8.18-6.98-10.16c-.75-1.93-.85-3.65-.75-4.47c.18-1.52 1.47-1.84 1.47-1.84s-1.43-1.52-2.15-2.69c-.72-1.16-1.52-2.77-1.52-2.77s.63 7.43-2.06 7.16z"
                                                            fill="#00aa48"></path>
                                                        <path
                                                            d="M117.4 76.89s-18.44 5.46-19.15 6.27c-.72.81-.81 2.33.9 3.04s2.58.2 4.21 1.25c.65.42-.85 4.82-.85 4.82s-7.75 2.53-7.88 3.65c-.16 1.4.85 2.72 2.64 3.61c1.6.8 3.91.92 3.91.92s-9.01 6.84-8.57 8.54c.45 1.7 2.38 4.53 6.71 4.42c3.94-.1 4.56-1.52 6.71.09c2.15 1.61 2.07 5.31 7.88 4.92c4.03-.27 5.02-2.82 7.07-3.85c1.65-.82 3.19-.93 3.19-.93l-.03-33.6l-6.74-3.15z"
                                                            fill="#0a7e1d"></path>
                                                        <path
                                                            d="M115.34 62.57c-2.06.12-3.13 5.28-7.25 10.29S98.21 83.2 98.21 83.2s.48 1.22 1.92 1.21c2.06-.02 3.67-1.88 5.28-1.25c1.61.63 1.34 3.4 3.85 3.58c2.51.18 5.91-3.13 8.14-3.22c2.24-.09 2.24 2.24 4.39 2.15c2.15-.09 2.36-1.08 2.36-1.08v-6.82s-3.34-4.37-4.69-8.22c-1.34-3.85-2.59-7.07-4.12-6.98z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M109.35 90.41c3.04.08 5.82-2.77 9.58-2.42c3.76.36 3.94 4.56 3.49 6.27c-.45 1.7-1.52 4.65-4.3 4.65c-2.77 0-2.86-1.61-4.56-1.43c-1.7.18-2.86 1.88-5.01 1.61s-3.13-2.33-4.74-2.6s-4.21 1.25-6.27 1.16c-2.06-.09-2.93-1.81-2.93-1.81s.42-1.5 1.85-2.3s2.6-1.34 4.48-3.13s2.41-2.95 2.41-2.95s2.69 2.86 6 2.95z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M105.05 108.66c3.11 0 2.51 4.48 6.35 5.19c3.85.72 9.04-7.07 6.27-11.1c-2.77-4.03-6.27.81-9.93-.09c-3.67-.9-3.67-2.6-6.44-2.51c-2.77.09-8.53 5.44-8.68 8.41c-.09 1.79 2.77 2.66 5.55 2.24c2.76-.41 5.45-2.14 6.88-2.14z"
                                                            fill="#02ab47"></path>
                                                        <path
                                                            d="M20.34 16.11c.07 3.53 5.69 4.39 14.98 4.47c9.29.07 15.12-.72 14.98-4.18s-10.73-4.1-16.2-4.32c-5.47-.22-13.83.43-13.76 4.03z"
                                                            fill="#fffffe"></path>
                                                        <path
                                                            d="M42.44 29.83c.46 2.71 4.32 2.36 9.87 2.46c6.19.12 11 .62 11.39-2.68c.39-3.31-7.69-2.97-10.93-2.93c-3.25.05-10.88-.11-10.33 3.15z"
                                                            fill="#fffffe"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="flex items-center py-4 mr-2 max-w-sm overflow-hidden truncate space-x-6 whitespace-nowrap">
                                        
                                        <!-- <img class="w-10 h-10 rounded-full" src="https://flowbite-admin-dashboard.vercel.app/images/users/neil-sims.png" alt="Neil Sims avatar"> -->
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ article.title }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                {{ article.article_tags }}</div>
                                            <div class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                <a href="{{ route('/') }}" target="_blank" class="hover:text-gray-700 hover:underline underline-offset-2">
                                                    test.com/blog/{{  article.slug }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="max-w-sm p-4 overflow-hidden text-base font-bold text-gray-900 truncate xl:max-w-xs dark:text-gray-400">
                                        {{ article.category_id }}</td>

                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <ToggleSwitch v-model="article.is_active"
                                            :update-url="route('admin.article.toggle', article.id)" label="" />
                                    </td>
                                    <td
                                        class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <ToggleSwitch v-model="article.published"
                                            :update-url="route('admin.article.publish', article.id)" label="" />
                                    </td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <button @click="openEditModal(article)" type="button"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button @click="openDeleteModal(article.id)" type="button"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <PaginationMod :meta="props.articles" :query="{ search: searchValue }" :limit="props.page" />

        <!-- Edit Article Modal -->
        <Modal :show="showEditModal" maxWidth="xl">
            <div class="">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-semibold dark:text-white">
                            Edit article
                        </h3>
                        <button @click="closeModal()" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" view-box="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="updateArticle">
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="title"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Title
                                    </label>
                                    <input type="text" v-model="formArticle.title" id="title"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="title" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="category"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Category
                                    </label>
                                    <select v-model="formArticle.categoryId" id="category"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Select category</option>
                                        <option v-for="category in props.categories" :key="category.id"
                                            :value="category.id">{{ category.name }}</option>
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="body"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Body
                                    </label>
                                    <textarea v-model="formArticle.body" id="question" rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Enter description here"></textarea>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="tags"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Tags
                                    </label>
                                    <input type="text" v-model="formArticle.tags" id="tags"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="tags" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="title"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Publish At
                                    </label>
                                    <div class="relative max-w-sm">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-body" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                            </svg>
                                        </div>
                                        <input datepicker v-model="formArticle.publishedAt" id="default-datepicker"
                                            type="text"
                                            class="block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body"
                                            placeholder="Select date">
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block mb-2.5 text-sm font-medium text-heading" for="file_input">Upload
                                        file</label>
                                    <input
                                        class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                                        aria-describedby="file_input_help" id="file_input" type="file">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG,
                                        PNG, JPG or GIF (MAX. 800x400px).</p>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex gap-2 items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button
                                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                type="submit">Update</button>
                            <button @click="closeModal"
                                class=" justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>


        <!-- Add Article Modal -->
        <Modal :show="showCreateModal" maxWidth="xl">
            <div class="">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-semibold dark:text-white">
                            Add new article
                        </h3>
                        <button @click="closeModal" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" view-box="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form action="#" @submit.prevent="addArticle">
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Name
                                    </label>
                                    <input type="text" v-model="formArticle.name" id="name"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Bonnie" required>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="parent"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Parent Article
                                    </label>
                                    <select v-model="formArticle.parentId" id="article-create"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Select article</option>
                                        <option v-for="option in props.parentOption" :key="option.id"
                                            :value="option.id">{{ option.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex gap-2 items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button
                                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                type="submit">Submit</button>
                            <button @click="closeModal"
                                class=" justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>

        <!-- Delete Article Modal -->
        <ConfirmModal :show="showDeleteModal" message="Are you sure you want to delete this contact?"
            @confirm="deleteArticle" @close="closeModal" />


    </AdminLayout>
</template>