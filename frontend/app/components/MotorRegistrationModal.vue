<script setup>
import { useCookie } from "#app";
import { addMotor } from "~/api/motor/post";
const token = useCookie("auth_token");
const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  registration: {
    type: Object,
    default: () => ({
      plate_number: "",
      expirate_date: "",
      phone_number: "",
      address: "",
    }),
  },
});

const addLoading = ref(false);
const addError = ref("");

const submitAdd = async () => {
  addLoading.value = true;
  addError.value = "";
  const motorDetails = {
    plate_number: props.registration.plate_number,
    expirate_date: props.registration.expirate_date,
    phone_number: props.registration.phone_number,
    address: props.registration.address,
  };
  const response = await addMotor(motorDetails);
  console.log(response);
  if (response.status === "success") {
    emit("motor-added");
    closeModal();
  } else {
    addError.value = response.message;
  }
};

const emit = defineEmits(["close", "motor-added"]);

const closeModal = () => {
  emit("close");
};
</script>
<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
      >
        <div
          class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm"
          @click="closeModal"
        ></div>

        <div
          class="relative w-full max-w-lg bg-slate-900 border border-white/10 rounded-2xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200"
        >
          <div
            class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-white/[0.02]"
          >
            <h2 class="text-xl font-bold text-white">Registration Details</h2>
            <button
              @click="closeModal"
              class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors"
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
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitAdd" class="flex flex-col h-full">
            <div class="p-6 md:p-8 space-y-6 flex-grow">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-400"
                    >Plate Number</label
                  >
                  <div class="relative">
                    <input
                      v-model="registration.plate_number"
                      type="text"
                      placeholder="exmp.BAR-1234"
                      required
                      class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    />
                  </div>
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-400"
                    >Date Expiration</label
                  >
                  <div class="relative">
                    <input
                      v-model="registration.expirate_date"
                      type="date"
                      placeholder="dd-mm-yyyy"
                      required
                      class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    />
                  </div>
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-400"
                    >Phone Number</label
                  >
                  <div class="relative">
                    <input
                      v-model="registration.phone_number"
                      type="tel"
                      placeholder="cell no. 0915627658"
                      required
                      class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    />
                  </div>
                </div>

                <div class="space-y-2 md:col-span-2">
                  <label class="text-sm font-medium text-slate-400"
                    >Address</label
                  >
                  <div class="relative">
                    <textarea
                      v-model="registration.address"
                      rows="3"
                      placeholder="home address, City, Province, Zip Code"
                      required
                      class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                    ></textarea>
                  </div>
                </div>
              </div>

              <div
                v-if="addError"
                class="p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm animate-in fade-in slide-in-from-top-2 duration-300"
              >
                {{ addError }}
              </div>
            </div>

            <div
              class="px-6 py-4 bg-white/[0.02] border-t border-white/5 flex justify-end gap-3"
            >
              <button
                type="button"
                @click="closeModal"
                class="px-6 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 border border-white/10 transition-all duration-200"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="addLoading"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 shadow-lg shadow-blue-500/20 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg
                  v-if="addLoading"
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
                {{ addLoading ? "Saving..." : "Register Motor" }}
              </button>
            </div>
          </form>
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
    transform 0.3s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
