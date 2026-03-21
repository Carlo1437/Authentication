<script setup>
const currentYear = new Date().getFullYear();

const stats = [
  { value: "10,000+", label: "Registered Motorists" },
  { value: "99.9%", label: "System Uptime" },
  { value: "3 Min", label: "Avg. Registration Time" },
  { value: "100%", label: "LTO Compliant" },
];

const features = [
  {
    title: "Online Motor Registration",
    desc: "Submit and process your motor vehicle registration entirely online — no physical visits required.",
    icon: "M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1",
    iconBg: "bg-blue-50 dark:bg-blue-900/20",
    iconColor: "text-primary",
  },
  {
    title: "Real-Time Status Tracking",
    desc: "Monitor the progress of your registration application at every step with live status updates.",
    icon: "M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z",
    iconBg: "bg-green-50 dark:bg-green-900/20",
    iconColor: "text-secondary",
  },
  {
    title: "Secure Document Management",
    desc: "Your registration documents and personal data are encrypted and protected under strict data privacy protocols.",
    icon: "M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z",
    iconBg: "bg-indigo-50 dark:bg-indigo-900/20",
    iconColor: "text-indigo-500",
  },
  {
    title: "Automated Renewal Reminders",
    desc: "Receive timely notifications before your registration expires so you never miss a renewal deadline.",
    icon: "M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9",
    iconBg: "bg-amber-50 dark:bg-amber-900/20",
    iconColor: "text-amber-500",
  },
  {
    title: "Government-Grade Compliance",
    desc: "Fully aligned with LTO regulations and data privacy laws, ensuring your registrations are legally valid.",
    icon: "M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z",
    iconBg: "bg-red-50 dark:bg-red-900/20",
    iconColor: "text-red-500",
  },
  {
    title: "Multi-Device Accessibility",
    desc: "Access and manage your registrations from any device — desktop, tablet, or mobile — anytime, anywhere.",
    icon: "M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z",
    iconBg: "bg-purple-50 dark:bg-purple-900/20",
    iconColor: "text-purple-500",
  },
];
</script>

