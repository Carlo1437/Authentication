<script setup>
import { ref, onMounted } from 'vue';

const isDark = ref(false);

const stats = [
  { value: "500+", label: "Vehicles for Sale" },
  { value: "40%", label: "Avg. Savings" },
  { value: "24h", label: "Inquiry Response" },
  { value: "100%", label: "Verified Repo" },
];

const repossessedVehicles = [
  {
    id: 1,
    name: "2024 Toyota Land Cruiser",
    type: "SUV",
    price: "₱4,200,000",
    originalPrice: "₱5,800,000",
    mileage: "12,400 km",
    fuel: "Diesel",
    transmission: "Automatic",
    status: "Like New",
    image: "/images/repo/suv.png"
  },
  {
    id: 2,
    name: "2023 Honda Civic RS",
    type: "Sedan",
    price: "₱1,150,000",
    originalPrice: "₱1,750,000",
    mileage: "8,900 km",
    fuel: "Gasoline",
    transmission: "CVT",
    status: "Excellent",
    image: "/images/repo/sedan.png"
  },
  {
    id: 3,
    name: "2023 Ford Ranger Raptor",
    type: "Pickup",
    price: "₱2,100,000",
    originalPrice: "₱2,880,000",
    mileage: "15,200 km",
    fuel: "Diesel",
    transmission: "Automatic",
    status: "Rugged Ready",
    image: "/images/repo/pickup.png"
  },
  {
    id: 4,
    name: "2024 Ducati Panigale V4",
    type: "Motorcycle",
    price: "₱1,400,000",
    originalPrice: "₱1,950,000",
    mileage: "2,100 km",
    fuel: "Gasoline",
    transmission: "6-Speed",
    status: "Pristine",
    image: "/images/repo/motorcycle.png"
  }
];

