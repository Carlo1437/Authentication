<script setup>
import { ref, reactive } from "vue";
import { addVehicleRegistration } from "~/api/motor/post";

const emit = defineEmits(["close", "vehicle-registration-added"]);

const notification = reactive({
  show: false,
  message: "",
  type: "success", // success, error
});

const showNotification = (message, type = "success") => {
  notification.message = message;
  notification.type = type;
  notification.show = true;
  setTimeout(() => {
    notification.show = false;
  }, 3000);
};

const form = reactive({
  full_name: "",
  email_address: "",
  phone_number: "",
  address: "",
  vehicle_type: "",
  plate_number: "",
  registration_date: "",
  engine_number: "",
  chassis_number: "",
  files: [],
  status: "pending",
});
const closeModal = () => {
  emit("close");
};

const isDragging = ref(false);

const resetForm = () => {
  form.full_name = "";
  form.email_address = "";
  form.phone_number = "";
  form.address = "";
  form.vehicle_type = "";
  form.plate_number = "";
  form.registration_date = "";
  form.engine_number = "";
  form.chassis_number = "";
  form.files = [];
  form.status = "pending";
};

const handleFileUpload = (event) => {
  const uploadedFiles = Array.from(event.target.files);
  form.files = [...form.files, ...uploadedFiles];
};

const onDrop = (event) => {
  isDragging.value = false;
  const droppedFiles = Array.from(event.dataTransfer.files);
  form.files = [...form.files, ...droppedFiles];
};

const submitVehicleRegistration = async () => {
  try {
    const formData = new FormData();
    formData.append("full_name", form.full_name);
    formData.append("email_address", form.email_address);
    formData.append("phone_number", form.phone_number);
    formData.append("address", form.address);
    formData.append("vehicle_type", form.vehicle_type);
    formData.append("plate_number", form.plate_number);
    formData.append("registration_date", form.registration_date);
    formData.append("engine_number", form.engine_number);
    formData.append("chassis_number", form.chassis_number);
    formData.append("status", form.status);

    if (form.files && form.files.length > 0) {
      formData.append("document", form.files[0]);
    }

    const response = await addVehicleRegistration(formData);

    if (response && response.id) {
      showNotification("Vehicle registration submitted successfully!", "success");
      setTimeout(() => {
        emit("vehicle-registration-added");
        resetForm();
      }, 1500);
    } else {
      showNotification(
        response?.message || "Failed to add vehicle registration.",
        "error"
      );
    }
  } catch (error) {
    console.error(error);
    showNotification("An error occurred during submission.", "error");
  }
};
</script>

