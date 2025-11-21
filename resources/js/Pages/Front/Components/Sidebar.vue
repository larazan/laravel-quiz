<script setup>

import { ref, computed, watchEffect } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const openDropdown = ref(null)

const isActive = (href) => page.url.startsWith(href)

// 🎯 Define your sidebar menu here
const menu = [
    {
        label: 'Categories',
        icon: `<path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />`,
        href: '/admin/dashboard',
    },
    {
        label: 'Types',
        icon: `<path d="M11.644 1.59a.75.75 0 0 1 .712 0l9.75 5.25a.75.75 0 0 1 0 1.32l-9.75 5.25a.75.75 0 0 1-.712 0l-9.75-5.25a.75.75 0 0 1 0-1.32l9.75-5.25Z" />
  <path d="m3.265 10.602 7.668 4.129a2.25 2.25 0 0 0 2.134 0l7.668-4.13 1.37.739a.75.75 0 0 1 0 1.32l-9.75 5.25a.75.75 0 0 1-.71 0l-9.75-5.25a.75.75 0 0 1 0-1.32l1.37-.738Z" />
  <path d="m10.933 19.231-7.668-4.13-1.37.739a.75.75 0 0 0 0 1.32l9.75 5.25c.221.12.489.12.71 0l9.75-5.25a.75.75 0 0 0 0-1.32l-1.37-.738-7.668 4.13a2.25 2.25 0 0 1-2.134-.001Z" />`,
        href: '/admin/settings',
    },
    {
        label: 'Leaderboard',
        icon: `<path fill-rule="evenodd" d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 0 0-.584.859 6.753 6.753 0 0 0 6.138 5.6 6.73 6.73 0 0 0 2.743 1.346A6.707 6.707 0 0 1 9.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 0 0-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 0 1-1.112-3.173 6.73 6.73 0 0 0 2.743-1.347 6.753 6.753 0 0 0 6.139-5.6.75.75 0 0 0-.585-.858 47.077 47.077 0 0 0-3.07-.543V2.62a.75.75 0 0 0-.658-.744 49.22 49.22 0 0 0-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 0 0-.657.744Zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 0 1 3.16 5.337a45.6 45.6 0 0 1 2.006-.343v.256Zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 0 1-2.863 3.207 6.72 6.72 0 0 0 .857-3.294Z" clip-rule="evenodd" />`,
        href: '/admin/reports',
    },
    {
        label: 'Article',
        icon: `<path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 0 0 3 3h15a3 3 0 0 1-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125ZM12 9.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H12Zm-.75-2.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H12a.75.75 0 0 1-.75-.75ZM6 12.75a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5H6Zm-.75 3.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75ZM6 6.75a.75.75 0 0 0-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-3A.75.75 0 0 0 9 6.75H6Z" clip-rule="evenodd" />
  <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 0 1-3 0V6.75Z" />`,
        href: '/admin/contacts',
    },
]


</script>

<template>
    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 flex lg:hidden flex-col flex-shrink-0 hidden w-64 h-full pt-0 font-normal duration-300 lg:flex transition-width"
        aria-label="Sidebar">
        <div
            class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col flex-1 pt-0 pb-4 overflow-y-auto">
                <div class="flex justify-between py-4 px-3">
                    <a href="#" class="flex ml-2 md:mr-24">
                        <img src="/frontend/images/logo.svg" class="h-8 mr-3" alt="FlowBite Logo" />
                    </a>
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                        class="p-2 text-indigo-500 rounded-full cursor-pointer lg:hidden hover:text-indigo-700 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                </div>
                <div
                    class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <ul class="pb-2 space-y-2">

                        <!--  -->
                        <template v-for="item in menu" :key="item.label">
                            <!-- If item has children = dropdown -->
                            <li v-if="item.children">
                                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group 
                    hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                    @click="openDropdown === item.label ? openDropdown = null : openDropdown = item.label">
                                    <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 
                      dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20"
                                        v-html="item.icon" />
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ item.label }}</span>

                                    <svg class="w-6 h-6 transform transition-transform"
                                        :class="{ 'rotate-180': openDropdown === item.label }" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 
                         10.586l3.293-3.293a1 1 0 111.414 
                         1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 
                         1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <ul class="py-2 space-y-2 transition-all duration-300 overflow-hidden" :class="[
                                    openDropdown === item.label || item.children.some(c => isActive(c.href))
                                        ? 'max-h-96 opacity-100'
                                        : 'max-h-0 opacity-0 hidden'
                                ]">
                                    <li v-for="child in item.children" :key="child.href">
                                        <Link :href="child.href" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 
                        group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                            :class="{ 'bg-gray-200 dark:bg-gray-800 font-semibold': isActive(child.href) }">
                                        {{ child.label }}
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <!-- Regular single link -->
                            <li v-else>
                                <Link :href="item.href" class="flex items-center space-x-2 p-2 text-base font-semibold text-gray-600 rounded-lg dark:text-white hover:bg-gray-100 
                     dark:hover:bg-gray-700" :class="{ 'bg-gray-200 dark:bg-gray-700': isActive(item.href) }">
                                <div class=" bg-pink-50">
                                    <svg class="w-6 h-6 text-orange-500 transition duration-75 dark:text-white group-hover:text-gray-900 
                      dark:group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" v-html="item.icon" />
                                </div>
                                <div>
                                    <span class="ml-3">{{ item.label }}</span>
                                </div>
                                </Link>
                            </li>
                        </template>

                    </ul>
                    <div class="absolute bottom-0 left-0 justify-center flex w-full py-2 bg-white lg:flex dark:bg-gray-800" sidebar-bottom-menu="">
                        <a href="#"
                            class="inline-flex justify-center p-2 space-x-3 text-indigo-600 rounded cursor-pointer hover:text-indigo-800 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
</svg>
<span class="font-semibold">Create</span>
                        </a>
                        
                        
                        


                    </div>
                </div>
            </div>

        </div>
    </aside>
    <div class="fixed inset-0 z-30 hidden bg-gray-300/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
</template>
