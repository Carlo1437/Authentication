<script setup>
import { ref } from "#imports";
import { useCookie } from "#app";

const emit = defineEmits(["user-added"]);
const token = useCookie("auth_token");

const showAddModal = ref(false);
const newUser = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const showNewPassword = ref(false);
const showNewConfirmPassword = ref(false);
const addError = ref("");
const addLoading = ref(false);

const openAddModal = () => {
  newUser.value = {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  };
  addError.value = "";
  showNewPassword.value = false;
  showNewConfirmPassword.value = false;
  showAddModal.value = true;
};

const submitAdd = async () => {
  addLoading.value = true;
  addError.value = "";
  try {
    await $fetch("http://localhost:8000/api/users", {
      method: "POST",
      headers: { Authorization: `Bearer ${token.value}` },
      body: {
        name: newUser.value.name,
        email: newUser.value.email,
        password: newUser.value.password,
        password_confirmation: newUser.value.password_confirmation,
      },
    });
    showAddModal.value = false;
    emit("user-added");
  } catch (error) {
    if (error.data?.errors) {
      const first = Object.values(error.data.errors)[0];
      addError.value = Array.isArray(first) ? first[0] : first;
    } else {
      addError.value = error.data?.message || "Failed to add user.";
    }
  } finally {
    addLoading.value = false;
  }
};
</script>

<template>
  <div>
    <button
      @click="openAddModal"
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
      Add User
    </button>

    <Teleport to="body">
      <Transition name="modal">
        <div
          v-if="showAddModal"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
          <div
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            @click="showAddModal = false"
          ></div>

          <div
            class="relative w-full max-w-md bg-slate-900 border border-white/10 rounded-2xl shadow-2xl p-6 md:p-8"
          >
            <h2 class="text-xl font-bold text-white mb-6">Add User</h2>

            <div
              v-if="addError"
              class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl"
            >
              <p class="text-red-400 text-sm">{{ addError }}</p>
            </div>

            <form @submit.prevent="submitAdd" class="space-y-5">
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Name</label>
                <input
                  v-model="newUser.name"
                  type="text"
                  required
                  placeholder="Full name"
                  class="w-full px-4 py-3 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                />
              </div>
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300">Email</label>
                <input
                  v-model="newUser.email"
                  type="email"
                  required
                  placeholder="Email address"
                  class="w-full px-4 py-3 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                />
              </div>
              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300"
                  >Password</label
                >
                <div class="relative">
                  <input
                    v-model="newUser.password"
                    :type="showNewPassword ? 'text' : 'password'"
                    required
                    minlength="8"
                    placeholder="Minimum 8 characters"
                    class="w-full px-4 py-3 pr-12 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                  />
                  <button
                    type="button"
                    @click="showNewPassword = !showNewPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-500 hover:text-slate-300 transition-colors"
                  >
                    <svg
                      v-if="!showNewPassword"
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
                    v-model="newUser.password_confirmation"
                    :type="showNewConfirmPassword ? 'text' : 'password'"
                    required
                    minlength="8"
                    placeholder="Confirm password"
                    class="w-full px-4 py-3 pr-12 bg-slate-800/60 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                  />
                  <button
                    type="button"
                    @click="showNewConfirmPassword = !showNewConfirmPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-500 hover:text-slate-300 transition-colors"
                  >
                    <svg
                      v-if="!showNewConfirmPassword"
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
                  @click="showAddModal = false"
                  class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 border border-white/10 transition-all duration-200"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  class="px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-lg shadow-indigo-500/20 transition-all duration-200"
                >
                  Add User
                </button>
              </div>
            </form>
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
</style>
