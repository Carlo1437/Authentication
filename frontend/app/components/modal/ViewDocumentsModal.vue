<script setup>
import { computed } from "vue";

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
  documentUrl: {
    type: String,
    default: "",
  },
  ownerName: {
    type: String,
    default: "Vehicle Owner",
  },
});

const emit = defineEmits(["close"]);

const closeModal = () => {
  emit("close");
};

const isImage = computed(() => {
  if (!props.documentUrl) return false;
  const imageExtensions = [".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg"];
  return imageExtensions.some((ext) =>
    props.documentUrl.toLowerCase().endsWith(ext),
  );
});

// Helper for display URL
const displayUrl = computed(() => {
  if (!props.documentUrl) return null;
  if (props.documentUrl.startsWith("http")) return props.documentUrl;
  return `http://localhost:8000/storage/${props.documentUrl}`;
});
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
          class="relative w-full max-w-4xl bg-slate-900 border border-white/10 rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]"
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
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  />
                </svg>
                Registration Document
              </h2>
              <p class="text-xs text-slate-500 mt-0.5">
                Viewing document for:
                <span class="text-slate-300 font-medium">{{ ownerName }}</span>
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

          <div
            class="flex-1 overflow-auto p-8 bg-slate-950/20 custom-scrollbar flex items-center justify-center font-sans"
          >
            <div
              v-if="documentUrl"
              class="w-full h-full flex items-center justify-center"
            >
              <div
                v-if="isImage"
                class="relative group rounded-2xl overflow-hidden border border-white/5 shadow-2xl transition-transform duration-500"
              >
                <img
                  :src="displayUrl"
                  :alt="`Document for ${ownerName}`"
                  class="max-w-full max-h-[60vh] object-contain rounded-xl"
                  @error="
                    (e) =>
                      (e.target.src =
                        'https://placehold.co/600x800/1e293b/94a3b8?text=Image+Load+Error')
                  "
                />
                <div
                  class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4 pointer-events-none"
                >
                  <span class="text-xs text-white/60"
                    >Official Vehicle Document Preview</span
                  >
                </div>
              </div>

              <div v-else class="text-center p-12 max-w-md">
                <div
                  class="w-20 h-20 bg-emerald-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/20"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-10 h-10 text-emerald-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                    />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-white">Document Preview</h3>
                <p class="text-slate-500 mt-2 mb-8 leading-relaxed">
                  This file format cannot be previewed directly. Please use the
                  button below to open or download the document.
                </p>
                <a
                  :href="displayUrl"
                  target="_blank"
                  class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-500/20"
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
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                    />
                  </svg>
                  Open in New Tab
                </a>
              </div>
            </div>

            <div v-else class="text-center py-20 opacity-40">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-16 h-16 text-slate-500 mx-auto mb-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
              </svg>
              <p class="text-xl font-medium">Document not found</p>
              <p class="text-sm mt-1">
                The requested file path appears to be invalid or was removed.
              </p>
            </div>
          </div>

          <div
            class="px-8 py-5 bg-white/[0.01] border-t border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4 shrink-0"
          >
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 rounded-full bg-slate-800 border border-white/5 flex items-center justify-center text-xs font-bold text-emerald-400"
              >
                {{ ownerName.charAt(0).toUpperCase() }}
              </div>
              <div>
                <p class="text-sm font-medium text-slate-200 leading-none">
                  {{ ownerName }}
                </p>
                <p class="text-[10px] text-slate-500 font-mono mt-1 uppercase">
                  Authenticated User
                </p>
              </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
              <button
                @click="closeModal"
                class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white bg-slate-800/50 hover:bg-slate-800 transition-all border border-white/5"
              >
                Close View
              </button>
              <a
                v-if="documentUrl"
                :href="displayUrl"
                target="_blank"
                download
                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-500/20 transition-all duration-200"
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
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                  />
                </svg>
                Download
              </a>
            </div>
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
</style>
