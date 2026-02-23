<script setup>
import { useCookie } from "#app";
import { ref, onMounted, definePageMeta, watch } from "#imports";

const token = useCookie("auth_token");
const users = ref([]);
const isLoading = ref(true);
const searchQuery = ref("");
let searchTimeout = null;

watch(searchQuery, () => {
  if (searchTimeout) clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    fetchUsers(1);
  }, 300);
});
const successMessage = ref("");
let successTimeout = null;

const currentPage = ref(1);
const lastPage = ref(1);
const totalUsers = ref(0);
const perPage = 10;

const showSuccess = (message) => {
  successMessage.value = message;
  if (successTimeout) clearTimeout(successTimeout);
  successTimeout = setTimeout(() => {
    successMessage.value = "";
  }, 3000);
};

const showEditModal = ref(false);
const editUser = ref({
  id: null,
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const editError = ref("");
const editLoading = ref(false);

const showDeleteModal = ref(false);
const deleteTarget = ref(null);
const deleteLoading = ref(false);

onMounted(async () => {
  await fetchUsers();
});

const fetchUsers = async (page = 1) => {
  isLoading.value = true;
  try {
    const paramObj = { perPage, page };
    if (searchQuery.value) {
      paramObj.search = searchQuery.value;
    }
    const params = new URLSearchParams(paramObj);

    const data = await $fetch(`http://localhost:8000/api/users?${params}`, {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    users.value = data.data;
    currentPage.value = data.current_page;
    lastPage.value = data.last_page;
    totalUsers.value = data.total;
  } catch (error) {
    console.error("Failed to fetch users:", error);
  } finally {
    isLoading.value = false;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) fetchUsers(currentPage.value - 1);
};

const nextPage = () => {
  if (currentPage.value < lastPage.value) fetchUsers(currentPage.value + 1);
};

const formatDate = (dateStr) => {
  return new Date(dateStr).toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};

const openEdit = (user) => {
  editUser.value = {
    id: user.id,
    name: user.name,
    email: user.email,
    password: "",
    password_confirmation: "",
  };
  editError.value = "";
  showEditModal.value = true;
};

const submitEdit = async () => {
  editLoading.value = true;
  editError.value = "";
  try {
    const body = { name: editUser.value.name, email: editUser.value.email };
    if (editUser.value.password) {
      body.password = editUser.value.password;
      body.password_confirmation = editUser.value.password_confirmation;
    }
    await $fetch(`http://localhost:8000/api/users/${editUser.value.id}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${token.value}` },
      body,
    });
    showEditModal.value = false;
    await fetchUsers(currentPage.value);
  } catch (error) {
    if (error.data?.errors) {
      const first = Object.values(error.data.errors)[0];
      editError.value = Array.isArray(first) ? first[0] : first;
    } else {
      editError.value = error.data?.message || "Failed to update user.";
    }
  } finally {
    editLoading.value = false;
  }
};

const openDelete = (user) => {
  deleteTarget.value = user;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  deleteLoading.value = true;
  try {
    await $fetch(`http://localhost:8000/api/users/${deleteTarget.value.id}`, {
      method: "DELETE",
      headers: { Authorization: `Bearer ${token.value}` },
    });
    showDeleteModal.value = false;
    deleteTarget.value = null;
    await fetchUsers(currentPage.value);
  } catch (error) {
    console.error("Failed to delete user:", error);
  } finally {
    deleteLoading.value = false;
  }
};

definePageMeta({
  layout: "dashboard",
  middleware: "auth",
});
</script>

<template>
  <div>
    <Transition name="alert">
      <div
        v-if="successMessage"
        class="fixed top-6 right-6 z-[60] flex items-center gap-3 px-5 py-3.5 bg-emerald-500/15 border border-emerald-500/30 rounded-xl shadow-lg shadow-emerald-500/10 backdrop-blur-sm"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5 text-emerald-400 shrink-0"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        <span class="text-sm font-medium text-emerald-300">{{
          successMessage
        }}</span>
        <button
          @click="successMessage = ''"
          class="ml-2 p-1 text-emerald-400/60 hover:text-emerald-300 transition-colors"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
    </Transition>

    <div
      class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8"
    >
      <div>
        <h1
          class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-blue-300 bg-clip-text text-transparent"
        >
          Users
        </h1>
        <p class="text-slate-500 mt-1 text-sm">
          All registered users in the system
        </p>
      </div>

      <div class="flex items-center gap-3">
        <AddUserModal
          @user-added="
            showSuccess('User added successfully!');
            fetchUsers();
          "
        />

        <div class="relative w-72">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
            />
          </svg>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search users..."
            class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all duration-200"
          />
        </div>
      </div>
    </div>

    <ClientOnly>
      <div
        class="bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-white/5 overflow-hidden"
      >
        <div v-if="isLoading" class="p-8 space-y-4">
          <div
            v-for="i in 5"
            :key="i"
            class="flex items-center gap-4 animate-pulse"
          >
            <div class="w-10 h-10 rounded-full bg-slate-800"></div>
            <div class="flex-1 space-y-2">
              <div class="h-4 bg-slate-800 rounded-lg w-1/3"></div>
              <div class="h-3 bg-slate-800/60 rounded-lg w-1/2"></div>
            </div>
            <div class="h-3 bg-slate-800/40 rounded-lg w-24"></div>
          </div>
        </div>

        <div
          v-else-if="users.length === 0"
          class="flex flex-col items-center justify-center py-20 px-4"
        >
          <div
            class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mb-4"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-8 h-8 text-slate-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
              />
            </svg>
          </div>
          <p class="text-slate-400 font-medium">No users found</p>
          <p class="text-slate-600 text-sm mt-1">
            No users have registered yet
          </p>
        </div>

        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-white/5">
              <th
                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider"
              >
                #
              </th>
              <th
                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider"
              >
                User
              </th>
              <th
                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell"
              >
                Email
              </th>
              <th
                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell"
              >
                Registered
              </th>
              <th
                class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr
              v-for="(u, index) in users"
              :key="u.id"
              class="group hover:bg-white/[0.02] transition-colors duration-150"
            >
              <td class="px-6 py-4">
                <span class="text-xs text-slate-600 font-mono">{{
                  (currentPage - 1) * perPage + index + 1
                }}</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div
                    class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-bold shadow-lg shadow-indigo-500/15 shrink-0"
                  >
                    {{ u.name?.charAt(0)?.toUpperCase() }}
                  </div>
                  <div>
                    <p class="text-sm font-medium text-white">{{ u.name }}</p>
                    <p class="text-xs text-slate-500 md:hidden">
                      {{ u.email }}
                    </p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 hidden md:table-cell">
                <span class="text-sm text-slate-400">{{ u.email }}</span>
              </td>
              <td class="px-6 py-4 hidden sm:table-cell">
                <span class="text-sm text-slate-500">{{
                  formatDate(u.created_at)
                }}</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center justify-end gap-2">
                  <button
                    @click="openEdit(u)"
                    class="p-2 rounded-lg text-slate-400 hover:text-indigo-400 hover:bg-indigo-500/10 transition-all duration-200"
                    title="Edit user"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-4 h-4"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="1.5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                      />
                    </svg>
                  </button>
                  <button
                    @click="openDelete(u)"
                    class="p-2 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200"
                    title="Delete user"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-4 h-4"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="1.5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                      />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div
          v-if="!isLoading && users.length > 0"
          class="flex items-center justify-between px-6 py-4 border-t border-white/5"
        >
          <span class="text-sm text-slate-500">
            Page {{ currentPage }} of {{ lastPage }} &mdash;
            {{ totalUsers }} total users
          </span>
          <div class="flex items-center gap-2">
            <button
              @click="prevPage"
              :disabled="currentPage <= 1"
              class="px-4 py-2 rounded-xl text-sm font-medium border transition-all duration-200"
              :class="
                currentPage <= 1
                  ? 'text-slate-600 border-white/5 cursor-not-allowed'
                  : 'text-slate-300 border-white/10 hover:bg-white/5 hover:text-white'
              "
            >
              Previous
            </button>
            <button
              @click="nextPage"
              :disabled="currentPage >= lastPage"
              class="px-4 py-2 rounded-xl text-sm font-medium border transition-all duration-200"
              :class="
                currentPage >= lastPage
                  ? 'text-slate-600 border-white/5 cursor-not-allowed'
                  : 'text-slate-300 border-white/10 hover:bg-white/5 hover:text-white'
              "
            >
              Next
            </button>
          </div>
        </div>
      </div>

      <template #fallback>
        <div
          class="bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-white/5 overflow-hidden p-8 space-y-4"
        >
          <div
            v-for="i in 5"
            :key="i"
            class="flex items-center gap-4 animate-pulse"
          >
            <div class="w-10 h-10 rounded-full bg-slate-800"></div>
            <div class="flex-1 space-y-2">
              <div class="h-4 bg-slate-800 rounded-lg w-1/3"></div>
              <div class="h-3 bg-slate-800/60 rounded-lg w-1/2"></div>
            </div>
            <div class="h-3 bg-slate-800/40 rounded-lg w-24"></div>
          </div>
        </div>
      </template>
    </ClientOnly>

    <Teleport to="body">
      <Transition name="modal">
        <div
          v-if="showEditModal"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
          <div
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            @click="showEditModal = false"
          ></div>

          <div
            class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-2xl shadow-2xl p-6 md:p-8"
          >
            <h2 class="text-xl font-bold text-white mb-6">Edit User</h2>

            <div
              v-if="editError"
              class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl"
            >
              <p class="text-red-400 text-sm">{{ editError }}</p>
            </div>

            <form @submit.prevent="submitEdit" class="space-y-5">
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Name</label>
                <input
                  v-model="editUser.name"
                  type="text"
                  required
                  class="w-full px-4 py-3 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                />
              </div>
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Email</label>
                <input
                  v-model="editUser.email"
                  type="email"
                  required
                  class="w-full px-4 py-3 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                />
              </div>

              <div class="relative py-1">
                <div class="absolute inset-0 flex items-center">
                  <div class="w-full border-t border-white/5"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                  <span class="bg-slate-900 px-3 text-slate-500"
                    >Change Password (optional)</span
                  >
                </div>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300"
                  >New Password</label
                >
                <div class="relative">
                  <input
                    v-model="editUser.password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Leave blank to keep current"
                    minlength="8"
                    class="w-full px-4 py-3 pr-12 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                  />
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-500 hover:text-slate-300 transition-colors"
                  >
                    <svg
                      v-if="!showPassword"
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="1.5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                    </svg>
                    <svg
                      v-else
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="1.5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                      />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300"
                  >Confirm Password</label
                >
                <div class="relative">
                  <input
                    v-model="editUser.password_confirmation"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    placeholder="Confirm new password"
                    minlength="8"
                    class="w-full px-4 py-3 pr-12 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                  />
                  <button
                    type="button"
                    @click="showConfirmPassword = !showConfirmPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-500 hover:text-slate-300 transition-colors"
                  >
                    <svg
                      v-if="!showConfirmPassword"
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="1.5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                    </svg>
                    <svg
                      v-else
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="1.5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                      />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="flex items-center justify-end gap-3 pt-2">
                <button
                  type="button"
                  @click="showEditModal = false"
                  class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 border border-white/10 transition-all duration-200"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="editLoading"
                  class="px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-lg shadow-indigo-500/20 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="editLoading">Saving...</span>
                  <span v-else>Save Changes</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </Transition>
    </Teleport>

    <Teleport to="body">
      <Transition name="modal">
        <div
          v-if="showDeleteModal"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
          <div
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            @click="showDeleteModal = false"
          ></div>

          <div
            class="relative w-full max-w-sm bg-slate-900 border border-white/10 rounded-2xl shadow-2xl p-6 md:p-8 text-center"
          >
            <div
              class="w-14 h-14 rounded-full bg-red-500/15 flex items-center justify-center mx-auto mb-5"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-7 h-7 text-red-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                />
              </svg>
            </div>

            <h2 class="text-lg font-bold text-white mb-2">Delete User</h2>
            <p class="text-sm text-slate-400 mb-6">
              Are you sure you want to delete
              <span class="text-white font-medium">{{
                deleteTarget?.name
              }}</span
              >? This action cannot be undone.
            </p>

            <div class="flex items-center justify-center gap-3">
              <button
                @click="showDeleteModal = false"
                class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 border border-white/10 transition-all duration-200"
              >
                Cancel
              </button>
              <button
                @click="confirmDelete"
                :disabled="deleteLoading"
                class="px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-red-600 hover:bg-red-500 shadow-lg shadow-red-500/20 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="deleteLoading">Deleting...</span>
                <span v-else>Delete</span>
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.2s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
.alert-enter-active {
  transition: all 0.3s ease-out;
}
.alert-leave-active {
  transition: all 0.2s ease-in;
}
.alert-enter-from {
  opacity: 0;
  transform: translateX(100%);
}
.alert-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
