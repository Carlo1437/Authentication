<script setup>
import { ref, onMounted } from "vue";
import { useCookie } from "#app";
import MotorRegistrationModal from "~/components/MotorRegistrationModal.vue";

definePageMeta({
  layout: "dashboard",
});
const token = useCookie("auth_token");

const registrations = ref([]);
const showModal = ref(false);
const loading = ref(false);

const fetchRegistrations = async () => {
  loading.value = true;
  try {
    const data = await $fetch("http://localhost:8000/api/motor", {
      headers: {
        Authorization: `Bearer ${token.value}`,
      },
    });
    registrations.value = data.data;
  } catch (error) {
    console.error("Failed to fetch registrations:", error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchRegistrations();
});

const selectedRegistration = ref({
  plate_number: "",
  expirate_date: "",
  phone_number: "",
  address: "",
});

const openModal = (reg = null) => {
  if (reg) {
    selectedRegistration.value = { ...reg };
  } else {
    selectedRegistration.value = {
      plate_number: "",
      expirate_date: "",
      phone_number: "",
      address: "",
    };
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};
</script>

<template>
  <div class="space-y-6 animate-in fade-in duration-700">
    <div
      class="flex flex-col md:flex-row md:items-center justify-between gap-4"
    >
      <div>
        <h1
          class="text-3xl font-bold bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent"
        >
          Motor Registration
        </h1>
        <p class="text-slate-500 mt-1">
          Manage and view motor vehicle registration records.
        </p>
      </div>

      <button
        @click="openModal()"
        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-lg shadow-indigo-500/20 transition-all duration-200"
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
        Register Motor
      </button>
    </div>

    <div
      class="bg-slate-900/50 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl"
    >
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-white/5 bg-white/5">
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider text-center"
              >
                ID
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Owner
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Plate Number
              </th>
              <th
                class="px-6 py-4 text-xs font-semibold text-slate-400 uppercase tracking-wider"
              >
                Expiration Date
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
              v-for="reg in registrations"
              :key="reg.id"
              class="group hover:bg-white/[0.02] transition-colors"
            >
              <td
                class="px-6 py-4 text-sm text-slate-500 text-center font-mono"
              >
                {{ reg.id }}
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div
                    class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500/20 to-blue-600/20 flex items-center justify-center text-xs font-bold text-indigo-400 border border-indigo-500/20"
                  >
                    {{ reg.user.name.charAt(0) }}
                  </div>
                  <span class="text-sm font-medium text-slate-200">{{
                    reg.user.name
                  }}</span>
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-slate-300 font-mono">
                {{ reg.plate_number }}
              </td>
              <td class="px-6 py-4">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/10"
                >
                  {{ reg.expirate_date }}
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <button
                  @click="openModal(reg)"
                  class="p-2 rounded-lg text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 transition-all duration-200"
                  title="View Details"
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
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    />
                  </svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <MotorRegistrationModal
      :show="showModal"
      :registration="selectedRegistration"
      @close="closeModal"
      @motor-added="fetchRegistrations"
    />
  </div>
</template>

<style scoped>
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
