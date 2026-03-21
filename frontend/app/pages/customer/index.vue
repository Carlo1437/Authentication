<script setup>
import { ref, onMounted } from "vue";

const isDark = ref(false);

onMounted(() => {
  if (process.client) {
    isDark.value =
      localStorage.getItem("theme") === "dark" ||
      (!("theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches);
    if (isDark.value) {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
  }
});

const toggleTheme = () => {
  isDark.value = !isDark.value;
  if (process.client) {
    localStorage.setItem("theme", isDark.value ? "dark" : "light");
    if (isDark.value) {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
  }
};

useHead({
  title: "Register Your Vehicle Online - VehicReg",
  meta: [
    {
      name: "description",
      content:
        "Fast, secure, and easy online vehicle registration system. Skip the lines and register anytime.",
    },
  ],
});
</script>

<template>
  <div
    class="min-h-screen bg-slate-50 dark:bg-slate-900 dark:bg-slate-950 font-sans text-slate-800 dark:text-slate-200 selection:bg-blue-500 selection:text-white flex flex-col pt-16 transition-colors duration-300"
  >
    <nav
      class="fixed top-0 inset-x-0 z-50 bg-white dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 transition-colors duration-300"
    >
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between transition-colors duration-300"
      >
        <div class="flex items-center gap-2 transition-colors duration-300">
          <div
            class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white font-bold text-xl shadow-md transition-colors duration-300"
          >
            V
          </div>
          <span
            class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-slate-700 transition-colors duration-300"
            >VehicleReg</span
          >
        </div>
        <div
          class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600 dark:text-slate-400 transition-colors duration-300"
        >
          <a
            href="#how-it-works"
            class="hover:text-blue-600 transition-colors transition-colors duration-300"
            >How It Works</a
          >
          <a
            href="#features"
            class="hover:text-blue-600 transition-colors transition-colors duration-300"
            >Features</a
          >
          <a
            href="#requirements"
            class="hover:text-blue-600 transition-colors transition-colors duration-300"
            >Requirements</a
          >
        </div>
        <div class="flex items-center gap-4 transition-colors duration-300">
          <button
            @click="toggleTheme"
            class="p-2 mr-2 rounded-full text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors transition-colors duration-300"
            aria-label="Toggle Dark Mode"
          >
            <svg
              v-if="!isDark"
              class="w-5 h-5 transition-colors duration-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
              />
            </svg>
            <svg
              v-else
              class="w-5 h-5 transition-colors duration-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
              />
            </svg>
          </button>
          <NuxtLink
            to="/login"
            class="text-sm font-medium text-slate-600 dark:text-slate-400 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors transition-colors duration-300"
            >Log in</NuxtLink
          >
          <NuxtLink
            to="/register"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-full shadow-sm hover:shadow transition-all transition-colors duration-300"
          >
            Get Started
          </NuxtLink>
        </div>
      </div>
    </nav>

    <section
      class="relative overflow-hidden pt-20 pb-32 sm:pt-32 sm:pb-40 lg:pb-48 flex-1 transition-colors duration-300"
    >
      <div
        class="absolute inset-x-0 top-0 h-full bg-gradient-to-b from-blue-50/50 via-white to-white -z-10 transition-colors duration-300"
      ></div>
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative transition-colors duration-300"
      >
        <div
          class="max-w-3xl mx-auto text-center transition-colors duration-300"
        >
          <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold tracking-wide uppercase mb-8 shadow-sm ring-1 ring-blue-600/10 transition-colors duration-300"
          >
            <span class="relative flex h-2 w-2 transition-colors duration-300">
              <span
                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75 transition-colors duration-300"
              ></span>
              <span
                class="relative inline-flex rounded-full h-2 w-2 bg-blue-600 transition-colors duration-300"
              ></span>
            </span>
            Online Vehicle Registration System
          </div>
          <h1
            class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight leading-tight mb-6 transition-colors duration-300"
          >
            Register Your Vehicle Online in
            <span
              class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-emerald-500 transition-colors duration-300"
              >Minutes</span
            >
          </h1>
          <p
            class="text-lg sm:text-xl text-slate-600 dark:text-slate-400 mb-10 leading-relaxed max-w-2xl mx-auto transition-colors duration-300"
          >
            Experience the convenience and speed of modern government service.
            Skip the long lines and process your vehicle registration from the
            comfort of your home.
          </p>
          <div
            class="flex flex-col sm:flex-row items-center justify-center gap-4 transition-colors duration-300"
          >
            <NuxtLink
              to="/customer/OnlineRegistrationPage"
              class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3.5 rounded-full text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 group transition-colors duration-300"
            >
              Register Now
              <svg
                class="w-5 h-5 ml-2 -mr-1 group-hover:translate-x-1 transition-transform transition-colors duration-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M14 5l7 7m0 0l-7 7m7-7H3"
                />
              </svg>
            </NuxtLink>
            <a
              href="/customer/LearnMorepage"
              class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3.5 rounded-full text-base font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 dark:bg-slate-900 dark:bg-slate-950 hover:border-slate-300 dark:border-slate-600 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300"
            >
              Learn More
            </a>
          </div>
        </div>

        <div
          class="mt-20 sm:mt-28 max-w-[100vw] overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 select-none py-4 transition-colors duration-300"
        >
          <div class="text-center mb-10 px-4 transition-colors duration-300">
            <p
              class="text-sm font-semibold text-blue-600 uppercase tracking-wide transition-colors duration-300"
            >
              Nationwide Coverage
            </p>
            <h3
              class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900 dark:text-slate-100 transition-colors duration-300"
            >
              Supported Vehicle Classifications
            </h3>
            <p
              class="mt-3 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto text-sm sm:text-base transition-colors duration-300"
            >
              We process registrations for almost all types of motorized
              conveyances. Our streamlined system dynamically adjusts
              requirements based on your vehicle class.
            </p>
          </div>

          <div
            class="relative w-full overflow-hidden mask-linear pb-4 transition-colors duration-300"
          >
            <div
              class="flex animate-slider hover:animation-play-state-paused w-max transition-colors duration-300"
            >
              <!-- Group 1 -->
              <div
                class="flex gap-4 sm:gap-6 px-2 sm:px-3 text-left transition-colors duration-300"
              >
                <!-- Item 1 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Private Vehicles"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Private Vehicles</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Sedans, SUVs, Pickups
                    </p>
                  </div>
                </div>
                <!-- Item 2 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Commercial Trucks"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Commercial Trucks</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Light to heavy duty logistics
                    </p>
                  </div>
                </div>
                <!-- Item 3 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Motorcycles"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Motorcycles</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Two and three-wheeled conveyances
                    </p>
                  </div>
                </div>
                <!-- Item 4 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1593941707882-a5bba14938c7?q=80&w=800&auto=format&fit=crop"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Electric Vehicles"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Electric Vehicles</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Eco-friendly & Hybrid cars
                    </p>
                  </div>
                </div>
                <!-- Item 5 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Public Utility"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Public Utility</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Transport buses, shuttles, taxis
                    </p>
                  </div>
                </div>
              </div>

              <!-- Group 2 (Duplicate for infinite loop) -->
              <div
                class="flex gap-4 sm:gap-6 px-2 sm:px-3 text-left transition-colors duration-300"
              >
                <!-- Item 1 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Private Vehicles"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Private Vehicles</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Sedans, SUVs, Pickups
                    </p>
                  </div>
                </div>
                <!-- Item 2 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Commercial Trucks"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Commercial Trucks</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Light to heavy duty logistics
                    </p>
                  </div>
                </div>
                <!-- Item 3 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1558981403-c5f9899a28bc?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Motorcycles"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Motorcycles</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Two and three-wheeled conveyances
                    </p>
                  </div>
                </div>
                <!-- Item 4 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1593941707882-a5bba14938c7?q=80&w=800&auto=format&fit=crop"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Electric Vehicles"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Electric Vehicles</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Eco-friendly & Hybrid cars
                    </p>
                  </div>
                </div>
                <!-- Item 5 -->
                <div
                  class="w-64 h-44 sm:w-80 sm:h-56 rounded-2xl overflow-hidden shrink-0 shadow-lg relative group border border-slate-200 dark:border-slate-700 transition-colors duration-300"
                >
                  <img
                    src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=800"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 transition-colors duration-300"
                    alt="Public Utility"
                  />
                  <div
                    class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-12 pb-4 px-6 transition-colors duration-300"
                  >
                    <span
                      class="text-white font-bold tracking-wide transition-colors duration-300"
                      >Public Utility</span
                    >
                    <p
                      class="text-slate-300 text-xs mt-1 transition-colors duration-300"
                    >
                      Transport buses, shuttles, taxis
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section
      id="how-it-works"
      class="py-24 bg-white dark:bg-slate-800 relative transition-colors duration-300"
    >
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300"
      >
        <div
          class="text-center max-w-2xl mx-auto mb-16 transition-colors duration-300"
        >
          <h2
            class="text-blue-600 font-semibold tracking-wide uppercase text-sm mb-3 transition-colors duration-300"
          >
            Simple Process
          </h2>
          <p
            class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-slate-100 sm:text-4xl transition-colors duration-300"
          >
            How It Works
          </p>
          <p
            class="mt-4 text-lg text-slate-600 dark:text-slate-400 transition-colors duration-300"
          >
            Complete your registration in three easy steps. No more waiting in
            long lines.
          </p>
        </div>

        <div
          class="grid md:grid-cols-3 gap-8 lg:gap-12 relative transition-colors duration-300"
        >
          <div
            class="hidden md:block absolute top-12 left-[16.66%] right-[16.66%] h-0.5 bg-gradient-to-r from-blue-100 via-emerald-100 to-blue-100 z-0 transition-colors duration-300"
          ></div>

          <div
            class="relative z-10 flex flex-col items-center text-center group transition-colors duration-300"
          >
            <div
              class="w-24 h-24 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 flex items-center justify-center border border-slate-100 dark:border-slate-700 text-blue-600 mb-6 group-hover:scale-110 transition-transform duration-300 transition-colors duration-300"
            >
              <svg
                class="w-10 h-10 transition-colors duration-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                />
              </svg>
            </div>
            <h3
              class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3 transition-colors duration-300"
            >
              1. Enter vehicle details
            </h3>
            <p
              class="text-slate-600 dark:text-slate-400 text-base leading-relaxed transition-colors duration-300"
            >
              Provide basic information about your vehicle including plate
              number, chassis, and make.
            </p>
          </div>

          <div
            class="relative z-10 flex flex-col items-center text-center group transition-colors duration-300"
          >
            <div
              class="w-24 h-24 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 flex items-center justify-center border border-slate-100 dark:border-slate-700 text-emerald-500 mb-6 group-hover:scale-110 transition-transform duration-300 transition-colors duration-300"
            >
              <svg
                class="w-10 h-10 transition-colors duration-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
                />
              </svg>
            </div>
            <h3
              class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3 transition-colors duration-300"
            >
              2. Upload documents
            </h3>
            <p
              class="text-slate-600 dark:text-slate-400 text-base leading-relaxed transition-colors duration-300"
            >
              Securely upload photos or scans of your required documents (OR/CR,
              valid ID, insurance).
            </p>
          </div>

          <div
            class="relative z-10 flex flex-col items-center text-center group transition-colors duration-300"
          >
            <div
              class="w-24 h-24 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 flex items-center justify-center border border-slate-100 dark:border-slate-700 text-blue-600 mb-6 group-hover:scale-110 transition-transform duration-300 transition-colors duration-300"
            >
              <svg
                class="w-10 h-10 transition-colors duration-300"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <h3
              class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3 transition-colors duration-300"
            >
              3. Submit & Track
            </h3>
            <p
              class="text-slate-600 dark:text-slate-400 text-base leading-relaxed transition-colors duration-300"
            >
              Submit your application and track the real-time status directly
              from your dashboard.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section
      id="features"
      class="py-24 bg-slate-50 dark:bg-slate-900 dark:bg-slate-950 border-y border-slate-200 dark:border-slate-700/60 transition-colors duration-300"
    >
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300"
      >
        <div
          class="lg:grid lg:grid-cols-2 lg:gap-16 items-center transition-colors duration-300"
        >
          <div class="mb-12 lg:mb-0 transition-colors duration-300">
            <h2
              class="text-blue-600 font-semibold tracking-wide uppercase text-sm mb-3 transition-colors duration-300"
            >
              Why Choose Us
            </h2>
            <p
              class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-slate-100 sm:text-4xl mb-6 transition-colors duration-300"
            >
              Designed for speed and reliability
            </p>
            <p
              class="text-lg text-slate-600 dark:text-slate-400 mb-8 leading-relaxed transition-colors duration-300"
            >
              Our platform is built to make vehicle registration as seamless as
              possible. We prioritize security and efficiency so you can focus
              on more important things.
            </p>
            <div class="space-y-6 transition-colors duration-300">
              <div class="flex items-start transition-colors duration-300">
                <div class="flex-shrink-0 transition-colors duration-300">
                  <div
                    class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 transition-colors duration-300">
                  <h4
                    class="text-xl font-bold text-slate-900 dark:text-slate-100 transition-colors duration-300"
                  >
                    Fast Processing
                  </h4>
                  <p
                    class="mt-1 text-slate-600 dark:text-slate-400 transition-colors duration-300"
                  >
                    Automated verification systems cut processing times in half.
                  </p>
                </div>
              </div>
              <div class="flex items-start transition-colors duration-300">
                <div class="flex-shrink-0 transition-colors duration-300">
                  <div
                    class="flex items-center justify-center h-12 w-12 rounded-xl bg-emerald-100 text-emerald-600 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 transition-colors duration-300">
                  <h4
                    class="text-xl font-bold text-slate-900 dark:text-slate-100 transition-colors duration-300"
                  >
                    Secure Data Handling
                  </h4>
                  <p
                    class="mt-1 text-slate-600 dark:text-slate-400 transition-colors duration-300"
                  >
                    Your information is encrypted with bank-level security
                    protocols.
                  </p>
                </div>
              </div>
              <div class="flex items-start transition-colors duration-300">
                <div class="flex-shrink-0 transition-colors duration-300">
                  <div
                    class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 transition-colors duration-300">
                  <h4
                    class="text-xl font-bold text-slate-900 dark:text-slate-100 transition-colors duration-300"
                  >
                    Real-time Status Tracking
                  </h4>
                  <p
                    class="mt-1 text-slate-600 dark:text-slate-400 transition-colors duration-300"
                  >
                    Know exactly where your application is in the process at any
                    time.
                  </p>
                </div>
              </div>
              <div class="flex items-start transition-colors duration-300">
                <div class="flex-shrink-0 transition-colors duration-300">
                  <div
                    class="flex items-center justify-center h-12 w-12 rounded-xl bg-indigo-100 text-indigo-600 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 transition-colors duration-300">
                  <h4
                    class="text-xl font-bold text-slate-900 dark:text-slate-100 transition-colors duration-300"
                  >
                    Accessible Anytime
                  </h4>
                  <p
                    class="mt-1 text-slate-600 dark:text-slate-400 transition-colors duration-300"
                  >
                    24/7 portal access from your desktop, tablet, or mobile
                    phone.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div
            class="relative rounded-2xl overflow-hidden shadow-2xl lg:h-[600px] w-full bg-slate-200 dark:bg-slate-700 transition-colors duration-300"
          >
            <div
              class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-emerald-400 opacity-90 mix-blend-multiply transition-colors duration-300"
            ></div>
            <img
              src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=1000"
              alt="Dashboard"
              class="w-full h-full object-cover object-center grayscale mix-blend-overlay transition-colors duration-300"
            />
          </div>
        </div>
      </div>
    </section>

    <section
      id="requirements"
      class="py-24 bg-white dark:bg-slate-800 transition-colors duration-300"
    >
      <div
        class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300"
      >
        <div
          class="bg-blue-600 rounded-3xl overflow-hidden shadow-2xl relative transition-colors duration-300"
        >
          <div
            class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white dark:bg-slate-800 opacity-10 rounded-full blur-3xl transition-colors duration-300"
          ></div>
          <div
            class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-emerald-400 opacity-20 rounded-full blur-2xl transition-colors duration-300"
          ></div>

          <div
            class="relative p-8 sm:p-12 md:p-16 text-gray grid md:grid-cols-2 gap-12 items-center transition-colors duration-300"
          >
            <div>
              <h2
                class="text-3xl font-extrabold mb-4 transition-colors duration-300"
              >
                Prepare Your Documents
              </h2>
              <p
                class="text-blue-100 text-lg mb-8 transition-colors duration-300"
              >
                To ensure a fast and smooth registration process, please have
                soft copies of the following documents ready before applying.
              </p>
              <NuxtLink
                to="/requirements-guide"
                class="inline-flex items-center text-white font-semibold hover:text-blue-200 transition-colors transition-colors duration-300"
              >
                Read full guidelines
                <svg
                  class="w-5 h-5 ml-2 transition-colors duration-300"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                  />
                </svg>
              </NuxtLink>
            </div>

            <div
              class="bg-white dark:bg-slate-800/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 transition-colors duration-300"
            >
              <ul class="space-y-4 transition-colors duration-300">
                <li
                  class="flex items-center gap-4 transition-colors duration-300"
                >
                  <div
                    class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-300 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </div>
                  <span
                    class="font-medium text-lg transition-colors duration-300"
                    >Official Receipt (OR)</span
                  >
                </li>
                <li
                  class="flex items-center gap-4 transition-colors duration-300"
                >
                  <div
                    class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-300 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </div>
                  <span
                    class="font-medium text-lg transition-colors duration-300"
                    >Certificate of Registration (CR)</span
                  >
                </li>
                <li
                  class="flex items-center gap-4 transition-colors duration-300"
                >
                  <div
                    class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-300 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </div>
                  <span
                    class="font-medium text-lg transition-colors duration-300"
                    >Valid Identification (ID)</span
                  >
                </li>
                <li
                  class="flex items-center gap-4 transition-colors duration-300"
                >
                  <div
                    class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-300 transition-colors duration-300"
                  >
                    <svg
                      class="h-6 w-6 transition-colors duration-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </div>
                  <span
                    class="font-medium text-lg transition-colors duration-300"
                    >Motor Vehicle Insurance</span
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section
      class="py-24 bg-slate-50 dark:bg-slate-900 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-700/60 transition-colors duration-300"
    >
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300"
      >
        <div class="text-center mb-16 transition-colors duration-300">
          <h2
            class="text-blue-600 font-semibold tracking-wide uppercase text-sm mb-3 transition-colors duration-300"
          >
            Feedback
          </h2>
          <p
            class="text-3xl font-extrabold text-slate-900 dark:text-slate-100 transition-colors duration-300"
          >
            What citizens are saying
          </p>
        </div>

        <div
          class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 transition-colors duration-300"
        >
          <div
            class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition transition-colors duration-300"
          >
            <div
              class="flex items-center gap-1 mb-4 text-emerald-500 transition-colors duration-300"
            >
              <svg
                v-for="i in 5"
                :key="i"
                class="w-5 h-5 fill-current transition-colors duration-300"
                viewBox="0 0 20 20"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>
            <p
              class="text-slate-600 dark:text-slate-400 mb-6 line-clamp-4 transition-colors duration-300"
            >
              "The online process took me less than 15 minutes. It's incredibly
              straightforward and uploading the documents was a breeze. Highly
              recommended!"
            </p>
            <div class="flex items-center gap-4 transition-colors duration-300">
              <div
                class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg transition-colors duration-300"
              >
                MJ
              </div>
              <div>
                <p
                  class="font-bold text-slate-900 dark:text-slate-100 text-sm transition-colors duration-300"
                >
                  Maria Juan
                </p>
                <p
                  class="text-xs text-slate-500 transition-colors duration-300"
                >
                  Verified User
                </p>
              </div>
            </div>
          </div>

          <div
            class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition transition-colors duration-300"
          >
            <div
              class="flex items-center gap-1 mb-4 text-emerald-500 transition-colors duration-300"
            >
              <svg
                v-for="i in 5"
                :key="i"
                class="w-5 h-5 fill-current transition-colors duration-300"
                viewBox="0 0 20 20"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>
            <p
              class="text-slate-600 dark:text-slate-400 mb-6 line-clamp-4 transition-colors duration-300"
            >
              "I love the real-time tracking feature. Instead of wondering if my
              application was received, I could see exactly what stage it was
              at."
            </p>
            <div class="flex items-center gap-4 transition-colors duration-300">
              <div
                class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg transition-colors duration-300"
              >
                RC
              </div>
              <div>
                <p
                  class="font-bold text-slate-900 dark:text-slate-100 text-sm transition-colors duration-300"
                >
                  Roberto Cruz
                </p>
                <p
                  class="text-xs text-slate-500 transition-colors duration-300"
                >
                  Verified User
                </p>
              </div>
            </div>
          </div>

          <div
            class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition hidden md:block lg:block transition-colors duration-300"
          >
            <div
              class="flex items-center gap-1 mb-4 text-emerald-500 transition-colors duration-300"
            >
              <svg
                v-for="i in 5"
                :key="i"
                class="w-5 h-5 fill-current transition-colors duration-300"
                viewBox="0 0 20 20"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                />
              </svg>
            </div>
            <p
              class="text-slate-600 dark:text-slate-400 mb-6 line-clamp-4 transition-colors duration-300"
            >
              "Far better than the old system. The user interface is clean,
              modern, and it works perfectly on my phone browser."
            </p>
            <div class="flex items-center gap-4 transition-colors duration-300">
              <div
                class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg transition-colors duration-300"
              >
                AS
              </div>
              <div>
                <p
                  class="font-bold text-slate-900 dark:text-slate-100 text-sm transition-colors duration-300"
                >
                  Anna Santos
                </p>
                <p
                  class="text-xs text-slate-500 transition-colors duration-300"
                >
                  Verified User
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section
      class="bg-slate-900 dark:bg-slate-950 relative overflow-hidden py-20 lg:py-24 transition-colors duration-300"
    >
      <div class="absolute inset-0 z-0 transition-colors duration-300">
        <div
          class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply opacity-20 blur-3xl transition-colors duration-300"
        ></div>
        <div
          class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply opacity-20 blur-3xl transition-colors duration-300"
        ></div>
      </div>

      <div
        class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center transition-colors duration-300"
      >
        <h2
          class="text-3xl sm:text-4xl font-extrabold text-white mb-6 transition-colors duration-300"
        >
          Ready to register your vehicle?
        </h2>
        <p
          class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto transition-colors duration-300"
        >
          Join thousands of citizens experiencing the fastest and most seamless
          way to manage their vehicle registration online.
        </p>
        <NuxtLink
          to="/customer/OnlineRegistrationPage"
          class="inline-flex justify-center items-center px-8 py-4 rounded-full text-lg font-bold text-blue-900 bg-white dark:bg-slate-800 hover:bg-slate-100 shadow-xl shadow-white/10 transition-transform hover:-translate-y-1 transition-colors duration-300"
        >
          Start Your Registration
        </NuxtLink>
      </div>
    </section>

    <footer
      class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 pt-16 pb-8 transition-colors duration-300"
    >
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300"
      >
        <div
          class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12 transition-colors duration-300"
        >
          <div class="md:col-span-1 transition-colors duration-300">
            <div
              class="flex items-center gap-2 mb-6 transition-colors duration-300"
            >
              <div
                class="w-6 h-6 rounded bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white font-bold text-xs shadow-sm transition-colors duration-300"
              >
                V
              </div>
              <span
                class="text-lg font-bold text-slate-800 dark:text-slate-200 transition-colors duration-300"
                >VehicReg</span
              >
            </div>
            <p
              class="text-sm text-slate-500 mb-6 transition-colors duration-300"
            >
              Modernizing government services for a faster, more reliable
              future.
            </p>
          </div>

          <div>
            <h4
              class="font-bold text-slate-900 dark:text-slate-100 mb-4 transition-colors duration-300"
            >
              Services
            </h4>
            <ul
              class="space-y-3 text-sm text-slate-600 dark:text-slate-400 transition-colors duration-300"
            >
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Vehicle Registration</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Status Tracking</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Payment Portal</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Document Support</a
                >
              </li>
            </ul>
          </div>

          <div>
            <h4
              class="font-bold text-slate-900 dark:text-slate-100 mb-4 transition-colors duration-300"
            >
              Legal
            </h4>
            <ul
              class="space-y-3 text-sm text-slate-600 dark:text-slate-400 transition-colors duration-300"
            >
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Privacy Policy</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Terms of Service</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="hover:text-blue-600 transition transition-colors duration-300"
                  >Cookies Policy</a
                >
              </li>
            </ul>
          </div>

          <div>
            <h4
              class="font-bold text-slate-900 dark:text-slate-100 mb-4 transition-colors duration-300"
            >
              Contact Us
            </h4>
            <ul
              class="space-y-3 text-sm text-slate-600 dark:text-slate-400 transition-colors duration-300"
            >
              <li class="flex items-start gap-2 transition-colors duration-300">
                <svg
                  class="w-5 h-5 text-slate-400 mt-0.5 transition-colors duration-300"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                  />
                </svg>
                <span>support@vehicreg.gov</span>
              </li>
              <li class="flex items-start gap-2 transition-colors duration-300">
                <svg
                  class="w-5 h-5 text-slate-400 mt-0.5 transition-colors duration-300"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                  />
                </svg>
                <span>1-800-123-4567</span>
              </li>
            </ul>
          </div>
        </div>

        <div
          class="border-t border-slate-200 dark:border-slate-700 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 transition-colors duration-300"
        >
          <p class="text-sm text-slate-500 transition-colors duration-300">
            © 2026 Online Vehicle Registration System. All rights reserved.
          </p>
          <NuxtLink to="/customer/ceopage">
            <p
              class="text-sm font-semibold text-slate-500 transition-colors duration-300"
            >
              © CEO,Chelsea Marie Sevilla Diano.
            </p>
          </NuxtLink>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
html {
  scroll-behavior: smooth;
}

@keyframes slider {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.animate-slider {
  animation: slider 40s linear infinite;
}

.hover\:animation-play-state-paused:hover {
  animation-play-state: paused;
}

.mask-linear {
  mask-image: linear-gradient(
    to right,
    transparent,
    black 10%,
    black 90%,
    transparent
  );
  -webkit-mask-image: linear-gradient(
    to right,
    transparent,
    black 10%,
    black 90%,
    transparent
  );
}
</style>
