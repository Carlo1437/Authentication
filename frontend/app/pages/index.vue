<script setup>
import { navigateTo, useCookie } from "#app";
import { computed, definePageMeta } from "#imports";

const user = useCookie("auth_user");
const token = useCookie("auth_token");

const userData = computed(() => {
  if (!user.value) return null;
  if (typeof user.value === "string") {
    try {
      return JSON.parse(user.value);
    } catch {
      return null;
    }
  }
  return user.value;
});

const logout = () => {
  token.value = null;
  user.value = null;
  navigateTo("/login");
};

definePageMeta({
  middleware: "auth",
});
</script>

<template>
  <div
    class="min-h-screen bg-slate-950 text-white font-sans flex flex-col items-center justify-center p-4"
  >
    <div
      class="w-full max-w-2xl bg-white/5 backdrop-blur-xl rounded-3xl border border-white/10 p-8 md:p-12 text-center shadow-2xl"
    >
      <h1
        class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-indigo-400 to-blue-200 bg-clip-text text-transparent"
      >
        Welcome Home
      </h1>

      <div
        v-if="userData"
        class="mb-8 p-6 bg-indigo-500/10 border border-indigo-500/20 rounded-2xl"
      >
        <p
          class="text-slate-400 mb-2 uppercase tracking-widest text-xs font-bold"
        >
          Logged in as
        </p>
        <p class="text-2xl font-semibold text-white">
          {{ userData.name }}
        </p>
        <p class="text-indigo-300 font-mono text-sm mt-1">
          {{ userData.email }}
        </p>
      </div>

      <p class="text-slate-400 mb-10 max-w-md mx-auto leading-relaxed">
        Your authentication session is now correctly persisting across page
        reloads.
      </p>

      <button
        @click="logout"
        class="px-8 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 rounded-xl font-medium transition-all duration-300 hover:scale-105 active:scale-95"
      >
        Sign Out
      </button>
    </div>
  </div>
</template>
