<script setup>
import { ref } from "vue";
import { addMotorRepo } from "../api/motor/post";

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  isEditing: {
    type: Boolean,
    default: false,
  },
  repo: {
    type: Object,
    default: () => ({
      name: "",
      type: "",
      original_price: "",
      price: "",
      mile_age: "",
      fuel: "",
      transmission: "",
      image: null,
      description: "",
      status: "available",
    }),
  },
});

const isLoading = ref(false);
const errorMessage = ref("");

const fileInput = ref(null);

const imagePreview = ref(null);

const handleFileChange = (e) => {
  const file = e.target.files[0];

  if (!file) return;

  props.repo.image = file;

  imagePreview.value = URL.createObjectURL(file);
};

const triggerFileInput = () => {
  fileInput.value?.click();
};

const submitAddMotorRepo = async () => {
  isLoading.value = true;
  errorMessage.value = "";
  try {
    const formData = new FormData();
    formData.append("name", props.repo.name);
    formData.append("type", props.repo.type);
    formData.append("original_price", props.repo.original_price);
    formData.append("price", props.repo.price);
    formData.append("mile_age", props.repo.mile_age);
    formData.append("fuel", props.repo.fuel);
    formData.append("transmission", props.repo.transmission);
    formData.append("description", props.repo.description);
    formData.append("status", props.repo.status);

    if (props.repo.image) {
      formData.append("image", props.repo.image);
    }

    const response = await addMotorRepo(formData);

    console.log(response);

    if (response && response.id) {
      emit("motor-added");
      closeModal();
    } else {
      errorMessage.value =
        typeof response === "string" ? response : "Failed to add motor repo.";
    }
  } catch (error) {
    console.error(error);
    errorMessage.value = "Something went wrong.";
  } finally {
    isLoading.value = false;
  }
};

const statusOptions = [{ value: "available", Label: "Available" }];
const emit = defineEmits(["close", "motor-added", "save"]);

const closeModal = () => {
  emit("close");
};
</script>

