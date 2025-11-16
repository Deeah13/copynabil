<!-- <template>
  <div class="p-6 md:p-8">

    <header>
      <h1 class="text-3xl font-bold text-gray-900">Jadwal Belajar Anak</h1>
      <p class="text-gray-600">Lihat Seluruh Jadwal Pembelajaran dan akses materi yang telah disiapkan</p>
    </header>

    <div class="mt-6 flex flex-col sm:flex-row gap-4">
      <div class="relative grow">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <MagnifyingGlassIcon class="w-5 h-5 text-gray-400" />
        </div>
        <input v-model="search" type="text" placeholder="Cari Mata Pelajaran..."
          class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
      </div>
      <div class="relative w-full sm:w-48">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <FunnelIcon class="w-5 h-5 text-gray-400" />
        </div>
        <select v-model="filterStatus"
          class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-green-500">
          <option>Filter Status</option>
          <option>Selesai</option>
          <option>Akan Datang</option>
        </select>
      </div>
    </div>

    <div class="mt-4 text-sm font-semibold text-gray-700">
      {{ filteredSchedules.length }} Jadwal Tersedia
    </div>
    <div class="mt-4 space-y-4">

      <div v-for="schedule in schedules" :key="schedule.id" class="bg-white rounded-lg shadow overflow-hidden">

        <button @click="toggleSchedule(schedule.id)" class="w-full p-4 flex justify-between items-center text-left">
          <div>
            <p class="text-sm text-gray-500">{{ schedule.tanggal }} ({{ schedule.hari }})</p>
            <p class="text-lg font-semibold text-gray-800">{{ schedule.pelajaran }}</p>
          </div>
          <div class="flex items-center gap-4">
            <span
              :class="schedule.status === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
              class="px-3 py-1 rounded-full text-sm font-medium">
              {{ schedule.status }}
            </span>
            <span class="text-gray-500 text-sm font-medium">{{ schedule.waktu }}</span>
            <ChevronUpIcon v-if="openScheduleId === schedule.id" class="w-6 h-6 text-gray-500" />
            <ChevronDownIcon v-else class="w-6 h-6 text-gray-500" />
          </div>
        </button>

        <div v-if="openScheduleId === schedule.id" class="p-6 border-t border-gray-200">

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div class="flex items-center gap-2">
              <UserIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Guru: <span class="font-medium text-gray-800">{{ schedule.details.guru
                  }}</span></span>
            </div>
            <div class="flex items-center gap-2">
              <BookmarkIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Topik: <span class="font-medium text-gray-800">{{ schedule.details.topik
                  }}</span></span>
            </div>
            <div class="flex items-center gap-2">
              <MapPinIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Lokasi: <span class="font-medium text-gray-800">{{ schedule.details.lokasi
                  }}</span></span>
            </div>
            <div class="flex items-center gap-2">
              <CheckCircleIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Kehadiran: <span class="font-medium text-gray-800">{{
                schedule.details.kehadiran }}</span></span>
            </div>
          </div>

          <div class="mt-6">
            <h4 class="font-semibold text-gray-800">Deskripsi Pembelajaran</h4>
            <p class="mt-1 text-sm text-gray-600">{{ schedule.details.deskripsi }}</p>
          </div>

          <div class="mt-6">
            <h4 class="font-semibold text-gray-800">Materi Pembelajaran ({{ schedule.details.materi.length }} File)</h4>
            <div class="mt-2 space-y-2">
              <div v-for="schedule in filteredSchedules" :key="schedule.id"
                class="bg-white rounded-lg shadow overflow-hidden">
                <div class="flex items-center gap-3">
                  <DocumentTextIcon class="w-6 h-6 text-green-600" />
                  <div>
                    <p class="text-sm font-medium text-gray-800">{{ file.nama }}</p>
                    <p class="text-xs text-gray-500">{{ file.tipe }} - {{ file.ukuran }}</p>
                  </div>
                </div>
                <button class="flex items-center gap-1 text-sm text-green-600 font-medium hover:text-green-800">
                  <ArrowDownTrayIcon class="w-4 h-4" />
                  Unduh
                </button>
              </div>
            </div>
          </div>

          <div class="mt-6">
            <h4 class="font-semibold text-gray-800">Catatan Dari Guru</h4>
            <p class="mt-1 text-sm text-gray-600">{{ schedule.details.catatan }}</p>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import {
  MagnifyingGlassIcon,
  FunnelIcon,
  ChevronUpIcon,
  ChevronDownIcon,
  UserIcon,
  MapPinIcon,
  BookmarkIcon,
  CheckCircleIcon,
  ArrowDownTrayIcon,
  DocumentTextIcon
} from '@heroicons/vue/24/outline';

