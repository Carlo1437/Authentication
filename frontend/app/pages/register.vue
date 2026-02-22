<script setup>
import { ref } from "vue";

const name = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const errorMessage = ref("");
const isLoading = ref(false);

const handleRegister = async () => {
  if (password.value !== password_confirmation.value) {
    errorMessage.value = "Passwords do not match.";
    return;
  }

  isLoading.value = true;
  errorMessage.value = "";

  try {
    const response = await $fetch("http://localhost:8000/api/register", {
      method: "POST",
      body: {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
        device_name: "nuxt_app",
      },
    });

    if (response.token) {
      const token = useCookie("auth_token", {
        maxAge: 60 * 60 * 24 * 7,
        path: "/",
      });
      token.value = response.token;

      const user = useCookie("auth_user", {
        maxAge: 60 * 60 * 24 * 7,
        path: "/",
      });
      user.value = JSON.stringify(response.user);

      navigateTo("/");
    }
  } catch (error) {
    console.error("Registration failed:", error);
    if (error.data?.errors) {
      const firstError = Object.values(error.data.errors)[0];
      errorMessage.value = Array.isArray(firstError)
        ? firstError[0]
        : firstError;
    } else {
      errorMessage.value =
        error.data?.message || "Registration failed. Please try again.";
    }
  } finally {
    isLoading.value = false;
  }
};

definePageMeta({
  layout: false,
  middleware: "guest",
});
</script>

<template>
  <div
    class="relative min-h-screen bg-slate-950 font-sans text-white overflow-hidden selection:bg-indigo-500/30"
  >
    <ClientOnly>
      <div class="fixed inset-0 z-0 pointer-events-none">
        <div
          class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px] animate-pulse"
        ></div>
        <div
          class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-blue-600/20 rounded-full blur-[120px] animate-pulse"
          style="animation-delay: 2s"
        ></div>
      </div>
    </ClientOnly>

    <div
      class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-12"
    >
      <div
        class="w-full max-w-[440px] bg-white/5 backdrop-blur-xl rounded-3xl border border-white/10 shadow-2xl p-8 md:p-12 animate-in fade-in slide-in-from-bottom-4 duration-700"
      >
        <div class="text-center mb-10">
          <h2
            class="text-4xl font-bold mb-2 bg-gradient-to-r from-indigo-400 to-blue-200 bg-clip-text text-transparent"
          >
            Get Started
          </h2>
          <p class="text-slate-400 text-sm">Create your new account</p>
        </div>

        <div
          v-if="errorMessage"
          class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl"
        >
          <p class="text-red-400 text-sm text-center font-medium">
            {{ errorMessage }}
          </p>
        </div>

        <form @submit.prevent="handleRegister" class="space-y-4">
          <div class="space-y-2">
            <label for="name" class="text-sm font-medium text-slate-200 ml-1"
              >Full Name</label
            >
            <input
              type="text"
              id="name"
              v-model="name"
              placeholder="John Doe"
              required
              class="w-full px-4 py-3 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
            />
          </div>

          <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-slate-200 ml-1"
              >Email</label
            >
            <input
              type="email"
              id="email"
              v-model="email"
              placeholder="name@example.com"
              required
              class="w-full px-4 py-3 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
            />
          </div>

          <div class="space-y-2">
            <label
              for="password"
              class="text-sm font-medium text-slate-200 ml-1"
              >Password</label
            >
            <input
              type="password"
              id="password"
              v-model="password"
              placeholder="••••••••"
              required
              class="w-full px-4 py-3 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
            />
          </div>

          <div class="space-y-2">
            <label
              for="password_confirmation"
              class="text-sm font-medium text-slate-200 ml-1"
              >Confirm Password</label
            >
            <input
              type="password"
              id="password_confirmation"
              v-model="password_confirmation"
              placeholder="••••••••"
              required
              class="w-full px-4 py-3 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
            />
          </div>

          <button
            type="submit"
            :disabled="isLoading"
            class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_25px_rgba(79,70,229,0.5)] transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 mt-4 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <div v-if="isLoading" class="flex items-center justify-center">
              <svg
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
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
              Creating Account...
            </div>
            <template v-else>Create Account</template>
          </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
          <p>
            Already have an account?
            <NuxtLink
              to="/login"
              class="text-indigo-400 font-medium hover:underline ml-1"
              >Sign in</NuxtLink
            >
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
