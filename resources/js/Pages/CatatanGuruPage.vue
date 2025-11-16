<!-- <template>
  <div class="p-6 md:p-8">
    
    <header>
      <h1 class="text-3xl font-bold text-gray-900">Catatan Guru</h1>
    </header>

    <main class="mt-6 bg-white rounded-lg shadow-lg p-6 md:p-8">
      
      <div class="flex items-center gap-2">
        <DocumentTextIcon class="w-6 h-6 text-green-700" />
        <h2 class="text-xl font-semibold text-gray-800">Catatan</h2>
      </div>

      <div class="mt-6 border-t border-gray-200">
        <div class="divide-y divide-gray-200">
          
          <div v-for="catatan in catatanList" :key="catatan.id" class="py-5">
            <h3 class="text-lg font-semibold text-gray-900">{{ catatan.topik }}</h3>
            
            <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
              <div class="flex items-center gap-1.5">
                <CalendarDaysIcon class="w-4 h-4" />
                <span>{{ catatan.tanggal }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <UserIcon class="w-4 h-4" />
                <span>{{ catatan.guru }}</span>
              </div>
            </div>

            <p class="mt-3 text-gray-700 leading-relaxed">
              {{ catatan.isi }}
            </p>
          </div>

        </div>
      </div>
    </main>
  </div>
</template> -->

<template>
  <div class="min-h-screen" style="background: linear-gradient(135deg, #fafaf8 0%, #f5f3f0 100%)">
    
    <div class="p-6 md:p-8 max-w-4xl mx-auto">
      
      <!-- Header -->
      <header class="mb-10">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-1 h-8 bg-[#78AE4E] rounded-full"></div>
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Catatan Guru</h1>
        </div>
        <p class="text-gray-600 text-lg">Pantau perkembangan dan feedback dari guru</p>
      </header>

      <!-- Main Content -->
      <main class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-7 md:p-8">
          <div class="flex items-center gap-3 mb-8">
            <div class="p-3 bg-gradient-to-br from-[#EB9232] to-[#F0A74F] rounded-xl">
              <DocumentTextIcon class="w-6 h-6 text-white" />
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Semua Catatan</h2>
          </div>

          <div class="space-y-0 divide-y divide-gray-200">
            
            <div v-for="catatan in catatanList" :key="catatan.id" class="py-8 first:pt-0 last:pb-0">
              
              <div class="flex items-start justify-between gap-4 mb-3">
                <div>
                  <h3 class="text-xl font-bold text-gray-900">{{ catatan.topik }}</h3>
                  <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-600">
                    <div class="flex items-center gap-1.5">
                      <CalendarDaysIcon class="w-4 h-4 text-[#78AE4E]" />
                      <span>{{ catatan.tanggal }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                      <UserIcon class="w-4 h-4 text-[#78AE4E]" />
                      <span class="font-medium">{{ catatan.guru }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <p class="text-gray-700 leading-relaxed text-base mt-4 bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100">
                {{ catatan.isi }}
              </p>

            </div>

          </div>
        </div>
      </main>

    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { 
  DocumentTextIcon, 
  CalendarDaysIcon, 
  UserIcon 
} from '@heroicons/vue/24/outline';

// Data dummy berdasarkan gambar
const catatanList = ref([
]);
const isLoading = ref(true);

const fetchCatatan = async () => {
  try {
    const response = await axios.get('/api/catatan-guru-lengkap');
    catatanList.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil catatan:", error);
  } finally {
    isLoading.value = false;
  }
};

// Panggil saat komponen dipasang (mounted)
onMounted(() => {
  fetchCatatan();
});
</script>

<style scoped>
/* Tailwind menangani semua styling */
</style>