<script setup>
import { ref } from "vue";

const email = ref("");
const password = ref("");
const errorMessage = ref("");
const isLoading = ref(false);

const handleLogin = async () => {
  isLoading.value = true;
  errorMessage.value = "";

  try {
    const response = await $fetch("http://localhost:8000/api/login", {
      method: "POST",
      body: {
        email: email.value,
        password: password.value,
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
    console.error("Login failed:", error);
    if (error.data?.errors) {
      const firstError = Object.values(error.data.errors)[0];
      errorMessage.value = Array.isArray(firstError)
        ? firstError[0]
        : firstError;
    } else {
      errorMessage.value =
        error.data?.message || "Invalid credentials. Please try again.";
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
      class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4"
    >
      <div
        class="w-full max-w-[440px] bg-white/5 backdrop-blur-xl rounded-3xl border border-white/10 shadow-2xl p-8 md:p-12 animate-in fade-in slide-in-from-bottom-4 duration-700"
      >
        <div class="text-center mb-10">
          <h2
            class="text-4xl font-bold mb-2 bg-gradient-to-r from-indigo-400 to-blue-200 bg-clip-text text-transparent"
          >
            Welcome Back
          </h2>
          <p class="text-slate-400 text-sm">Please sign in to your account</p>
        </div>

        <div
          v-if="errorMessage"
          class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl"
        >
          <p class="text-red-400 text-sm text-center font-medium">
            {{ errorMessage }}
          </p>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-6">
          <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-slate-200 ml-1"
              >Email</label
            >
            <div class="relative group">
              <input
                type="email"
                id="email"
                v-model="email"
                placeholder="name@example.com"
                required
                class="w-full px-4 py-3.5 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
              />
            </div>
          </div>

          <div class="space-y-2">
            <div class="flex justify-between items-center px-1">
              <label for="password" class="text-sm font-medium text-slate-200"
                >Password</label
              >
            </div>
            <div class="relative group">
              <input
                type="password"
                id="password"
                v-model="password"
                placeholder="••••••••"
                required
                class="w-full px-4 py-3.5 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300"
              />
            </div>
          </div>
          <a
            href="#"
            class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors"
            >Forgot password?</a
          >

          <button
            type="submit"
            :disabled="isLoading"
            class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_25px_rgba(79,70,229,0.5)] transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 mt-2 disabled:opacity-50 disabled:cursor-not-allowed"
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
              Signing In...
            </div>
            <template v-else>Sign In</template>
          </button>
        </form>

        <div class="mt-10 text-center text-sm text-slate-400">
          <p>
            Don't have an account?
            <NuxtLink
              to="/register"
              class="text-indigo-400 font-medium hover:underline ml-1"
              >Create account</NuxtLink
            >
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