<template>
  <main
    class="min-h-screen bg-background-light dark:bg-background-dark font-display"
  >
    <section
      class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50 to-indigo-100 dark:from-[#101922] dark:via-[#0d1e2e] dark:to-[#0a1520]"
    >
      <div class="absolute inset-0 pointer-events-none">
        <div
          class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl"
        ></div>
        <div
          class="absolute bottom-0 -left-24 w-80 h-80 bg-indigo-400/10 rounded-full blur-3xl"
        ></div>
      </div>

      <div class="relative max-w-7xl mx-auto px-6 py-20 lg:py-28">
        <div class="flex flex-col-reverse lg:flex-row items-center gap-16">
          <div class="flex-1 text-center lg:text-left">
            <span
              class="inline-block px-4 py-1.5 mb-5 text-xs font-semibold tracking-widest uppercase rounded-full bg-primary/10 text-primary dark:bg-primary/20 dark:text-blue-300 border border-primary/20"
            >
              Message from the CEO
            </span>

            <h1
              class="text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight text-gray-900 dark:text-white mb-4"
            >
              Driving the Future of
              <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-indigo-500"
              >
                Vehicle Registration
              </span>
            </h1>

            <p
              class="text-lg text-gray-500 dark:text-gray-400 mb-8 max-w-xl mx-auto lg:mx-0"
            >
              A modern, secure, and fully digital system designed to simplify
              how you manage motor vehicle registrations across the Philippines.
            </p>

            <blockquote
              class="relative bg-white/70 dark:bg-white/5 backdrop-blur border border-gray-200 dark:border-white/10 rounded-2xl px-7 py-6 shadow-lg max-w-xl mx-auto lg:mx-0"
            >
              <svg
                class="absolute top-4 left-5 w-8 h-8 text-primary/20"
                fill="currentColor"
                viewBox="0 0 32 32"
              >
                <path
                  d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"
                />
              </svg>
              <p
                class="text-gray-700 dark:text-gray-300 text-base leading-relaxed italic pl-6"
              >
                "We believe that every Filipino motorist deserves a seamless,
                transparent, and efficient registration experience. Our platform
                is built not just to digitize a process — but to transform it
                into something truly accessible for everyone."
              </p>
            </blockquote>

            <div
              class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start"
            >
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center shrink-0"
                >
                  <svg
                    class="w-5 h-5 text-primary"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400"
                  >Fully Digital &amp; Paperless</span
                >
              </div>
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center shrink-0"
                >
                  <svg
                    class="w-5 h-5 text-primary"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    />
                  </svg>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400"
                  >Secure &amp; Compliant</span
                >
              </div>
            </div>
          </div>

          <div class="flex-shrink-0 flex flex-col items-center gap-6">
            <div class="relative">
              <div
                class="absolute inset-0 rounded-3xl bg-gradient-to-br from-primary/30 to-indigo-500/30 blur-xl scale-105"
              ></div>
              <div
                class="relative w-64 h-64 lg:w-80 lg:h-80 rounded-3xl overflow-hidden ring-4 ring-white dark:ring-white/10 shadow-2xl"
              >
                <img
                  src="/ceo.png"
                  alt="Chief Executive Officer"
                  class="w-full h-full object-cover object-top"
                />
              </div>
              <span
                class="absolute -bottom-4 left-1/2 -translate-x-1/2 whitespace-nowrap inline-flex items-center gap-2 bg-white dark:bg-[#1a2a3a] text-gray-800 dark:text-white text-sm font-semibold px-5 py-2 rounded-full shadow-lg border border-gray-100 dark:border-white/10"
              >
                <span
                  class="w-2 h-2 rounded-full bg-green-400 animate-pulse"
                ></span>
                Chief Executive Officer
              </span>
            </div>

            <div class="mt-6 text-center">
              <p
                class="text-xl font-bold text-gray-900 dark:text-white tracking-tight"
              >
                Chelsea Marie S. Diano
              </p>
              <p
                class="text-sm text-primary dark:text-blue-400 font-medium mt-1"
              >
                Founder &amp; CEO, MotorReg Systems
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section
      class="bg-white dark:bg-[#0d1e2e] border-y border-gray-100 dark:border-white/5 py-10 px-6"
    >
      <div
        class="max-w-5xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-8 text-center"
      >
        <div
          v-for="stat in stats"
          :key="stat.label"
          class="flex flex-col items-center gap-1"
        >
          <span class="text-3xl font-extrabold text-primary">{{
            stat.value
          }}</span>
          <span class="text-sm text-gray-500 dark:text-gray-400">{{
            stat.label
          }}</span>
        </div>
      </div>
    </section>

    <section class="py-20 px-6 bg-background-light dark:bg-background-dark">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14">
          <span
            class="inline-block px-4 py-1.5 mb-4 text-xs font-semibold tracking-widest uppercase rounded-full bg-primary/10 text-primary dark:bg-primary/20 dark:text-blue-300 border border-primary/20"
          >
            About the Platform
          </span>
          <h2
            class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4"
          >
            One Platform. Complete Control.
          </h2>
          <p
            class="max-w-2xl mx-auto text-gray-500 dark:text-gray-400 text-base leading-relaxed"
          >
            MotorReg Systems is a government-compliant, enterprise-grade online
            vehicle registration platform built to eliminate long queues, reduce
            errors, and bring transparency to the entire registration lifecycle.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="feature in features"
            :key="feature.title"
            class="group bg-white dark:bg-[#1a2a3a] rounded-2xl p-7 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
          >
            <div
              class="w-12 h-12 rounded-xl mb-5 flex items-center justify-center"
              :class="feature.iconBg"
            >
              <svg
                class="w-6 h-6"
                :class="feature.iconColor"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  :d="feature.icon"
                />
              </svg>
            </div>
            <h3
              class="text-base font-semibold text-gray-900 dark:text-white mb-2"
            >
              {{ feature.title }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
              {{ feature.desc }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <section
      class="relative overflow-hidden bg-gradient-to-r from-primary to-indigo-600 py-20 px-6"
    >
      <div class="absolute inset-0 opacity-10">
        <div
          class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"
        ></div>
        <div
          class="absolute bottom-0 right-0 w-72 h-72 bg-white rounded-full blur-3xl translate-x-1/2 translate-y-1/2"
        ></div>
      </div>
      <div class="relative max-w-3xl mx-auto text-center text-white">
        <h2 class="text-3xl lg:text-4xl font-bold mb-4">
          Ready to Register Your Vehicle?
        </h2>
        <p class="text-blue-100 mb-8 text-base leading-relaxed">
          Join thousands of motorists who have already experienced a faster,
          simpler, and fully digital registration process.
        </p>
        <NuxtLink
          to="/customer"
          class="inline-flex items-center gap-2 bg-white text-primary font-semibold px-8 py-3.5 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 text-sm"
        >
          Get Started Today
          <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            stroke-width="2.5"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M17 8l4 4m0 0l-4 4m4-4H3"
            />
          </svg>
        </NuxtLink>
      </div>
    </section>

    <footer
      class="bg-white dark:bg-[#0a1520] border-t border-gray-100 dark:border-white/5 py-8 px-6 text-center"
    >
      <p class="text-sm text-gray-400 dark:text-gray-500">
        &copy; {{ currentYear }} MotorReg Systems. All rights reserved. &mdash;
        A platform by Chelsea Marie S. Diano.
      </p>
    </footer>
  </main>
</template>
