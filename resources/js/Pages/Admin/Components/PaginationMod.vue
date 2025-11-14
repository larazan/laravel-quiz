<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  meta: Object, // pagination metadata from Laravel
  limit: { type: Number, default: 5 }, // how many pages to show
  query: { type: Object, default: () => ({}) } // search/filter params
})

// 🧮 Compute visible pages with ellipses
const pagesWithEllipsis = computed(() => {
  const total = props.meta.last_page
  const current = props.meta.current_page
  const half = Math.floor(props.limit / 2)

  let start = Math.max(1, current - half)
  let end = Math.min(total, start + props.limit - 1)

  if (end - start + 1 < props.limit) {
    start = Math.max(1, end - props.limit + 1)
  }

  const pages = []
  for (let i = start; i <= end; i++) pages.push(i)

  // Add ellipsis before and after if needed
  if (start > 1) {
    if (start > 2) pages.unshift('...')
    pages.unshift(1)
  }
  if (end < total) {
    if (end < total - 1) pages.push('...')
    pages.push(total)
  }

  return pages
})

// 🔁 Handle page change with Inertia
const changePage = (page) => {
  if (page < 1 || page > props.meta.last_page || page === props.meta.current_page) return

  router.get(
    props.meta.path,
    { ...props.query, page },
    { preserveState: true, preserveScroll: true }
  )
}
</script>

<template>
    <div v-if="meta && meta.last_page > 1" class="flex items-center justify-center space-x-1 mt-6">
      <!-- First -->
      <button
        @click="changePage(1)"
        :disabled="meta.current_page === 1"
        class="px-3 py-1 border rounded disabled:opacity-50"
      >
        « First
      </button>
  
      <!-- Prev -->
      <button
        @click="changePage(meta.current_page - 1)"
        :disabled="meta.current_page === 1"
        class="px-3 py-1 border rounded disabled:opacity-50"
      >
        ‹ Prev
      </button>
  
      <!-- Page numbers -->
      <template v-for="(page, index) in pagesWithEllipsis" :key="index">
        <span
          v-if="page === '...'"
          class="px-3 py-1 text-gray-400 select-none"
        >...</span>
  
        <button
          v-else
          @click="changePage(page)"
          :class="[
            'px-3 py-1 border rounded transition-colors duration-150',
            meta.current_page === page
              ? 'bg-blue-600 text-white border-blue-600'
              : 'hover:bg-gray-100'
          ]"
        >
          {{ page }}
        </button>
      </template>
  
      <!-- Next -->
      <button
        @click="changePage(meta.current_page + 1)"
        :disabled="meta.current_page === meta.last_page"
        class="px-3 py-1 border rounded disabled:opacity-50"
      >
        Next ›
      </button>
  
      <!-- Last -->
      <button
        @click="changePage(meta.last_page)"
        :disabled="meta.current_page === meta.last_page"
        class="px-3 py-1 border rounded disabled:opacity-50"
      >
        Last »
      </button>
    </div>
  </template>
  
 
  <!-- <Pagination
  :meta="users.meta"
  :query="{ search: searchValue }"
  :limit="5"
/> -->