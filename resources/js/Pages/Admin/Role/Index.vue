<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import PaginationMod from '@/Components/PaginationMod.vue';
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import { ref, reactive, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
  roles: Object,
  permissions: Array,
  search: String,
  page: Number,
});

const formRole = reactive({
  name: '',
  permissions: [],
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

const idRole = ref('');
const idDeleteRole = ref('');

const resetForm = () => {
  formRole.name = '';
  formRole.permissions = [];
};

const openAddModal = () => {
  resetForm();
  showCreateModal.value = true;
};

const addRole = () => {
  router.post('/admin/roles', formRole);
  resetForm();
  closeModal();
};

const openEditModal = (role) => {
  formRole.name = role.name;
  formRole.permissions = role.permissions.map((p) => p.id);
  idRole.value = role.id;
  showEditModal.value = true;
};

const updateRole = () => {
  router.put(`/admin/roles/${idRole.value}`, formRole);
  closeModal();
};

const openDeleteModal = (id) => {
  idDeleteRole.value = id;
  showDeleteModal.value = true;
};

const deleteRole = () => {
  router.delete(`/admin/roles/${idDeleteRole.value}`);
  closeModal();
};

const closeModal = () => {
  showCreateModal.value = false;
  showEditModal.value = false;
  showDeleteModal.value = false;
};

const search = ref(props.search ?? '');
watch(search, (value) => {
  router.get('/admin/roles', { q: value }, { preserveState: true, replace: true });
});

const pageTo = (url) => {
  router.get(url, search.value ? { q: search.value } : {}, { preserveState: true });
};
</script>

<template>
  <AdminLayout>
    <Head><title>Roles</title></Head>

    <div class="p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
      <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Roles Management</h1>
        <button @click="openAddModal" class="px-3 py-2 text-sm text-white bg-primary-700 rounded-lg">Add Role</button>
      </div>

      <div class="mt-4 w-64">
        <input v-model="search" type="text" placeholder="Search roles" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
      </div>
    </div>

    <div class="p-4">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="p-4 text-left text-xs font-medium">Role</th>
            <th class="p-4 text-left text-xs font-medium">Permissions</th>
            <th class="p-4 text-left text-xs font-medium">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in props.roles.data" :key="role.id" class="border-b dark:border-gray-700">
            <td class="p-4 font-bold">{{ role.name }}</td>
            <td class="p-4">
              <span v-for="perm in role.permissions" :key="perm.id" class="px-2 py-1 text-xs bg-gray-200 dark:bg-gray-700 rounded mr-1">{{ perm.name }}</span>
            </td>
            <td class="p-4 space-x-2">
              <button @click="openEditModal(role)" class="px-3 py-1 text-sm text-white bg-primary-700 rounded">Edit</button>
              <button @click="openDeleteModal(role.id)" class="px-3 py-1 text-sm text-white bg-red-700 rounded">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <PaginationMod :meta="props.roles" :query="{ search }" :limit="props.page" />

    <!-- Create Role Modal -->
    <Modal :show="showCreateModal" maxWidth="xl">
      <div class="bg-white dark:bg-gray-800 p-6 rounded">
        <h2 class="text-xl mb-4 dark:text-white">Add Role</h2>
        <form @submit.prevent="addRole">
          <label class="block mb-2 dark:text-white">Name</label>
          <input v-model="formRole.name" class="w-full p-2 border rounded mb-4 dark:bg-gray-700 dark:text-white" />

          <label class="block mb-2 dark:text-white">Permissions</label>
          <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
            <div v-for="perm in props.permissions" :key="perm.id" class="flex items-center space-x-2">
              <input type="checkbox" :value="perm.id" v-model="formRole.permissions" />
              <span class="dark:text-white">{{ perm.name }}</span>
            </div>
          </div>

          <div class="flex justify-end space-x-2 mt-6">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 text-white bg-primary-700 rounded">Save</button>
          </div>
        </form>
      </div>
    </Modal>

    <!-- Edit Role Modal -->
    <Modal :show="showEditModal" maxWidth="xl">
      <div class="bg-white dark:bg-gray-800 p-6 rounded">
        <h2 class="text-xl mb-4 dark:text-white">Edit Role</h2>
        <form @submit.prevent="updateRole">
          <label class="block mb-2 dark:text-white">Name</label>
          <input v-model="formRole.name" class="w-full p-2 border rounded mb-4 dark:bg-gray-700 dark:text-white" />

          <label class="block mb-2 dark:text-white">Permissions</label>
          <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
            <div v-for="perm in props.permissions" :key="perm.id" class="flex items-center space-x-2">
              <input type="checkbox" :value="perm.id" v-model="formRole.permissions" />
              <span class="dark:text-white">{{ perm.name }}</span>
            </div>
          </div>

          <div class="flex justify-end space-x-2 mt-6">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 text-white bg-primary-700 rounded">Update</button>
          </div>
        </form>
      </div>
    </Modal>

    <ConfirmModal :show="showDeleteModal" message="Are you sure you want to delete this role?" @confirm="deleteRole" @close="closeModal" />
  </AdminLayout>
</template>