onMounted(() => {
  if (process.client) {
    isDark.value = localStorage.getItem('theme') === 'dark' || 
      (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
  }
});

const toggleTheme = () => {
  isDark.value = !isDark.value;
  if (process.client) {
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', isDark.value);
  }
};

useHead({
  title: "Learn More - Vehicle Registration & Repo Sales",
  meta: [
    { name: "description", content: "Learn more about our advanced vehicle registration system and browse repossessed vehicles for sale at unbeatable prices." }
  ]
});
</script>

<template>
  <div class="min-h-screen bg-slate-50 dark:bg-slate-900 font-sans text-slate-800 dark:text-slate-200 transition-colors duration-300">
    <!-- Navigation (Replicated for consistency) -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 h-16 transition-colors duration-300">
      <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
        <NuxtLink to="/customer" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white font-bold text-xl shadow-md">V</div>
          <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-slate-700 dark:from-blue-200 dark:to-slate-100">VehicleReg</span>
        </NuxtLink>
        
        <div class="flex items-center gap-4">
          <button @click="toggleTheme" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" aria-label="Toggle Theme">
            <svg v-if="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </button>
          <NuxtLink to="/customer" class="text-sm font-medium hover:text-blue-600 transition-colors">Back to Home</NuxtLink>
        </div>
      </div>
    </nav>

    <main class="pt-16">
      <!-- Hero Section -->
      <section class="relative overflow-hidden py-24 lg:py-32 bg-gradient-to-b from-blue-50/50 to-white dark:from-slate-950 dark:to-slate-900 border-b border-slate-100 dark:border-slate-800">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl blur-3xl opacity-20 pointer-events-none">
          <div class="absolute top-10 left-10 w-96 h-96 bg-blue-500 rounded-full"></div>
          <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-500 rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
          <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
            Discover the Future of <br/>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-emerald-500">Automotive Excellence</span>
          </h1>
          <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed">
            Our state-of-the-art registration system streamlines Every aspect of vehicle management. 
            Beyond legality, we provide a gateway to exclusive repossessed deals direct from financial institutions.
          </p>
          <div class="flex flex-wrap justify-center gap-4">
            <a href="#repo-gallery" class="px-8 py-4 bg-blue-600 text-white rounded-full font-bold shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:-translate-y-1 transition-all">
              Browse Repo Sales
            </a>
            <NuxtLink to="/customer/OnlineRegistrationPage" class="px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full font-bold shadow-sm hover:shadow-md transition-all">
              Start Registration
            </NuxtLink>
          </div>
        </div>
      </section>

      <!-- Stats Grid -->
      <section class="py-12 bg-white dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center group">
            <div class="text-3xl lg:text-4xl font-black text-blue-600 dark:text-blue-400 mb-1 group-hover:scale-110 transition-transform duration-300">{{ stat.value }}</div>
            <div class="text-sm font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ stat.label }}</div>
          </div>
        </div>
      </section>

      <!-- Vehicle Repo Section -->
      <section id="repo-gallery" class="py-24 bg-slate-50 dark:bg-slate-900 transition-colors">
        <div class="max-w-7xl mx-auto px-4">
          <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
              <h2 class="text-sm font-bold text-blue-600 uppercase tracking-[0.2em] mb-3">Premium Liquidation</h2>
              <h3 class="text-4xl lg:text-5xl font-black text-slate-900 dark:text-white">Vehicle Repo for Sale</h3>
              <p class="mt-4 text-slate-600 dark:text-slate-400 max-w-xl">
                Exclusive access to high-quality repossessed vehicles. All units are inspected, 
                verified, and ready for immediate ownership transfer.
              </p>
            </div>
            <div class="flex gap-2">
              <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold ring-1 ring-emerald-600/20">Updated Today</span>
              <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold ring-1 ring-blue-600/20">Bank Certified</span>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div v-for="vehicle in repossessedVehicles" :key="vehicle.id" 
                 class="group bg-white dark:bg-slate-800 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
              <!-- Image Container -->
              <div class="aspect-[4/3] overflow-hidden relative">
                <img :src="vehicle.image" :alt="vehicle.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                <div class="absolute top-4 left-4">
                  <span class="px-3 py-1 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-full border border-white/20">
                    {{ vehicle.type }}
                  </span>
                </div>
                <div class="absolute bottom-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                  <button class="bg-blue-600 text-white p-3 rounded-2xl shadow-xl">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Content -->
              <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide">{{ vehicle.status }}</span>
                  <div class="flex gap-1">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] text-slate-400 font-medium">Verified</span>
                  </div>
                </div>
                <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4 line-clamp-1">{{ vehicle.name }}</h4>
                
                <div class="grid grid-cols-2 gap-y-3 mb-6">
                  <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-xs">{{ vehicle.mileage }}</span>
                  </div>
                  <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    <span class="text-xs">{{ vehicle.fuel }}</span>
                  </div>
                  <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 col-span-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>
                    <span class="text-xs">{{ vehicle.transmission }}</span>
                  </div>
                </div>

                <div class="flex items-end justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                  <div>
                    <div class="text-[10px] text-slate-400 line-through">{{ vehicle.originalPrice }}</div>
                    <div class="text-xl font-black text-slate-900 dark:text-white">{{ vehicle.price }}</div>
                  </div>
                  <button class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-950 text-xs font-bold rounded-xl hover:scale-105 transition-transform">
                    Inquire
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- System Deep Dive -->
      <section class="py-24 bg-white dark:bg-slate-800">
        <div class="max-w-7xl mx-auto px-4">
          <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1 relative">
              <div class="absolute -top-10 -left-10 w-64 h-64 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl"></div>
              <div class="relative grid grid-cols-2 gap-4">
                <div class="space-y-4 pt-8">
                  <div class="h-64 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 text-white flex flex-col justify-end">
                    <div class="text-2xl font-bold mb-2">Security</div>
                    <div class="text-sm opacity-80">Bank-level encryption for your documents.</div>
                  </div>
                  <div class="h-48 bg-slate-100 dark:bg-slate-700 rounded-3xl border border-slate-200 dark:border-slate-600"></div>
                </div>
                <div class="space-y-4">
                   <div class="h-48 bg-slate-100 dark:bg-slate-700 rounded-3xl border border-slate-200 dark:border-slate-600"></div>
                   <div class="h-64 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-8 text-white flex flex-col justify-end">
                    <div class="text-2xl font-bold mb-2">Efficiency</div>
                    <div class="text-sm opacity-80">90% faster processing than traditional methods.</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="order-1 lg:order-2">
              <h2 class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-4">Core Principles</h2>
              <h3 class="text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-8">Built for the Modern Citizen</h3>
              <div class="space-y-8">
                <div class="flex gap-6 group">
                  <div class="w-14 h-14 shrink-0 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                  </div>
                  <div>
                    <h4 class="text-xl font-bold mb-2">Compliance as a Priority</h4>
                    <p class="text-slate-600 dark:text-slate-400">Total alignment with LTO and data privacy standards ensures your legal peace of mind.</p>
                  </div>
                </div>
                <div class="flex gap-6 group">
                  <div class="w-14 h-14 shrink-0 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                  </div>
                  <div>
                    <h4 class="text-xl font-bold mb-2">Cloud Integration</h4>
                    <p class="text-slate-600 dark:text-slate-400">Access your digital titles and documents anywhere in the world, securely cached in the cloud.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_30%,#3b82f6,transparent),radial-gradient(circle_at_80%_70%,#10b981,transparent)]"></div>
        <div class="max-w-5xl mx-auto px-4 relative z-10 text-center">
          <h2 class="text-4xl lg:text-5xl font-black text-white mb-8">Ready to take the next step?</h2>
          <p class="text-slate-400 text-lg mb-10 max-w-2xl mx-auto">
            Whether you're registering your pride and joy or looking for your next dream car, 
            VehicleReg is your trusted partner.
          </p>
          <div class="flex flex-col sm:flex-row justify-center gap-6">
            <NuxtLink to="/login" class="px-12 py-5 bg-white text-slate-950 font-black rounded-full hover:scale-105 active:scale-95 transition-all">Get Started Now</NuxtLink>
            <button class="px-12 py-5 bg-slate-800 text-white font-black rounded-full hover:bg-slate-700 transition-all">Contact Support</button>
          </div>
        </div>
      </section>
    </main>

    <footer class="py-12 bg-white dark:bg-slate-950 text-center border-t border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto px-4">
        <div class="mb-8 font-bold text-2xl bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-slate-700 dark:from-blue-200 dark:to-slate-100">VehicleReg</div>
        <nav class="flex flex-wrap justify-center gap-8 mb-8 text-sm font-medium text-slate-500 dark:text-slate-400">
           <a href="#" class="hover:text-blue-600 transition-colors">Privacy Policy</a>
           <a href="#" class="hover:text-blue-600 transition-colors">Terms of Service</a>
           <a href="#" class="hover:text-blue-600 transition-colors">Compliance</a>
           <a href="#" class="hover:text-blue-600 transition-colors">Repo Terms</a>
        </nav>
        <p class="text-xs text-slate-400">&copy; 2026 MotorReg Systems. Designed for excellence by Chelsea Marie S. Diano.</p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: .5; }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
