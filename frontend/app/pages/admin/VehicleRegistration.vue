<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import ViewDocumentsModal from "../../components/modal/ViewDocumentsModal.vue";
import UpdateVehicleRegistrationModal from "../../components/modal/UpdateVehicleRegistrationModal.vue";
import { deleteVehicleRegistration } from "../../api/motor/delete";
import { approveVehicleRegistration } from "../../api/motor/update";
import { getVehicleRegistration } from "../../api/motor/get";

definePageMeta({
  layout: "dashboard",
});

const searchQuery = ref("");
const loading = ref(false);
const registrations = ref([]);

const filteredRegistrations = computed(() => {
  if (!searchQuery.value) return registrations.value;
  const q = searchQuery.value.toLowerCase();
  return registrations.value.filter(
    (r) =>
      (r.full_name || "").toLowerCase().includes(q) ||
      (r.plate_number || "").toLowerCase().includes(q) ||
      (r.vehicle_type || "").toLowerCase().includes(q),
  );
});

const fetchRegistrations = async () => {
  loading.value = true;
  try {
    const data = await getVehicleRegistration();
    registrations.value = data;
  } catch (error) {
    console.error("Failed to fetch registrations:", error);
  } finally {
    loading.value = false;
  }
};

const activeMenu = ref(null);

const toggleMenu = (id) => {
  activeMenu.value = activeMenu.value === id ? null : id;
};

const approveRegistration = async (id) => {
  if (!confirm("Are you sure you want to approve this registration?")) {
    activeMenu.value = null;
    return;
  }
  activeMenu.value = null;
  try {
    await approveVehicleRegistration(id, { status: "approved" });
    await fetchRegistrations();
  } catch (error) {
    console.error("Failed to approve registration:", error);
    alert(
      error.data?.message ||
        "Failed to approve registration. Please try again.",
    );
  }
};

const closeMenu = (e) => {
  if (!e.target.closest(".dropdown-container")) {
    activeMenu.value = null;
  }
};

onMounted(() => {
  fetchRegistrations();
  window.addEventListener("click", closeMenu);
});

onUnmounted(() => {
  window.removeEventListener("click", closeMenu);
});

const deleteRegistration = async (id) => {
  if (!confirm("Are you sure you want to delete this registration?")) return;
  try {
    await deleteVehicleRegistration(id);
    await fetchRegistrations();
  } catch (error) {
    console.error("Failed to delete registration:", error);
    alert(
      error.data?.message || "Failed to delete registration. Please try again.",
    );
  }
};

const isDocModalOpen = ref(false);
const selectedDocUrl = ref("");
const selectedOwnerName = ref("");

const openDocModal = (reg) => {
  selectedDocUrl.value = reg.document;
  selectedOwnerName.value = reg.full_name;
  isDocModalOpen.value = true;
};

const closeDocModal = () => {
  isDocModalOpen.value = false;
};

const isUpdateModalOpen = ref(false);
const selectedRegistration = ref({});

const openUpdateModal = (reg) => {
  selectedRegistration.value = { ...reg };
  isUpdateModalOpen.value = true;
};

const closeUpdateModal = () => {
  isUpdateModalOpen.value = false;
};