// State
const rawSchedules = ref([]); // Data mentah dari API
const search = ref(''); // Untuk fitur pencarian
const filterStatus = ref('Filter Status'); // Untuk fitur filter dropdown
const openScheduleId = ref(null);
const isLoading = ref(true);

// Fetch Data
const fetchJadwal = async () => {
  try {
    const response = await axios.get('/api/jadwal-lengkap');
    rawSchedules.value = response.data;
    // Buka jadwal pertama secara default jika ada
    if (rawSchedules.value.length > 0) {
      openScheduleId.value = rawSchedules.value[0].id;
    }
  } catch (error) {
    console.error("Gagal ambil jadwal:", error);
  } finally {
    isLoading.value = false;
  }
};

// Computed Property untuk Filter & Search
const filteredSchedules = computed(() => {
  return rawSchedules.value.filter(schedule => {
    // 1. Filter by Status
    const matchStatus = filterStatus.value === 'Filter Status'
      ? true
      : schedule.status === filterStatus.value;

    // 2. Filter by Search (Pelajaran)
    const matchSearch = schedule.pelajaran.toLowerCase().includes(search.value.toLowerCase());

    return matchStatus && matchSearch;
  });
});

const toggleSchedule = (id) => {
  if (openScheduleId.value === id) {
    openScheduleId.value = null;
  } else {
    openScheduleId.value = id;
  }
};

onMounted(() => {
  fetchJadwal();
});
</script> -->