<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
      >
        <!-- Backdrop -->
        <div
          class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm"
          @click="closeModal"
        ></div>

        <div
          class="relative w-full max-w-3xl bg-slate-900 border border-white/10 rounded-2xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200"
        >
          <div
            class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-white/[0.02]"
          >
            <h2 class="text-xl font-bold text-white">
              {{ isEditing ? "Edit" : "Add" }} Motor Repository
            </h2>
            <button
              @click="closeModal"
              class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
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
          <form
            @submit.prevent="submitAddMotorRepo"
            class="flex flex-col max-h-[calc(100vh-8rem)]"
          >
            <div class="p-6 md:p-8 space-y-6 overflow-y-auto custom-scrollbar">
              <!-- Global Error Alert -->
              <div
                v-if="errorMessage"
                class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl flex items-start gap-3 text-red-400 text-sm animate-in fade-in slide-in-from-top-2"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 shrink-0 mt-0.5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <p>{{ errorMessage }}</p>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2 md:col-span-2">
                  <label
                    for="motor-name"
                    class="text-sm font-medium text-slate-400"
                    >Motor Name</label
                  >
                  <input
                    id="motor-name"
                    v-model="repo.name"
                    type="text"
                    placeholder="e.g. Honda Click 125i"
                    required
                    class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                  />
                </div>

                <!-- Type -->
                <div class="space-y-2">
                  <label
                    for="motor-type"
                    class="text-sm font-medium text-slate-400"
                    >Type</label
                  >
                  <input
                    id="motor-type"
                    v-model="repo.type"
                    type="text"
                    placeholder="e.g. Scooter"
                    class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                  />
                </div>

                <!-- Original Price -->
                <div class="space-y-2">
                  <label
                    for="motor-original-price"
                    class="text-sm font-medium text-slate-400"
                    >Original Price</label
                  >
                  <div class="relative">
                    <span
                      class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"
                      >₱</span
                    >
                    <input
                      id="motor-original-price"
                      v-model="repo.original_price"
                      type="number"
                      step="0.01"
                      min="0"
                      placeholder="0.00"
                      class="w-full pl-8 pr-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                    />
                  </div>
                </div>

                <!-- Price -->
                <div class="space-y-2">
                  <label
                    for="motor-price"
                    class="text-sm font-medium text-slate-400"
                    >Price</label
                  >
                  <div class="relative">
                    <span
                      class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"
                      >₱</span
                    >
                    <input
                      id="motor-price"
                      v-model="repo.price"
                      type="number"
                      step="0.01"
                      min="0"
                      placeholder="0.00"
                      required
                      class="w-full pl-8 pr-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                    />
                  </div>
                </div>

                <!-- Mileage -->
                <div class="space-y-2">
                  <label
                    for="motor-mileage"
                    class="text-sm font-medium text-slate-400"
                    >Mileage</label
                  >
                  <input
                    id="motor-mileage"
                    v-model="repo.mile_age"
                    type="text"
                    placeholder="e.g. 15,000 km"
                    class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                  />
                </div>

                <!-- Fuel -->
                <div class="space-y-2">
                  <label
                    for="motor-fuel"
                    class="text-sm font-medium text-slate-400"
                    >Fuel</label
                  >
                  <input
                    id="motor-fuel"
                    v-model="repo.fuel"
                    type="text"
                    placeholder="e.g. Gasoline"
                    class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                  />
                </div>

                <!-- Transmission -->
                <div class="space-y-2">
                  <label
                    for="motor-transmission"
                    class="text-sm font-medium text-slate-400"
                    >Transmission</label
                  >
                  <input
                    id="motor-transmission"
                    v-model="repo.transmission"
                    type="text"
                    placeholder="e.g. Automatic"
                    class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10"
                  />
                </div>

                <!-- Status -->
                <div class="space-y-2">
                  <label
                    for="motor-status"
                    class="text-sm font-medium text-slate-400"
                    >Status</label
                  >
                  <div class="relative">
                    <select
                      id="motor-status"
                      v-model="repo.status"
                      class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10 appearance-none cursor-pointer"
                    >
                      <option
                        v-for="opt in statusOptions"
                        :key="opt.value"
                        :value="opt.value"
                        class="bg-slate-900 text-slate-200"
                      >
                        {{ opt.value }}
                      </option>
                    </select>
                    <div
                      class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"
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
                          d="M19 9l-7 7-7-7"
                        />
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- Image Upload UI -->
                <div class="space-y-2 md:col-span-2">
                  <label class="text-sm font-medium text-slate-400"
                    >Motor Image</label
                  >
                  <div
                    @click="triggerFileInput"
                    class="relative group cursor-pointer"
                    @keydown.enter.space.prevent="triggerFileInput"
                    tabindex="0"
                    role="button"
                    aria-label="Upload motor image"
                  >
                    <div
                      class="w-full aspect-video md:aspect-[21/9] rounded-xl border-2 border-dashed border-white/10 bg-slate-800/20 flex flex-col items-center justify-center overflow-hidden transition-all duration-300 group-hover:border-indigo-500/50 group-hover:bg-slate-800/40 group-focus:border-indigo-500/50 group-focus:ring-2 group-focus:ring-indigo-500/20"
                    >
                      <template v-if="imagePreview">
                        <img
                          :src="imagePreview"
                          alt="Motor visualization preview"
                          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                        <div
                          class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm"
                        >
                          <span
                            class="inline-flex items-center gap-2 text-white text-sm font-medium px-4 py-2 rounded-lg bg-white/10 border border-white/20"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="w-4 h-4"
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                              />
                            </svg>
                            Change Image
                          </span>
                        </div>
                      </template>
                      <template v-else>
                        <div
                          class="p-4 rounded-full bg-slate-800 group-hover:scale-110 transition-transform duration-300 mb-3 border border-white/5 group-hover:border-indigo-500/30"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-slate-400 group-hover:text-indigo-400 transition-colors"
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
                        <p class="text-sm font-medium text-slate-300">
                          Click to upload motor image
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                          PNG, JPG up to 2MB
                        </p>
                      </template>
                    </div>
                    <input
                      ref="fileInput"
                      type="file"
                      accept="image/png, image/jpeg, image/jpg"
                      class="sr-only"
                      @change="handleFileChange"
                    />
                  </div>
                </div>

                <!-- Description -->
                <div class="space-y-2 md:col-span-2">
                  <label
                    for="motor-desc"
                    class="text-sm font-medium text-slate-400"
                    >Description</label
                  >
                  <textarea
                    id="motor-desc"
                    v-model="repo.description"
                    rows="3"
                    placeholder="Provide details about the motor state, history, etc."
                    class="w-full px-4 py-3 bg-slate-800/40 border border-white/5 rounded-xl text-slate-200 transition-all duration-200 resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 focus:bg-slate-800/80 hover:border-white/10 custom-scrollbar"
                  ></textarea>
                </div>
              </div>
            </div>

            <!-- Footer -->
            <div
              class="px-6 py-4 bg-slate-900 border-t border-white/5 flex flex-col-reverse sm:flex-row justify-end gap-3 rounded-b-2xl shrink-0 z-10"
            >
              <button
                type="button"
                @click="closeModal"
                :disabled="isLoading"
                class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-medium text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 border border-white/10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/20 disabled:opacity-50 disabled:cursor-not-allowed text-center"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isLoading"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-lg shadow-indigo-500/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 disabled:opacity-50 disabled:cursor-not-allowed group"
              >
                <template v-if="isLoading">
                  <svg
                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                  Processing...
                </template>
                <template v-else>
                  <span>{{ isEditing ? "Save Changes" : "Add" }}</span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 opacity-70 group-hover:translate-x-1 group-hover:opacity-100 transition-all"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7"
                      v-if="isEditing"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4v16m8-8H4"
                      v-else
                    />
                  </svg>
                </template>
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
</style>