const handleUpdated = () => {
  fetchRegistrations();
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
          class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent"
        >
          Vehicle Registrations
        </h1>
        <p class="text-slate-500 mt-1">
          Manage registered vehicles, owners, and official documents.
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
            placeholder="Search by name, plate, or type..."
            class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all duration-200"
          />
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Total Registered
        </p>
        <p class="text-2xl font-bold text-white mt-1">
          {{ registrations.length }}
        </p>
      </div>
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Recent
        </p>
        <p class="text-2xl font-bold text-teal-400 mt-1">
          {{
            registrations.filter(
              (r) =>
                new Date(r.created_at) >
                new Date(Date.now() - 30 * 24 * 60 * 60 * 1000),
            ).length
          }}
        </p>
      </div>
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Approved
        </p>
        <p class="text-2xl font-bold text-emerald-400 mt-1">
          {{ registrations.filter((r) => r.status === "approved").length }}
        </p>
      </div>
      <div
        class="p-4 bg-slate-900/40 border border-white/5 rounded-2xl backdrop-blur-sm"
      >
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
          Pending
        </p>
        <p class="text-2xl font-bold text-rose-400 mt-1">
          {{ registrations.filter((r) => r.status === "pending").length }}
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
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider w-16 text-center"
              >
                ID
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Owner Details
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Vehicle Info
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Reg. Date
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center"
              >
                Document
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-white/5">
            <tr v-if="loading" class="animate-pulse">
              <td colspan="6" class="px-6 py-8">
                <div class="flex justify-center items-center space-x-2">
                  <div
                    class="w-3 h-3 bg-teal-500 rounded-full animate-bounce"
                  ></div>
                  <div
                    class="w-3 h-3 bg-teal-500 rounded-full animate-bounce"
                    style="animation-delay: -0.15s"
                  ></div>
                  <div
                    class="w-3 h-3 bg-teal-500 rounded-full animate-bounce"
                    style="animation-delay: -0.3s"
                  ></div>
                </div>
              </td>
            </tr>
            <tr
              v-else-if="filteredRegistrations.length > 0"
              v-for="reg in filteredRegistrations"
              :key="reg.id"
              class="group hover:bg-white/[0.02] transition-colors"
            >
              <td
                class="px-6 py-4 text-sm text-slate-500 text-center font-mono"
              >
                #{{ reg.id }}
              </td>
              <td class="px-6 py-4">
                <div>
                  <h3 class="text-sm font-medium text-slate-200 leading-none">
                    {{ reg.full_name }}
                  </h3>
                  <div class="flex flex-col gap-1 mt-1.5">
                    <span
                      class="text-xs text-slate-500 flex items-center gap-1.5"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-3.5 h-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                      </svg>
                      {{ reg.email_address }}
                    </span>
                    <span
                      class="text-xs text-slate-500 flex items-center gap-1.5"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-3.5 h-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                        />
                      </svg>
                      {{ reg.phone_number }}
                    </span>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="space-y-1">
                  <div class="flex items-center gap-2">
                    <span
                      class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-800 text-slate-300 border border-slate-700"
                    >
                      {{ reg.vehicle_type }}
                    </span>
                    <span
                      class="text-sm font-bold text-white tracking-widest"
                      >{{ reg.plate_number }}</span
                    >
                  </div>
                  <div class="text-xs text-slate-500 font-mono">
                    Eng: {{ reg.engine_number }} <br />
                    Cha: {{ reg.chassis_number }}
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="text-sm text-slate-300">
                  {{ new Date(reg.registration_date).toLocaleDateString() }}
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <button
                  v-if="reg.document"
                  @click.prevent="openDocModal(reg)"
                  class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition-colors border border-emerald-500/20"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-3.5 h-3.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                    />
                  </svg>
                  View Doc
                </button>

                <span
                  v-else
                  class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20"
                >
                  No Document
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div
                  class="relative flex items-center justify-end dropdown-container"
                >
                  <button
                    @click.stop="toggleMenu(reg.id)"
                    class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200"
                    title="Actions"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                      />
                    </svg>
                  </button>

                  <!-- Dropdown Menu -->
                  <div
                    v-if="activeMenu === reg.id"
                    class="absolute right-0 top-full mt-1 w-36 bg-slate-800 border border-slate-700 rounded-lg shadow-xl z-50 overflow-hidden text-left py-1"
                  >
                    <button
                      v-if="reg.status !== 'approved'"
                      @click="approveRegistration(reg.id)"
                      class="w-full px-4 py-2 text-sm text-emerald-400 hover:bg-slate-700 text-left transition-colors font-medium"
                    >
                      Approve
                    </button>
                    <button
                      @click="
                        openUpdateModal(reg);
                        activeMenu = null;
                      "
                      class="w-full px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 text-left transition-colors"
                    >
                      Edit
                    </button>
                    <button
                      @click="
                        deleteRegistration(reg.id);
                        activeMenu = null;
                      "
                      class="w-full px-4 py-2 text-sm text-rose-400 hover:bg-slate-700 text-left transition-colors"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-else>
              <td colspan="6" class="px-6 py-20 text-center">
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
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                  </svg>
                  <p class="text-lg font-medium">No registrations found</p>
                  <p class="text-sm mt-1">
                    Try adjusting your search query or add a new one.
                  </p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <ViewDocumentsModal
      :show="isDocModalOpen"
      :document-url="selectedDocUrl"
      :owner-name="selectedOwnerName"
      @close="closeDocModal"
    />

    <UpdateVehicleRegistrationModal
      :show="isUpdateModalOpen"
      :registration="selectedRegistration"
      @close="closeUpdateModal"
      @updated="handleUpdated"
    />
  </div>
</template>

<style scoped>
::selection {
  background-color: rgba(20, 184, 166, 0.4);
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
