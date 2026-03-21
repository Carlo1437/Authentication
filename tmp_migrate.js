const fs = require('fs');

const filePath = 'c:/Users/ASUS/Desktop/Authentication/frontend/app/pages/Customer/index.vue';
let content = fs.readFileSync(filePath, 'utf-8');

// 1. Replace script setup
const newScript = `<script setup>
import { ref, onMounted, computed } from "vue";

const isDark = ref(false)

onMounted(() => {
  if (process.client) {
    isDark.value = localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
  }
})

const toggleTheme = () => {
  isDark.value = !isDark.value
  if (process.client) {
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
  }
}

useHead({
  title: "Register Your Vehicle Online - VehicReg",
  meta: [
    {
      name: "description",
      content:
        "Fast, secure, and easy online vehicle registration system. Skip the lines and register anytime.",
    },
  ],
  htmlAttrs: {
    class: computed(() => isDark.value ? 'dark' : '')
  }
});
</script>`;

content = content.replace(/<script setup>[\s\S]*?<\/script>/, newScript);

// 2. Class replacements
const classMap = {
  'bg-slate-50': 'bg-slate-50 dark:bg-slate-900',
  'bg-white/80': 'bg-white/80 dark:bg-slate-900/80',
  'bg-white': 'bg-white dark:bg-slate-800',
  'text-slate-800': 'text-slate-800 dark:text-slate-200',
  'text-slate-900': 'text-slate-900 dark:text-slate-100',
  'text-slate-700': 'text-slate-700 dark:text-slate-300',
  'text-slate-600': 'text-slate-600 dark:text-slate-400',
  'border-slate-200': 'border-slate-200 dark:border-slate-700',
  'border-slate-100': 'border-slate-100 dark:border-slate-700',
  'border-slate-300': 'border-slate-300 dark:border-slate-600',
  'hover:bg-slate-50': 'hover:bg-slate-50 dark:hover:bg-slate-700',
  'bg-slate-200': 'bg-slate-200 dark:bg-slate-700',
  'bg-slate-900': 'bg-slate-900 dark:bg-slate-950', // For the bottom section
  'text-blue-800': 'text-blue-800 dark:text-blue-400',
};

// Replace inside class="..."
content = content.replace(/class="([^"]+)"/g, (match, classes) => {
  let newClasses = classes;
  let replaced = false;
  for (const [key, value] of Object.entries(classMap)) {
    // Only replace if it doesn't already contain the dark mapping
    if (newClasses.includes(key) && !newClasses.includes(value)) {
      const escapedKey = key.replace(/[/]/g, '\\\\$&');
      const regex = new RegExp('\\b' + escapedKey + '\\b', 'g');
      newClasses = newClasses.replace(regex, value);
      replaced = true;
    }
  }
  
  // Also add transition to all classes to ensure smooth toggles
  if (!newClasses.includes('transition-colors')) {
    newClasses += ' transition-colors duration-300';
    replaced = true;
  }
  
  if(replaced) console.log("Replaced classes length:", newClasses.length);
  return 'class="' + newClasses + '"';
});

// Navbar button injection
const loginTarget = /<NuxtLink\s+to="\/login"/;
if (loginTarget.test(content) && !content.includes('toggleTheme')) {
  const buttonCode = '<button @click="toggleTheme" class="p-2 mr-2 rounded-full text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors duration-300" aria-label="Toggle Dark Mode">\\n            <svg v-if="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">\\n              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />\\n            </svg>\\n            <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">\\n              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />\\n            </svg>\\n          </button>\\n          <NuxtLink\\n            to="/login"';
  content = content.replace(loginTarget, buttonCode);
}

fs.writeFileSync(filePath, content);
console.log('Done replacing classes');
