<script setup>
import { ref, watch } from "vue";

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  registration: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["close", "updated"]);

const loading = ref(false);
const errorMessage = ref("");
const successMessage = ref("");

// Initial form state
const form = ref({
  id: null,
  full_name: "",
  email_address: "",
  phone_number: "",
  address: "",
  vehicle_type: "",
  plate_number: "",
  registration_date: "",
  engine_number: "",
  chassis_number: "",
});

// Watch for registration prop changes to fill the form
watch(
  () => props.registration,
  (newVal) => {
    if (newVal && Object.keys(newVal).length > 0) {
      form.value = {
        id: newVal.id,
        full_name: newVal.full_name || "",
        email_address: newVal.email_address || "",
        phone_number: newVal.phone_number || "",
        address: newVal.address || "",
        vehicle_type: newVal.vehicle_type || "",
        plate_number: newVal.plate_number || "",
        registration_date: newVal.registration_date
          ? newVal.registration_date.split("T")[0]
          : "",
        engine_number: newVal.engine_number || "",
        chassis_number: newVal.chassis_number || "",
      };
    }
  },
  { immediate: true },
);

const closeModal = () => {
  if (!loading.value) {
    emit("close");
    setTimeout(() => {
      errorMessage.value = "";
      successMessage.value = "";
    }, 300);
  }
};

const handleSubmit = async () => {
  loading.value = true;
  errorMessage.value = "";
  successMessage.value = "";

  try {
    const response = await $fetch(
      `http://localhost:8000/api/public/vehicle_registration/${form.value.id}`,
      {
        method: "PUT",
        body: form.value,
      },
    );

    if (response) {
      successMessage.value = "Registration updated successfully!";
      emit("updated");
      setTimeout(() => {
        closeModal();
      }, 1500);
    }
  } catch (error) {
    console.error("Update failed:", error);
    errorMessage.value =
      error.data?.message || "Failed to update registration. Please try again.";
  } finally {
    loading.value = false;
  }
};

const vehicleTypes = ["Sedan", "SUV", "Truck", "Motorcycle", "Van", "Others"];
</script>

<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
      >
        <div
          class="absolute inset-0 bg-slate-950/80 backdrop-blur-md"
          @click="closeModal"
        ></div>

        <div
          class="relative w-full max-w-2xl bg-slate-900 border border-white/10 rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]"
        >
          <div
            class="px-8 py-5 border-b border-white/5 flex items-center justify-between bg-white/[0.02]"
          >
            <div>
              <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-emerald-400"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  />
                </svg>
                Update Registration
              </h2>
              <p class="text-xs text-slate-500 mt-0.5">
                Modifying record for:
                <span class="text-slate-300 font-medium"
                  >#{{ registration.id }} - {{ registration.full_name }}</span
                >
              </p>
            </div>
            <button
              @click="closeModal"
              class="p-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50"
            >
              <span class="sr-only">Close modal</span>
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
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <!-- Form Area -->
          <div class="flex-1 overflow-auto p-8 custom-scrollbar">
            <form
              @submit.prevent="handleSubmit"
              id="updateVehicleForm"
              class="space-y-6"
            >
              <div
                v-if="errorMessage"
                class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm"
              >
                {{ errorMessage }}
              </div>

              <div
                v-if="successMessage"
                class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm"
              >
                {{ successMessage }}
              </div>

              <div class="space-y-4">
                <h3
                  class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4"
                >
                  Owner Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Full Name</label
                    >
                    <input
                      v-model="form.full_name"
                      type="text"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all"
                    />
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Phone Number</label
                    >
                    <input
                      v-model="form.phone_number"
                      type="tel"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all"
                    />
                  </div>
                </div>

                <div class="space-y-1.5">
                  <label class="text-xs font-medium text-slate-400 ml-1"
                    >Email Address</label
                  >
                  <input
                    v-model="form.email_address"
                    type="email"
                    required
                    class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all"
                  />
                </div>

                <div class="space-y-1.5">
                  <label class="text-xs font-medium text-slate-400 ml-1"
                    >Home Address</label
                  >
                  <textarea
                    v-model="form.address"
                    rows="2"
                    required
                    class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all resize-none"
                  ></textarea>
                </div>
              </div>

              <!-- Vehicle Details Section -->
              <div class="space-y-4 pt-4 border-t border-white/5">
                <h3
                  class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-4"
                >
                  Vehicle Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Vehicle Type</label
                    >
                    <select
                      v-model="form.vehicle_type"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all appearance-none"
                    >
                      <option value="" disabled>Select type</option>
                      <option
                        v-for="type in vehicleTypes"
                        :key="type"
                        :value="type"
                      >
                        {{ type }}
                      </option>
                    </select>
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Plate Number</label
                    >
                    <input
                      v-model="form.plate_number"
                      type="text"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all uppercase"
                    />
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Engine Number</label
                    >
                    <input
                      v-model="form.engine_number"
                      type="text"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all"
                    />
                  </div>
                  <div class="space-y-1.5">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Chassis Number</label
                    >
                    <input
                      v-model="form.chassis_number"
                      type="text"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all"
                    />
                  </div>
                  <div class="space-y-1.5 md:col-span-2">
                    <label class="text-xs font-medium text-slate-400 ml-1"
                      >Registration Date</label
                    >
                    <input
                      v-model="form.registration_date"
                      type="date"
                      required
                      class="w-full px-4 py-2.5 bg-slate-950/50 border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all [color-scheme:dark]"
                    />
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Footer -->
          <div
            class="px-8 py-5 bg-white/[0.01] border-t border-white/5 flex flex-col sm:flex-row justify-end items-center gap-3 shrink-0"
          >
            <button
              @click="closeModal"
              type="button"
              :disabled="loading"
              class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-800 transition-all border border-white/5 disabled:opacity-50"
            >
              Cancel
            </button>
            <button
              form="updateVehicleForm"
              type="submit"
              :disabled="loading"
              class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-500/20 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg
                v-if="loading"
                class="animate-spin h-4 w-4 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              {{ loading ? "Updating..." : "Save Changes" }}
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition:
    opacity 0.3s ease,
    transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(10px);
}

.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 20px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.2);
}

select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 1rem center;
  background-size: 1rem;
}
</style>