<template>
  <div class="min-h-screen bg-background-light font-display relative">
    <!-- Success/Error Notification -->
    <Transition enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-[-100%] opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0">
      <div v-if="notification.show" 
           class="fixed top-24 right-4 z-[9999] min-w-[300px] max-w-[450px] pointer-events-auto">
        <div :class="[
          'p-4 rounded-xl shadow-2xl flex items-center gap-4 border',
          notification.type === 'success' ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800'
        ]">
          <div :class="[
            'w-10 h-10 rounded-full flex items-center justify-center shrink-0 shadow-sm',
            notification.type === 'success' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'
          ]">
            <svg v-if="notification.type === 'success'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
          
          <div class="flex-grow">
            <h3 class="font-bold text-sm leading-tight">
              {{ notification.type === 'success' ? 'Success' : 'Error' }}
            </h3>
            <p class="text-xs font-medium opacity-90 mt-0.5">{{ notification.message }}</p>
          </div>

          <!-- Close button -->
          <button @click="notification.show = false" class="shrink-0 hover:scale-110 transition-transform p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </Transition>
    <header
      class="bg-primary py-4 px-6 md:px-12 flex items-center justify-between sticky top-0 z-50 shadow-sm border-b border-white/10"
    >
      <div class="flex items-center gap-3 group cursor-pointer">
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
        </div>
      </div>
      <nav class="hidden md:flex items-center gap-10">
        <NuxtLink
          to="/customer"
          class="text-white/80 hover:text-white font-semibold transition-all duration-200 relative group"
        >
          Home
          <span
            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"
          ></span>
        </NuxtLink>
        <a
          href="#"
          class="text-white/80 hover:text-white font-semibold transition-all duration-200 relative group"
        >
          Services
          <span
            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"
          ></span>
        </a>
        <a
          href="#"
          class="text-white/80 hover:text-white font-semibold transition-all duration-200 relative group"
        >
          Support
          <span
            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"
          ></span>
        </a>
      </nav>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-12">
      <div
        class="bg-white rounded-[2rem] shadow-2xl shadow-blue-900/10 overflow-hidden border border-slate-100 animate-in fade-in slide-in-from-bottom-6 duration-1000"
      >
        <div class="p-10 md:p-16">
          <!-- Form Title -->
          <div class="mb-14 text-center md:text-left">
            <h1 class="text-4xl font-extrabold text-slate-900 leading-tight">
              Vehicle Registration
            </h1>
            <div class="mt-4 flex items-center justify-center md:justify-start">
              <span class="h-1 w-20 bg-primary rounded-full"></span>
            </div>
            <p
              class="mt-6 text-slate-500 text-lg md:text-xl font-medium max-w-2xl"
            >
              Complete the form below to register your vehicle in the national
              system with ease and security.
            </p>
          </div>

          <form @submit.prevent="submitVehicleRegistration" class="space-y-12">
            <!-- Section 1: Owner Information -->
            <section class="space-y-6">
              <div class="flex items-center gap-4 group">
                <div
                  class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm group-hover:bg-primary group-hover:text-white transition-all duration-300"
                >
                  1
                </div>
                <h2 class="text-xl font-bold text-[#1a1f36]">
                  Owner Information
                </h2>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-12">
                <div class="space-y-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Full Name</label
                  >
                  <input
                    v-model="form.full_name"
                    type="text"
                    placeholder="John Doe"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400"
                  />
                </div>
                <div class="space-y-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Email Address</label
                  >
                  <input
                    v-model="form.email_address"
                    type="email"
                    placeholder="john@example.com"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400"
                  />
                </div>
                <div class="space-y-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Contact Number</label
                  >
                  <input
                    v-model="form.phone_number"
                    type="tel"
                    placeholder="+63 912 345 6789"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400"
                  />
                </div>
                <div class="md:col-span-2 space-y-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Residential Address</label
                  >
                  <textarea
                    v-model="form.address"
                    placeholder="Street name, City, State, ZIP"
                    rows="3"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400 resize-none"
                  ></textarea>
                </div>
              </div>
            </section>

            <!-- Section 2: Vehicle Details -->
            <section class="space-y-6">
              <div class="flex items-center gap-4 group">
                <div
                  class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm group-hover:bg-primary group-hover:text-white transition-all duration-300"
                >
                  2
                </div>
                <h2 class="text-xl font-bold text-[#1a1f36]">
                  Vehicle Details
                </h2>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pl-12">
                <div class="space-y-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Vehicle Type</label
                  >
                  <select
                    v-model="form.vehicle_type"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%234f566b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-[length:20px_20px] bg-[right_12px_center] bg-no-repeat"
                  >
                    <option value="" disabled>Select Type</option>
                    <option value="sedan">Sedan</option>
                    <option value="suv">SUV</option>
                    <option value="truck">Truck</option>
                    <option value="motorcycle">Motorcycle</option>
                  </select>
                </div>
                <div class="space-y-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Plate Number</label
                  >
                  <input
                    v-model="form.plate_number"
                    type="text"
                    placeholder="ABC-1234"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400"
                  />
                </div>
                <div class="space-y-2 text-primary">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Registration Date</label
                  >
                  <input
                    v-model="form.registration_date"
                    type="date"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800"
                  />
                </div>
                <div class="space-y-2 md:col-span-1.5">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Engine Number</label
                  >
                  <input
                    v-model="form.engine_number"
                    type="text"
                    placeholder="E-XXXXXXX"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400"
                  />
                </div>
                <div class="space-y-2 md:col-span-2">
                  <label class="text-sm font-semibold text-[#4f566b]"
                    >Chassis Number (VIN)</label
                  >
                  <input
                    v-model="form.chassis_number"
                    type="text"
                    placeholder="VIN-17-DIGIT-NUMBER"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-slate-800 placeholder:text-slate-400"
                  />
                </div>
              </div>
            </section>

            <!-- Section 3: Required Documents -->
            <section class="space-y-6">
              <div class="flex items-center gap-4 group">
                <div
                  class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm group-hover:bg-primary group-hover:text-white transition-all duration-300"
                >
                  3
                </div>
                <h2 class="text-xl font-bold text-[#1a1f36]">
                  Required Documents
                </h2>
              </div>

              <div class="pl-12">
                <div
                  @dragover.prevent="isDragging = true"
                  @dragleave.prevent="isDragging = false"
                  @drop.prevent="onDrop"
                  :class="[
                    'relative border-2 border-dashed rounded-xl p-10 flex flex-col items-center justify-center transition-all duration-200 cursor-pointer',
                    isDragging
                      ? 'border-primary bg-primary/5'
                      : 'border-slate-200 bg-slate-50/50 hover:bg-slate-50 hover:border-slate-300',
                  ]"
                  @click="$refs.fileInput.click()"
                >
                  <input
                    ref="fileInput"
                    type="file"
                    multiple
                    class="hidden"
                    @change="handleFileUpload"
                  />
                  <div
                    class="bg-white p-3 rounded-full shadow-sm mb-4 border border-slate-100"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-8 h-8 text-slate-400"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M12 4v16m8-8H4"
                      />
                    </svg>
                  </div>
                  <div class="text-center">
                    <p class="text-slate-600 font-medium">
                      <span class="text-primary hover:underline"
                        >Upload files</span
                      >
                      or drag and drop
                    </p>
                    <p
                      class="text-xs text-slate-400 mt-1 uppercase tracking-wider"
                    >
                      PNG, JPG, PDF up to 10MB
                    </p>
                  </div>

                  <!-- File List Preview (Optional but nice) -->
                  <div
                    v-if="form.files.length > 0"
                    class="mt-6 flex flex-wrap gap-2"
                  >
                    <div
                      v-for="(file, index) in form.files"
                      :key="index"
                      class="px-3 py-1 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 flex items-center gap-2"
                    >
                      <span class="max-w-[100px] truncate">{{
                        file.name
                      }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <!-- Action Buttons -->
            <div
              class="pt-12 flex flex-col sm:flex-row items-center justify-end gap-6 border-t border-slate-100"
            >
              <button
                type="button"
                @click="resetForm"
                class="w-full sm:w-auto px-10 py-4 rounded-xl text-slate-500 font-bold border border-slate-200 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 transition-all duration-300"
              >
                Reset Form
              </button>
              <button
                type="submit"
                class="w-full sm:w-auto px-10 py-4 rounded-xl bg-primary text-white font-bold shadow-xl shadow-primary/30 hover:bg-primary/90 hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-3 group"
              >
                Submit Registration
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2.5"
                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                  />
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer
      class="bg-background-dark py-12 px-6 md:px-12 mt-12 border-t border-white/5"
    >
      <div class="max-w-4xl mx-auto flex flex-col items-center gap-6">
        <div class="flex items-center gap-8">
          <a
            href="#"
            class="text-slate-400 hover:text-white transition-colors text-sm font-medium"
            >Privacy Policy</a
          >
          <a
            href="#"
            class="text-slate-400 hover:text-white transition-colors text-sm font-medium"
            >Terms of Service</a
          >
          <a
            href="#"
            class="text-slate-400 hover:text-white transition-colors text-sm font-medium"
            >Contact Dept</a
          >
        </div>
        <p class="text-slate-500 text-sm">
          © 2023 VehicleReg Authority. All rights reserved.
        </p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&display=swap");

.font-display {
  font-family: "Public Sans", sans-serif;
}

.animate-in {
  animation-duration: 0.7s;
  animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  animation-fill-mode: both;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideInFromBottom {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.fade-in {
  animation-name: fadeIn;
}
.slide-in-from-bottom-4 {
  animation-name: slideInFromBottom;
}

input[type="date"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  filter: invert(47%) sepia(13%) saturate(400%) hue-rotate(180deg)
    brightness(95%) contrast(80%);
  opacity: 0.6;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
  opacity: 1;
}

textarea::-webkit-scrollbar {
  width: 6px;
}
textarea::-webkit-scrollbar-track {
  background: transparent;
}
textarea::-webkit-scrollbar-thumb {
  background: #e2e8f0;
  border-radius: 10px;
}
textarea::-webkit-scrollbar-thumb:hover {
  background: #cbd5e1;
}
</style>
