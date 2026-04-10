<script setup>
import { navigateTo, useCookie } from "#app";
import { computed, ref } from "#imports";

const user = useCookie("auth_user");
const token = useCookie("auth_token");
const sidebarOpen = ref(true);

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

const logout = async () => {
  try {
    await $fetch("http://localhost:8000/api/logout", {
      method: "POST",
      headers: { Authorization: `Bearer ${token.value}` },
    });
  } catch {}
  token.value = null;
  user.value = null;
  navigateTo("/login");
};

const route = useRoute();
const navItems = [
  {
    name: "Dashboard",
    path: "/",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>`,
  },
  {
    name: "Users",
    path: "/users",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>`,
  },

  {
    name: "Motor Registers",
    path: "/motor-repo/motor_registers",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>`,
  },

  {
    name: "Motor Repos",
    path: "/motor-repo/motor-repos",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>`,
  },

  {
    name: "Vehicle Registration",
    path: "/admin/VehicleRegistration",
    icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>`,
  },
];
</script>

<template>
  <div class="min-h-screen bg-slate-950 text-white font-sans flex">
    <aside
      class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 bg-slate-900/80 backdrop-blur-xl border-r border-white/5 transition-transform duration-300"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
      <div class="flex items-center gap-3 px-6 h-16 border-b border-white/5">
        <div
          class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-sm font-bold shadow-lg shadow-indigo-500/25"
        >
          A
        </div>
        <span
          class="text-lg font-bold bg-gradient-to-r from-indigo-400 to-blue-300 bg-clip-text text-transparent"
          >AuthApp</span
        >
      </div>

      <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
        <NuxtLink
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200"
          :class="
            route.path === item.path
              ? 'bg-indigo-500/15 text-indigo-300 shadow-lg shadow-indigo-500/5'
              : 'text-slate-400 hover:text-white hover:bg-white/5'
          "
        >
          <span v-html="item.icon"></span>
          {{ item.name }}
        </NuxtLink>
      </nav>

      <div class="px-3 pb-6 space-y-3">
        <ClientOnly>
          <div
            v-if="userData"
            class="px-4 py-3 bg-white/5 rounded-xl border border-white/5"
          >
            <p class="text-sm font-medium text-white truncate">
              {{ userData.name }}
            </p>
            <p class="text-xs text-slate-500 truncate">{{ userData.email }}</p>
          </div>
        </ClientOnly>
        <button
          @click="logout"
          class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 bg-red-500/10 border border-red-500/10 hover:bg-red-500/20 hover:border-red-500/20 transition-all duration-200"
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
              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"
            />
          </svg>
          Sign Out
        </button>
      </div>
    </aside>

    <div
      class="flex-1 flex flex-col transition-all duration-300"
      :class="sidebarOpen ? 'ml-64' : 'ml-0'"
    >
      <header
        class="sticky top-0 z-20 flex items-center justify-between h-16 px-6 bg-slate-950/80 backdrop-blur-xl border-b border-white/5"
      >
        <button
          @click="sidebarOpen = !sidebarOpen"
          class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-colors"
        >
          <svg
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
              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
            />
          </svg>
        </button>

        <div class="flex items-center gap-3">
          <ClientOnly>
            <div
              v-if="userData"
              class="flex items-center gap-3 px-4 py-2 bg-white/5 rounded-xl border border-white/5"
            >
              <div
                class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-bold"
              >
                {{ userData.name?.charAt(0)?.toUpperCase() }}
              </div>
              <span class="text-sm font-medium text-slate-300">{{
                userData.name
              }}</span>
            </div>
          </ClientOnly>
        </div>
      </header>

      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>