<!-- <template>
  <div class="p-6 md:p-8">
    
    <header>
      <h1 class="text-3xl font-bold text-gray-900">Jadwal Belajar Anak</h1>
      <p class="text-gray-600">Lihat Seluruh Jadwal Pembelajaran dan akses materi yang telah disiapkan</p>
    </header>

    <div class="mt-6 flex flex-col sm:flex-row gap-4">
      <div class="relative grow">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <MagnifyingGlassIcon class="w-5 h-5 text-gray-400" />
        </div>
        <input 
          v-model="search"
          type="text" 
          placeholder="Cari Mata Pelajaran..."
          class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
        />
      </div>
      <div class="relative w-full sm:w-48">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <FunnelIcon class="w-5 h-5 text-gray-400" />
        </div>
        <select 
          v-model="filterStatus"
          class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-green-500"
        >
          <option>Filter Status</option>
          <option>Selesai</option>
          <option>Akan Datang</option>
        </select>
      </div>
    </div>

    <div class="mt-4 text-sm font-semibold text-gray-700">
      {{ filteredSchedules.length }} Jadwal Tersedia
    </div>

    <div class="mt-4 space-y-4">
      
      <div v-if="isLoading" class="text-center py-10 text-gray-500">
        Memuat jadwal...
      </div>

      <div 
        v-else
        v-for="schedule in filteredSchedules" 
        :key="schedule.id" 
        class="bg-white rounded-lg shadow overflow-hidden"
      >
        
        <button @click="toggleSchedule(schedule.id)" class="w-full p-4 flex justify-between items-center text-left">
          <div>
            <p class="text-sm text-gray-500">{{ schedule.tanggal }} ({{ schedule.hari }})</p>
            <p class="text-lg font-semibold text-gray-800">{{ schedule.pelajaran }}</p>
          </div>
          <div class="flex items-center gap-4">
            <span :class="schedule.status === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'" class="px-3 py-1 rounded-full text-sm font-medium">
              {{ schedule.status }}
            </span>
            <span class="text-gray-500 text-sm font-medium">{{ schedule.waktu }}</span>
            <ChevronUpIcon v-if="openScheduleId === schedule.id" class="w-6 h-6 text-gray-500" />
            <ChevronDownIcon v-else class="w-6 h-6 text-gray-500" />
          </div>
        </button>

        <div v-if="openScheduleId === schedule.id" class="p-6 border-t border-gray-200">
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div class="flex items-center gap-2">
              <UserIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Guru: <span class="font-medium text-gray-800">{{ schedule.details.guru }}</span></span>
            </div>
            <div class="flex items-center gap-2">
              <BookmarkIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Topik: <span class="font-medium text-gray-800">{{ schedule.details.topik }}</span></span>
            </div>
            <div class="flex items-center gap-2">
              <MapPinIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Lokasi: <span class="font-medium text-gray-800">{{ schedule.details.lokasi }}</span></span>
            </div>
            <div class="flex items-center gap-2">
              <CheckCircleIcon class="w-5 h-5 text-gray-400" />
              <span class="text-gray-600">Kehadiran: <span class="font-medium text-gray-800">{{ schedule.details.kehadiran }}</span></span>
            </div>
          </div>

          <div class="mt-6">
            <h4 class="font-semibold text-gray-800">Deskripsi Pembelajaran</h4>
            <p class="mt-1 text-sm text-gray-600">{{ schedule.details.deskripsi }}</p>
          </div>

          <div class="mt-6">
            <h4 class="font-semibold text-gray-800">Materi Pembelajaran ({{ schedule.details.materi.length }} File)</h4>
            <div class="mt-2 space-y-2">
              <div v-for="(file, index) in schedule.details.materi" :key="index" class="flex justify-between items-center p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                  <DocumentTextIcon class="w-6 h-6 text-green-600" />
                  <div>
                    <p class="text-sm font-medium text-gray-800">{{ file.nama }}</p>
                    <p class="text-xs text-gray-500">{{ file.tipe }} - {{ file.ukuran }}</p>
                  </div>
                </div>
                <button class="flex items-center gap-1 text-sm text-green-600 font-medium hover:text-green-800">
                  <ArrowDownTrayIcon class="w-4 h-4" />
                  Unduh
                </button>
              </div>
              <div v-if="schedule.details.materi.length === 0" class="text-sm text-gray-500 italic">
                Tidak ada materi terlampir.
              </div>
            </div>
          </div>

          <div class="mt-6">
            <h4 class="font-semibold text-gray-800">Catatan Dari Guru</h4>
            <p class="mt-1 text-sm text-gray-600">{{ schedule.details.catatan }}</p>
          </div>

        </div>
      </div>
    </div>

  </div>
</template> -->

