<script setup>
import { ref, computed, onMounted } from "vue";
import MotorRepoModal from "~/components/MotorRepoModal.vue";

definePageMeta({
  layout: "dashboard",
});

const searchQuery = ref("");
const showModal = ref(false);
const isEditing = ref(false);
const selectedRepo = ref(null);
const loading = ref(false);

const repos = ref([]);

const filteredRepos = computed(() => {
  if (!searchQuery.value) return repos.value;
  const q = searchQuery.value.toLowerCase();
  return repos.value.filter(
    (r) =>
      (r.name || "").toLowerCase().includes(q) ||
      (r.description || "").toLowerCase().includes(q) ||
      (r.status || "").toLowerCase().includes(q),
  );
});

const fetchMotorRepo = async () => {
  try {
    const data = await $fetch(
      "http://localhost:8000/api/public/motor_repo",
      {},
    );
    repos.value = data.data;
  } catch (error) {
    console.error("Failed to fetch registrations:", error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchMotorRepo();
});

const openAddModal = () => {
  isEditing.value = false;
  selectedRepo.value = {
    name: "",
    type: "",
    original_price: 0,
    price: 0,
    mile_age: "",
    fuel: "",
    transmission: "",
    image: null,
    description: "",
    status: "available",
  };
  showModal.value = true;
};

const openEditModal = (repo) => {
  isEditing.value = true;
  selectedRepo.value = { ...repo };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const saveRepo = (repoData) => {
  if (isEditing.value) {
    const index = repos.value.findIndex((r) => r.id === repoData.id);
    if (index !== -1) {
      repos.value[index] = { ...repoData };
    }
  } else {
    const newRepo = {
      ...repoData,
      id: repos.value.length + 1,
      created_at: new Date().toISOString(),
    };
    repos.value.unshift(newRepo);
  }
  closeModal();
};

const deleteRepo = (id) => {
  if (confirm("Are you sure you want to delete this repository?")) {
    repos.value = repos.value.filter((r) => r.id !== id);
  }
};

const formatPrice = (price) => {
  return new Intl.NumberFormat("en-PH", {
    style: "currency",
    currency: "PHP",
  }).format(price);
};

const getStatusClass = (status) => {
  switch (status) {
    case "available":
      return "bg-emerald-500/10 text-emerald-400 border-emerald-500/20";
    case "reserved":
      return "bg-amber-500/10 text-amber-400 border-amber-500/20";
    case "sold":
      return "bg-rose-500/10 text-rose-400 border-rose-500/20";
    default:
      return "bg-slate-500/10 text-slate-400 border-slate-500/20";
  }
};
</script>

<template>
  <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div
      class="flex flex-col md:flex-row md:items-center justify-between gap-4"
    >
      <div>
        <h1
          class="text-3xl font-bold bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent"
        >
          Motor Repositories
        </h1>
        <p class="text-slate-500 mt-1">
          Manage repossessed motor vehicles and their listing status.
        </p>
      </div>

      <div class="flex items-center gap-3">
        <div class="relative w-64 md:w-80">
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
            placeholder="Search repositories..."
            class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/40 transition-all duration-200"
          />
        </div>

        <button
          @click="openAddModal"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-lg shadow-indigo-500/20 transition-all duration-200 h-[42px]"
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
              d="M12 4.5v15m7.5-7.5h-15"
            />
          </svg>
          Add Repo
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Total Repos
        </p>
        <p class="text-2xl font-bold text-white mt-1">{{ repos.length }}</p>
      </div>
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Available
        </p>
        <p class="text-2xl font-bold text-emerald-400 mt-1">
          {{ repos.filter((r) => r.status === "available").length }}
        </p>
      </div>
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Valuation
        </p>
        <p class="text-2xl font-bold text-indigo-400 mt-1">
          {{
            formatPrice(repos.reduce((acc, r) => acc + Number(r.price || 0), 0))
          }}
        </p>
      </div>
    </div>

    <!-- Data Table -->
    <div
      class="bg-slate-900/50 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl"
    >
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-white/5 bg-white/5">
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center w-16"
              >
                ID
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Motor Details
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Price
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center"
              >
                Status
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr
              v-for="repo in filteredRepos"
              :key="repo.id"
              class="group hover:bg-white/[0.02] transition-colors"
            >
              <td
                class="px-6 py-4 text-sm text-slate-500 text-center font-mono"
              >
                #{{ repo.id }}
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-4">
                  <div
                    class="w-16 h-10 rounded-lg overflow-hidden bg-slate-800 border border-white/5 shrink-0"
                  >
                    <img
                      v-if="repo.image_url"
                      :src="repo.image_url"
                      class="w-full h-full object-cover"
                      alt="Motor"
                    />
                    <div
                      v-else
                      class="w-full h-full flex items-center justify-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-slate-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                      </svg>
                    </div>
                  </div>
                  <div>
                    <h3 class="text-sm font-medium text-slate-200 leading-none">
                      {{ repo.name }}
                    </h3>
                    <p
                      class="text-xs text-slate-500 mt-1 line-clamp-1 max-w-[250px]"
                    >
                      {{ repo.description }}
                    </p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm font-semibold text-white">
                  {{ formatPrice(repo.price) }}
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border"
                  :class="getStatusClass(repo.status)"
                >
                  {{ repo.status }}
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-1">
                  <button
                    @click="openEditModal(repo)"
                    class="p-2 rounded-lg text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 transition-all duration-200"
                    title="Edit Repository"
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
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                      />
                    </svg>
                  </button>
                  <button
                    @click="deleteRepo(repo.id)"
                    class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 transition-all duration-200"
                    title="Delete Repository"
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
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredRepos.length === 0">
              <td colspan="5" class="px-6 py-20 text-center">
                <div
                  class="flex flex-col items-center justify-center opacity-40"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-12 h-12 text-slate-500 mb-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                    />
                  </svg>
                  <p class="text-lg font-medium">No results found</p>
                  <p class="text-sm mt-1">Try adjusting your search query</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <MotorRepoModal
      :show="showModal"
      :repo="selectedRepo"
      :is-editing="isEditing"
      @close="closeModal"
      @save="saveRepo"
      @motor-added="fetchMotorRepo"
    />
  </div>
</template>

<style scoped>
::selection {
  background-color: rgba(79, 70, 229, 0.4);
  color: white;
}

::-webkit-scrollbar {
  height: 6px;
  width: 6px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.1);
}
</style>
