<script setup>
import { useCookie } from "#app";
import { computed, ref, onMounted, definePageMeta } from "#imports";

const user = useCookie("auth_user");
const token = useCookie("auth_token");
const totalUsers = ref(0);

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

onMounted(async () => {
  try {
    const users = await $fetch("http://localhost:8000/api/users", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    totalUsers.value = users.length;
  } catch {}
});

definePageMeta({
  layout: "dashboard",
  middleware: "auth",
});
</script>

<template>
  <div>
    <div class="mb-8">
      <h1
        class="text-3xl font-bold bg-gradient-to-r from-indigo-400 to-blue-300 bg-clip-text text-transparent"
      >
        Dashboard
      </h1>
      <p class="text-slate-500 mt-1 text-sm">
        Welcome back, {{ userData?.name?.split(" ")[0] || "User" }}
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      <div
        class="relative overflow-hidden bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-white/5 p-6 group hover:border-indigo-500/20 transition-all duration-300"
      >
        <div
          class="absolute -top-6 -right-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all duration-500"
        ></div>
        <div class="flex items-center gap-4">
          <div
            class="w-12 h-12 rounded-xl bg-indigo-500/15 flex items-center justify-center"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6 text-indigo-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
              />
            </svg>
          </div>
          <div>
            <p
              class="text-xs text-slate-500 uppercase tracking-wider font-medium"
            >
              Total Users
            </p>
            <p class="text-2xl font-bold text-white mt-0.5">
              {{ totalUsers }}
            </p>
          </div>
        </div>
      </div>

      <div
        class="relative overflow-hidden bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-white/5 p-6 group hover:border-blue-500/20 transition-all duration-300"
      >
        <div
          class="absolute -top-6 -right-6 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all duration-500"
        ></div>
        <div class="flex items-center gap-4">
          <div
            class="w-12 h-12 rounded-xl bg-blue-500/15 flex items-center justify-center"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6 text-blue-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
          </div>
          <div>
            <p
              class="text-xs text-slate-500 uppercase tracking-wider font-medium"
            >
              Your Account
            </p>
            <p class="text-lg font-bold text-white mt-0.5 truncate">
              {{ userData?.name || "–" }}
            </p>
          </div>
        </div>
      </div>

      <div
        class="relative overflow-hidden bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-white/5 p-6 group hover:border-emerald-500/20 transition-all duration-300"
      >
        <div
          class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500"
        ></div>
        <div class="flex items-center gap-4">
          <div
            class="w-12 h-12 rounded-xl bg-emerald-500/15 flex items-center justify-center"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6 text-emerald-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="1.5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"
              />
            </svg>
          </div>
          <div>
            <p
              class="text-xs text-slate-500 uppercase tracking-wider font-medium"
            >
              Session
            </p>
            <p class="text-lg font-bold text-emerald-400 mt-0.5">Active</p>
          </div>
        </div>
      </div>
    </div>

    <div
      class="bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-white/5 p-6"
    >
      <h2 class="text-lg font-semibold text-white mb-4">Quick Actions</h2>
      <div class="flex flex-wrap gap-3">
        <NuxtLink
          to="/users"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 rounded-xl text-sm font-medium hover:bg-indigo-500/20 hover:border-indigo-500/30 transition-all duration-200"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
            />
          </svg>
          View All Users
        </NuxtLink>
      </div>
    </div>
  </div>
</template>
