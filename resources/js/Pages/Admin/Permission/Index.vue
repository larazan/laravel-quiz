<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import ConfirmModal from '@/Components/ConfirmModal.vue';
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import PaginationMod from '@/Components/PaginationMod.vue';
import { ref, reactive, watch, computed } from 'vue';
import { router, Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
  page: Number,
  permissions: Object,   // paginated permissions (permissions.data)
  groups: Array,         // [{ group: 'User Management', permissions: [{id,name,...}, ...] }, ...]
  roles: Array,          // all roles list
  users: Array,          // all users list (optional - for direct assignment)
  search: [String, Object],
});

// form state for create/edit
const formPermission = reactive({
  name: '',
  guard_name: 'web',
  group: '',
  roles: [],   // role ids to attach
  users: [],   // optional: user ids to attach permission directly
});

// local UI state
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);

const isEdit = ref(false);
const currentId = ref(null);
const idDeletePermission = ref(null);

const resetForm = () => {
  formPermission.name = '';
  formPermission.guard_name = 'web';
  formPermission.group = '';
  formPermission.roles = [];
  formPermission.users = [];
};

// Open modals
const openAddModal = () => {
  resetForm();
  isEdit.value = false;
  showCreateModal.value = true;
};

const openEditModal = (permission) => {
  resetForm();
  isEdit.value = true;
  currentId.value = permission.id;
  formPermission.name = permission.name;
  formPermission.guard_name = permission.guard_name ?? 'web';
  formPermission.group = permission.group ?? '';
  formPermission.roles = permission.roles ? permission.roles.map(r => r.id) : [];
  formPermission.users = permission.users ? permission.users.map(u => u.id) : [];
  showEditModal.value = true;
};

const openDeleteModal = (id) => {
  idDeletePermission.value = id;
  showDeleteModal.value = true;
};

const closeModal = () => {
  showCreateModal.value = false;
  showEditModal.value = false;
  showDeleteModal.value = false;
};

// CRUD actions
const addPermission = () => {
  // POST /admin/permissions/store
  router.post('/admin/permissions/store', formPermission, {
    onSuccess: () => {
      closeModal();
      Swal.fire({ icon: 'success', title: 'Permission created', timer: 1400, showConfirmButton: false });
    }
  });
};

const updatePermission = () => {
  // PUT /admin/permissions/update/:id
  router.put('/admin/permissions/update/' + currentId.value, formPermission, {
    onSuccess: () => {
      closeModal();
      Swal.fire({ icon: 'success', title: 'Permission updated', timer: 1400, showConfirmButton: false });
    }
  });
};

const deletePermission = () => {
  router.delete('/admin/permissions/delete/' + idDeletePermission.value, {}, {
    onSuccess: () => {
      closeModal();
      Swal.fire({ toast: true, icon: 'success', position: 'top-end', title: 'Deleted', showConfirmButton: false, timer: 1500 });
    }
  });
};

// toggle active (status)
const togglePermissionActive = (permission) => {
  // expects route /admin/permissions/toggle/:id (you can change)
  router.put('/admin/permissions/toggle/' + permission.id, {});
};

// assign permission => roles (quick sync inline)
const syncPermissionRoles = (permission, roleIds) => {
  router.post('/admin/permissions/' + permission.id + '/sync-roles', { roles: roleIds }, {
    onSuccess: () => {
      Swal.fire({ toast: true, icon: 'success', position: 'top-end', title: 'Roles updated', showConfirmButton: false, timer: 1200 });
    }
  });
};

// assign permission => users (direct permission to users)
const syncPermissionUsers = (permission, userIds) => {
  router.post('/admin/permissions/' + permission.id + '/sync-users', { users: userIds }, {
    onSuccess: () => {
      Swal.fire({ toast: true, icon: 'success', position: 'top-end', title: 'Users updated', showConfirmButton: false, timer: 1200 });
    }
  });
};

// Search and pagination (same pattern you used in categories)
const localSearch = ref(props.search ?? '');
watch(localSearch, (value) => {
  router.get('/admin/permissions', { q: value }, { preserveState: true, replace: true });
});

const pageTo = (url) => {
  router.get(url, localSearch.value ? { q: localSearch.value } : {}, { preserveState: true });
};

// Helpers for group checkbox logic in create/edit modal (select all in group)
const toggleGroup = (group) => {
  const ids = group.permissions.map(p => p.id);
  const containsAll = ids.every(id => formPermission.roles.includes(id)); // note: roles vs permission ids mismatch — for form we want permission ids when grouping permissions
  // For this page groups are permission groups, so we will toggle permission ids into a temporary array `groupPermissionIds`
  // We'll use a temp helper below in the template; here we keep helper for edit/create if needed.
};

// computed: flattened permission list from props.permissions (for inline role/user assignment)
const flattenedPermissions = computed(() => props.permissions?.data || []);

</script>

