<template>
  <div class="min-h-screen bg-slate-50 flex flex-col items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl p-8 text-center border border-slate-100">
      <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
      </div>
      <h1 class="text-3xl font-bold text-slate-900 mb-4">Requirements Guide</h1>
      <p class="text-slate-600 mb-8 max-w-lg mx-auto">
        Detailed requirements and guidelines for online vehicle registration will be available here soon. We are currently updating our documentation.
      </p>
      <button @click="$router.back()" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition shadow-sm hover:shadow">
        Go Back
      </button>
    </div>
  </div>
</template>

<script setup>
useHead({
  title: 'Requirements Guide - VehicReg'
})
</script>
