<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

const page = usePage();

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-2 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                        class="p-2 text-indigo-500 rounded-full cursor-pointer lg:hidden hover:text-indigo-700 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg id="toggleSidebarMobileHamburger" class="w-5 h-5" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15"></path>
                        </svg>
                        <svg id="toggleSidebarMobileClose" class="hidden w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <a href="#" class="flex ml-2 md:mr-24">
                        <img src="/frontend/images/logo.svg" class="h-8 mr-3" alt="FlowBite Logo" />
                    </a>
                    
                </div>
                <div class="w-6/12">
                    <form action="#" method="GET" class="">
                        <label for="topbar-search" class="sr-only">Search</label>
                        <div class="relative mt-1 lg:w-96">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="topbar-search"
                                class="bg-gray-100 border border-gray-200 text-gray-700 sm:text-sm rounded-lg placeholder:text-gray-400 placeholder:font-semibold focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search Quiz">
                        </div>
                    </form>
                </div>
                <div class="flex items-center">




                    <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div id="tooltip-toggle" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                        Toggle dark mode
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <!-- login -->
                    <Link :href="route('login')" class="inline-flex items-center text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:ring-blue-300 font-semibold rounded-full text-sm px-5 py-2.5 text-center ml-1 md:ml-3" >
                        <span class="">Login</span>
                    </Link>
                    <!-- Profile -->
                    <div class="hidden flex2 items-center ml-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-10 h-10  rounded-full border-2">
                                    <span class="flex items-center p-1">
                                        <svg viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                            class="iconify iconify--twemoji" preserveAspectRatio="xMidYMid meet"
                                            fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <ellipse fill="#F4900C" cx="33.5" cy="14.5" rx="2.5" ry="3.5">
                                                </ellipse>
                                                <ellipse fill="#F4900C" cx="2.5" cy="14.5" rx="2.5" ry="3.5">
                                                </ellipse>
                                                <path fill="#FFAC33"
                                                    d="M34 19a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v9zM7 19a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v9z">
                                                </path>
                                                <path fill="#FFCC4D"
                                                    d="M28 5c0 2.761-4.478 4-10 4C12.477 9 8 7.761 8 5s4.477-5 10-5c5.522 0 10 2.239 10 5z">
                                                </path>
                                                <path fill="#F4900C"
                                                    d="M25 4.083C25 5.694 21.865 7 18 7c-3.866 0-7-1.306-7-2.917c0-1.611 3.134-2.917 7-2.917c3.865 0 7 1.306 7 2.917z">
                                                </path>
                                                <path fill="#269"
                                                    d="M30 5.5C30 6.881 28.881 7 27.5 7h-19C7.119 7 6 6.881 6 5.5S7.119 3 8.5 3h19A2.5 2.5 0 0 1 30 5.5z">
                                                </path>
                                                <path fill="#55ACEE" d="M30 6H6a2 2 0 0 0-2 2v26h28V8a2 2 0 0 0-2-2z">
                                                </path>
                                                <path fill="#3B88C3"
                                                    d="M35 33v-1a2 2 0 0 0-2-2H22.071l-3.364 3.364a.999.999 0 0 1-1.414 0L13.929 30H3a2 2 0 0 0-2 2v1c0 1.104-.104 2 1 2h32c1.104 0 1-.896 1-2z">
                                                </path>
                                                <circle fill="#FFF" cx="24.5" cy="14.5" r="4.5"></circle>
                                                <circle fill="#DD2E44" cx="24.5" cy="14.5" r="2.721"></circle>
                                                <circle fill="#FFF" cx="11.5" cy="14.5" r="4.5"></circle>
                                                <path fill="#F5F8FA"
                                                    d="M29 25.5a2.5 2.5 0 0 1-2.5 2.5h-17a2.5 2.5 0 1 1 0-5h17a2.5 2.5 0 0 1 2.5 2.5z">
                                                </path>
                                                <path fill="#CCD6DD"
                                                    d="M17 23h2v5h-2zm-5 0h2v5h-2zm10 0h2v5h-2zM7 25.5a2.5 2.5 0 0 0 2 2.45v-4.9a2.5 2.5 0 0 0-2 2.45zm20-2.45v4.899a2.5 2.5 0 0 0 0-4.899z">
                                                </path>
                                                <circle fill="#DD2E44" cx="11.5" cy="14.5" r="2.721"></circle>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <!-- <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo"> -->
                            </button>
                        </div>
                        <!-- Dropdown menu -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-2">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    <span>Name</span>
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    Email
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Earnings</a>
                                </li>
                                <li>
                                    <Link :href="route('admin.logout')" method="post" as="button"
                                        class="w-full text-left block cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">
                                    Sign out
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