<template>
  <AdminLayout>
    <Head><title>Permissions</title></Head>

    <!-- Top bar -->
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <div class="w-full mb-1">
        <div class="mb-4">
          <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Permissions</h1>
        </div>

        <div class="sm:flex">
          <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 dark:divide-gray-700">
            <div class="lg:pr-3">
              <label class="sr-only">Search</label>
              <div class="relative mt-1 lg:w-64 xl:w-96">
                <input v-model="localSearch" type="text" placeholder="Search permissions" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
              </div>
            </div>
          </div>

          <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
            <button @click="openAddModal" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800">
              Add Permission
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="flex flex-col p-4">
      <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
          <div class="overflow-hidden shadow">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
              <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="p-4">
                    <div class="flex items-center">
                      <input id="checkbox-all" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50" />
                      <label for="checkbox-all" class="sr-only">checkbox</label>
                    </div>
                  </th>
                  <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase">Name</th>
                  <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase">Group</th>
                  <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase">Roles</th>
                  <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase">Status</th>
                  <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <tr v-for="permission in flattenedPermissions" :key="permission.id" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                  <td class="w-4 p-4">
                    <div class="flex items-center">
                      <input type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50" />
                    </div>
                  </td>

                  <td class="max-w-sm p-4 overflow-hidden text-base font-bold text-gray-900 truncate dark:text-gray-400">
                    {{ permission.name }}
                  </td>

                  <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ permission.group ?? '-' }}
                  </td>

                  <td class="p-4 text-sm">
                    <div class="flex flex-wrap gap-1">
                      <span v-for="r in permission.roles" :key="r.id" class="px-2 py-1 text-xs bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-300">{{ r.name }}</span>
                    </div>
                  </td>

                  <td class="p-4 text-base">
                    <ToggleSwitch
                      v-model="permission.is_active"
                      :update-url="route('admin.permissions.toggle', permission.id)"
                      label=""
                    />
                  </td>

                  <td class="p-4 space-x-2 whitespace-nowrap">
                    <!-- Quick assign roles: opens edit modal for that permission -->
                    <button @click="openEditModal(permission)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800">
                      Edit
                    </button>

                    <button @click="openDeleteModal(permission.id)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-800">
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

    <!-- Pagination -->
    <PaginationMod :meta="props.permissions" :query="{ search: localSearch }" :limit="props.page" />

    <!-- Create / Edit Modal -->
    <Modal :show="showCreateModal || showEditModal" maxWidth="4xl">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
          <h3 class="text-xl font-semibold dark:text-white">{{ isEdit ? 'Edit Permission' : 'Add Permission' }}</h3>
          <button @click="closeModal" type="button" class="text-gray-400 hover:bg-gray-200 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700">
            <svg class="w-5 h-5" fill="currentColor" view-box="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
          </button>
        </div>

        <form @submit.prevent="isEdit ? updatePermission() : addPermission()">
          <div class="p-6 space-y-6">
            <div class="grid grid-cols-6 gap-6">
              <div class="col-span-6 sm:col-span-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Permission Name</label>
                <input v-model="formPermission.name" type="text" class="shadow-sm bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="create-post" required />
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Group</label>
                <input v-model="formPermission.group" type="text" class="shadow-sm bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Post Management" />
              </div>
            </div>

            <!-- Assign to Roles -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign to Roles</label>
              <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto p-2 border rounded-lg dark:border-gray-700">
                <label v-for="role in props.roles" :key="role.id" class="flex items-center space-x-2">
                  <input type="checkbox" :value="role.id" v-model="formPermission.roles" />
                  <span class="dark:text-white">{{ role.name }}</span>
                </label>
              </div>
            </div>

            <!-- Assign to Users (optional/direct permission) -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign Directly to Users (optional)</label>
              <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto p-2 border rounded-lg dark:border-gray-700">
                <label v-for="u in props.users" :key="u.id" class="flex items-center space-x-2">
                  <input type="checkbox" :value="u.id" v-model="formPermission.users" />
                  <span class="dark:text-white">{{ u.name }}</span>
                </label>
              </div>
            </div>

            <!-- Permissions by Group (optional quick pick helper) -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quick pick by Permission Groups</label>
              <div class="space-y-3 max-h-64 overflow-y-auto p-2 border rounded-lg dark:border-gray-700">
                <div v-for="group in props.groups" :key="group.group" class="border rounded-lg p-3 dark:border-gray-600">
                  <div class="flex items-center justify-between mb-2">
                    <div class="font-semibold">{{ group.group }}</div>
                    <!-- group select all toggles permission ids into a temporary array of permission ids.
                         Since formPermission.roles is for role ids, this helper is for quickly selecting permission names' roles
                         We will offer quick copy of permission names into name input on click (useful when creating single permission) -->
                    <button type="button" class="text-xs text-primary-700" @click="() => { /* no-op quick helper placeholder */ }">Select group</button>
                  </div>

                  <div class="grid grid-cols-2 gap-2 pl-2">
                    <label v-for="perm in group.permissions" :key="perm.id" class="flex items-center space-x-2">
                      <input type="checkbox" :value="perm.name" v-model="formPermission.groupPermissions" disabled class="opacity-50" />
                      <span class="dark:text-white">{{ perm.name }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="flex gap-2 items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
            <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 rounded-lg px-5 py-2.5">Save</button>
            <button @click="closeModal" type="button" class="text-gray-500 bg-white border border-gray-200 rounded-lg px-5 py-2.5">Cancel</button>
          </div>
        </form>
      </div>
    </Modal>

    <!-- Delete Confirmation -->
    <ConfirmModal
      :show="showDeleteModal"
      message="Are you sure you want to delete this permission?"
      @confirm="deletePermission"
      @close="closeModal"
    />
  </AdminLayout>
</template>