<template>
  <div class="min-h-screen" style="background: linear-gradient(135deg, #fafaf8 0%, #f5f3f0 100%)">
    
    <div class="p-6 md:p-8 max-w-6xl mx-auto">
      
      <!-- Header -->
      <header class="mb-10">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-1 h-8 bg-[#78AE4E] rounded-full"></div>
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Jadwal Belajar</h1>
        </div>
        <p class="text-gray-600 text-lg">Lihat jadwal pembelajaran dan akses materi pembelajaran</p>
      </header>

      <!-- Search & Filter -->
      <div class="flex flex-col sm:flex-row gap-4 mb-8">
        <div class="relative flex-1">
          <MagnifyingGlassIcon class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
          <input 
            v-model="search"
            type="text" 
            placeholder="Cari mata pelajaran..."
            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#78AE4E] focus:ring-2 focus:ring-green-100 transition-all"
          />
        </div>
        <div class="relative w-full sm:w-56">
          <FunnelIcon class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" />
          <select 
            v-model="filterStatus"
            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#78AE4E] focus:ring-2 focus:ring-green-100 appearance-none bg-white transition-all cursor-pointer font-medium"
          >
            <option>Filter Status</option>
            <option>Selesai</option>
            <option>Akan Datang</option>
          </select>
        </div>
      </div>

      <!-- Count Info -->
      <div class="text-sm font-bold text-gray-600 mb-6 uppercase tracking-wide">
        {{ filteredSchedules.length }} Jadwal Tersedia
      </div>

      <!-- Schedule List -->
      <div class="space-y-4">
        
        <div v-if="isLoading" class="text-center py-16 text-gray-500">
          <div class="inline-block p-3 bg-gray-200 rounded-full mb-4 animate-spin"></div>
          <p class="text-lg">Memuat jadwal...</p>
        </div>

        <div 
          v-else
          v-for="schedule in filteredSchedules" 
          :key="schedule.id" 
          class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:border-[#78AE4E] transition-all"
        >
          
          <!-- Schedule Header (Always Visible) -->
          <button @click="toggleSchedule(schedule.id)" class="w-full p-6 flex justify-between items-center text-left hover:bg-gray-50 transition-colors">
            <div class="flex-1">
              <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">{{ schedule.tanggal }} • {{ schedule.hari }}</p>
              <p class="text-xl font-bold text-gray-900">{{ schedule.pelajaran }}</p>
            </div>
            <div class="flex items-center gap-4">
              <span :class="[
                'px-3 py-1.5 rounded-lg text-sm font-bold',
                schedule.status === 'Selesai' 
                  ? 'bg-[#78AE4E] text-white' 
                  : 'bg-[#F9C70F] text-gray-900'
              ]">
                {{ schedule.status }}
              </span>
              <span class="text-gray-600 text-sm font-bold whitespace-nowrap">{{ schedule.waktu }}</span>
              <div class="w-6 h-6 flex items-center justify-center">
                <ChevronUpIcon v-if="openScheduleId === schedule.id" class="w-6 h-6 text-[#78AE4E]" />
                <ChevronDownIcon v-else class="w-6 h-6 text-gray-400" />
              </div>
            </div>
          </button>

          <!-- Expanded Details -->
          <div v-if="openScheduleId === schedule.id" class="border-t border-gray-200 p-6 bg-gradient-to-b from-gray-50 to-white">
            
            <!-- Info Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
              <div class="flex items-start gap-3">
                <UserIcon class="w-5 h-5 text-[#78AE4E] mt-0.5" />
                <div>
                  <p class="text-xs font-bold text-gray-600 uppercase">Guru Pengampu</p>
                  <p class="text-gray-900 font-semibold">{{ schedule.details.guru }}</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <BookmarkIcon class="w-5 h-5 text-[#78AE4E] mt-0.5" />
                <div>
                  <p class="text-xs font-bold text-gray-600 uppercase">Topik Pembelajaran</p>
                  <p class="text-gray-900 font-semibold">{{ schedule.details.topik }}</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <MapPinIcon class="w-5 h-5 text-[#78AE4E] mt-0.5" />
                <div>
                  <p class="text-xs font-bold text-gray-600 uppercase">Lokasi</p>
                  <p class="text-gray-900 font-semibold">{{ schedule.details.lokasi }}</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <CheckCircleIcon class="w-5 h-5 text-[#78AE4E] mt-0.5" />
                <div>
                  <p class="text-xs font-bold text-gray-600 uppercase">Status Kehadiran</p>
                  <p class="text-gray-900 font-semibold">{{ schedule.details.kehadiran }}</p>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
              <h4 class="font-bold text-gray-900 mb-3 text-sm uppercase">Deskripsi Pembelajaran</h4>
              <p class="text-gray-700 leading-relaxed">{{ schedule.details.deskripsi }}</p>
            </div>

            <!-- Materials -->
            <div class="mb-8">
              <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-1 h-5 bg-[#78AE4E] rounded-full"></span>
                Materi Pembelajaran ({{ schedule.details.materi.length }} File)
              </h4>
              <div class="space-y-2">
                <div v-for="(file, index) in schedule.details.materi" :key="index" class="flex justify-between items-center p-4 border border-gray-200 rounded-lg hover:border-[#78AE4E] hover:bg-green-50 transition-all">
                  <div class="flex items-center gap-3">
                    <div class="p-2 bg-[#EB9232] rounded-lg">
                      <DocumentTextIcon class="w-5 h-5 text-white" />
                    </div>
                    <div>
                      <p class="text-sm font-bold text-gray-900">{{ file.nama }}</p>
                      <p class="text-xs text-gray-600">{{ file.tipe }} • {{ file.ukuran }}</p>
                    </div>
                  </div>
                  <button class="flex items-center gap-2 text-sm font-bold text-[#78AE4E] hover:text-[#76B340] transition-colors">
                    <ArrowDownTrayIcon class="w-4 h-4" />
                    Unduh
                  </button>
                </div>
                <div v-if="schedule.details.materi.length === 0" class="text-sm text-gray-500 italic p-4 text-center">
                  Tidak ada materi terlampir
                </div>
              </div>
            </div>

            <!-- Teacher Notes -->
            <div class="pt-6 border-t border-gray-200">
              <h4 class="font-bold text-gray-900 mb-3 text-sm uppercase">Catatan dari Guru</h4>
              <p class="text-gray-700 leading-relaxed italic">{{ schedule.details.catatan }}</p>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { 
  MagnifyingGlassIcon, 
  FunnelIcon,
  ChevronUpIcon,
  ChevronDownIcon,
  UserIcon,
  MapPinIcon,
  BookmarkIcon,
  CheckCircleIcon,
  ArrowDownTrayIcon,
  DocumentTextIcon
} from '@heroicons/vue/24/outline';

// State
const rawSchedules = ref([]); 
const search = ref(''); 
const filterStatus = ref('Filter Status'); 
const openScheduleId = ref(null);
const isLoading = ref(true);

// Fetch Data
const fetchJadwal = async () => {
  try {
    const response = await axios.get('/api/jadwal-lengkap');
    
    // 5. PERBAIKAN DEFENSIF: Cek apakah data benar-benar array
    if (Array.isArray(response.data)) {
      rawSchedules.value = response.data;
      
      // Buka accordion pertama jika ada data
      if (rawSchedules.value.length > 0) {
        openScheduleId.value = rawSchedules.value[0].id;
      }
    } else {
      console.error("Format data API salah (bukan array):", response.data);
      rawSchedules.value = []; // Paksa jadi array kosong biar tidak error
    }

  } catch (error) {
    console.error("Gagal ambil jadwal:", error);
    rawSchedules.value = []; // Fallback jika error
  } finally {
    isLoading.value = false;
  }
};

// Computed Property
const filteredSchedules = computed(() => {
  // 6. PERBAIKAN DEFENSIF: Pastikan rawSchedules.value selalu array sebelum di-filter
  const list = Array.isArray(rawSchedules.value) ? rawSchedules.value : [];

  return list.filter(schedule => {
    const matchStatus = filterStatus.value === 'Filter Status' 
      ? true 
      : schedule.status === filterStatus.value;
      
    const matchSearch = schedule.pelajaran.toLowerCase().includes(search.value.toLowerCase());

    return matchStatus && matchSearch;
  });
});

const toggleSchedule = (id) => {
  if (openScheduleId.value === id) {
    openScheduleId.value = null;
  } else {
    openScheduleId.value = id;
  }
};

onMounted(() => {
  fetchJadwal();
});
</script>