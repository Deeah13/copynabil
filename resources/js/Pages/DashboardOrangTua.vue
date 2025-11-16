<!-- <template>
  <div class="p-6 md:p-8 bg-gray-50 min-h-screen">

    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <div class="text-sm text-gray-500">Beranda</div>
        <h1 class="text-3xl font-bold text-gray-900">Selamat Datang, Ibu Amel</h1>
        <p class="text-gray-600">Pantau perkembangan pendidikan anak Anda di Terminal Pintar</p>
      </div>

      <div class="shrink-0">
        <label for="nama-anak" class="text-sm font-medium text-gray-700">Nama Anak</label>
        <button id="nama-anak"
          class="flex items-center justify-between w-full sm:w-auto mt-1 space-x-4 rounded-lg border bg-white px-3 py-2 text-sm">
          <span>{{ dashboardData.nama_anak }}</span>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
      </div>
    </header>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

      <main class="lg:col-span-2 space-y-6">

        <section>
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-5 rounded-lg shadow">
              <div class="flex justify-between items-center">
                <div class="p-2 bg-green-100 rounded-full">
                  <CheckBadgeIcon class="w-6 h-6 text-green-700" />
                </div>
                <span class="text-sm font-semibold text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded-full">
                  {{ dashboardData.ringkasan?.persentase_kehadiran || 0 }}%
                </span>
              </div>
              <div class="mt-3">
                <p class="text-gray-500 text-sm">Kehadiran Bulan Ini</p>
                <p class="text-2xl font-bold">{{ dashboardData.ringkasan?.kehadiran || '-' }}</p>
                <p class="text-gray-500 text-sm">Pertemuan</p>
              </div>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
              <div class="flex justify-between items-center">
                <div class="p-2 bg-green-100 rounded-full">
                  <DocumentTextIcon class="w-6 h-6 text-green-700" />
                </div>
                <span class="text-sm font-semibold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">100%</span>
              </div>
              <div class="mt-3">
                <p class="text-gray-500 text-sm">Catatan Baru</p>
                <p class="text-2xl font-bold">{{ dashboardData.ringkasan?.catatan_baru || 0 }}</p>
                <p class="text-gray-500 text-sm">Dari guru</p>
              </div>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
              <div class="flex justify-between items-center">
                <div class="p-2 bg-green-100 rounded-full">
                  <CalendarDaysIcon class="w-6 h-6 text-green-700" />
                </div>
              </div>
              <div class="mt-3">
                <p class="text-gray-500 text-sm">Jadwal berikutnya</p>
                <p class="text-xl font-bold">{{ dashboardData.ringkasan?.jadwal_berikutnya || '-' }}</p>
                <p class="text-gray-500 text-sm">{{ dashboardData.ringkasan?.tanggal_jadwal_berikutnya || '-' }}</p>
              </div>
            </div>

          </div>
        </section>

        <section class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-lg font-semibold text-gray-900 mb-4">Pintasan</h2>

          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
              <button @click="activeTab = 'riwayat'" :class="[
                activeTab === 'riwayat'
                  ? 'border-green-600 text-green-700'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm'
              ]">
                Riwayat Kehadiran
              </button>
              <button @click="activeTab = 'catatan'" :class="[
                activeTab === 'catatan'
                  ? 'border-green-600 text-green-700'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                'whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm'
              ]">
                Catatan Guru
              </button>
            </nav>
          </div>

          <div class="mt-6">
            <div v-if="activeTab === 'riwayat'" class="space-y-4">

              <div class="flex items-center gap-2 mb-4">
                <CheckBadgeIcon class="w-6 h-6 text-[#78AE4E]" />
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Kehadiran</h3>
              </div>

              <div v-for="item in riwayatKehadiran" :key="item.id"
                class="bg-gray-50 border border-gray-100 rounded-lg p-4 flex justify-between items-start hover:shadow-sm transition-shadow">
                <div class="space-y-1">
                  <h4 class="font-semibold text-gray-900">{{ item.pelajaran }}</h4>

                  <div class="flex items-center gap-2 text-sm text-gray-600">
                    <CalendarDaysIcon class="w-4 h-4" />
                    <span>{{ item.tanggal }}</span>
                  </div>

                  <div class="flex items-center gap-2 text-sm text-gray-600">
                    <ClockIcon class="w-4 h-4" />
                    <span>{{ item.waktu }}</span>
                  </div>
                </div>

                <div>
                  <span class="bg-[#78AE4E] text-white text-xs font-medium px-3 py-1 rounded-full">
                    {{ item.status }}
                  </span>
                </div>
              </div>

            </div>

            <div v-if="activeTab === 'catatan'" class="space-y-5">
              <h3 class="text-md font-semibold text-gray-800">Catatan Terbaru</h3>

              <div v-for="catatan in catatanTerbaru" :key="catatan.id">
                <div class="flex justify-between items-start">
                  <p class="font-semibold text-gray-800">{{ catatan.pelajaran }}</p>
                  <span class="text-xs text-gray-500">{{ catatan.tanggal }}</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">{{ catatan.isi }}</p>
                <div class="flex items-center space-x-1 mt-2">
                  <UserCircleIcon class="w-4 h-4 text-gray-400" />
                  <span class="text-xs text-gray-500">{{ catatan.guru }}</span>
                </div>
              </div>

              <div class="pt-4">
                <div class="pt-4">
                  <router-link to="/dashboard-catatan"
                    class="block w-full text-center py-2 px-4 border border-[#78AE4E] text-[#78AE4E] rounded-lg hover:bg-green-50 text-sm font-medium transition-colors">
                    Lihat Catatan Lengkap
                  </router-link>
                </div>
              </div>
            </div>
          </div>

        </section>

      </main>

      <aside class="lg:col-span-1">
        <div class="bg-white p-6 rounded-lg shadow space-y-6">
          <h3 class="text-lg font-semibold text-gray-900">Jadwal Mendatang</h3>

          <div class="space-y-5">
            <div v-for="jadwal in jadwalMendatang" :key="jadwal.id" class="flex space-x-3">
              <div class="p-2 bg-green-100 rounded-full h-fit">
                <CalendarDaysIcon class="w-5 h-5 text-green-700" />
              </div>
              <div>
                <p class="font-semibold text-gray-800">{{ jadwal.pelajaran }}</p>
                <p class="text-sm text-gray-600">{{ jadwal.tanggal }}</p>
                <div class="flex items-center space-x-1 mt-1">
                  <ClockIcon class="w-4 h-4 text-gray-400" />
                  <span class="text-xs text-gray-500">{{ jadwal.waktu }}</span>
                </div>
                <div class="flex items-center space-x-1 mt-1">
                  <UserIcon class="w-4 h-4 text-gray-400" />
                  <span class="text-xs text-gray-500">{{ jadwal.guru }}</span>
                </div>
              </div>
            </div>
          </div>

          <router-link to="/dashboard-jadwal"
            class="block w-full text-center py-2 px-4 border border-[#78AE4E] text-[#78AE4E] rounded-lg hover:bg-green-50 text-sm font-medium transition-colors">
            Lihat Jadwal Lengkap
          </router-link>
        </div>
      </aside>

    </div>
  </div>
</template> -->

<template>
  <div class="min-h-screen" style="background: linear-gradient(135deg, #fafaf8 0%, #f5f3f0 100%)">
    
    <div class="p-6 md:p-8 max-w-7xl mx-auto">
      
      <!-- Header Section -->
      <header class="mb-10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
          <div>
            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Beranda</div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">Selamat Datang, Ibu Amel</h1>
            <p class="text-gray-600 mt-2">Pantau perkembangan pendidikan anak Anda di Terminal Pintar</p>
          </div>

          <div class="shrink-0 w-full sm:w-auto">
            <label for="nama-anak" class="text-xs font-semibold text-gray-700 uppercase tracking-wide block mb-2">Nama Anak</label>
            <button id="nama-anak"
              class="flex items-center justify-between w-full sm:w-56 rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm font-medium hover:border-[#78AE4E] transition-colors duration-200">
              <span class="text-gray-900">{{ dashboardData.nama_anak }}</span>
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
          </div>
        </div>
      </header>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Main Content -->
        <main class="lg:col-span-2 space-y-8">

          <!-- Summary Cards Section -->
          <section>
            <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
              <span class="w-1 h-6 bg-[#78AE4E] rounded-full"></span>
              Ringkasan Bulan Ini
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

              <!-- Kehadiran Card -->
              <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                  <div class="p-3 bg-gradient-to-br from-[#78AE4E] to-[#76B340] rounded-xl">
                    <CheckBadgeIcon class="w-6 h-6 text-white" />
                  </div>
                  <span class="text-xs font-bold text-white bg-[#F9C70F] px-3 py-1.5 rounded-full">
                    {{ dashboardData.ringkasan?.persentase_kehadiran || 0 }}%
                  </span>
                </div>
                <div>
                  <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Kehadiran</p>
                  <p class="text-3xl font-bold text-gray-900 mt-1">{{ dashboardData.ringkasan?.kehadiran || '-' }}</p>
                  <p class="text-gray-500 text-sm mt-1">pertemuan</p>
                </div>
              </div>

              <!-- Catatan Baru Card -->
              <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                  <div class="p-3 bg-gradient-to-br from-[#EB9232] to-[#F0A74F] rounded-xl">
                    <DocumentTextIcon class="w-6 h-6 text-white" />
                  </div>
                  <span class="text-xs font-bold text-white bg-[#EB9232] px-3 py-1.5 rounded-full">Baru</span>
                </div>
                <div>
                  <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Catatan</p>
                  <p class="text-3xl font-bold text-gray-900 mt-1">{{ dashboardData.ringkasan?.catatan_baru || 0 }}</p>
                  <p class="text-gray-500 text-sm mt-1">dari guru</p>
                </div>
              </div>

              <!-- Jadwal Berikutnya Card -->
              <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                  <div class="p-3 bg-gradient-to-br from-[#F9C70F] to-[#FFD700] rounded-xl">
                    <CalendarDaysIcon class="w-6 h-6 text-gray-900" />
                  </div>
                </div>
                <div>
                  <p class="text-gray-600 text-xs font-medium uppercase tracking-wide">Jadwal Berikutnya</p>
                  <p class="text-2xl font-bold text-gray-900 mt-1">{{ dashboardData.ringkasan?.jadwal_berikutnya || '-' }}</p>
                  <p class="text-gray-500 text-sm mt-1">{{ dashboardData.ringkasan?.tanggal_jadwal_berikutnya || '-' }}</p>
                </div>
              </div>

            </div>
          </section>

          <!-- Tabs Section -->
          <section class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 md:p-7">
              <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-[#78AE4E] rounded-full"></span>
                Riwayat & Catatan
              </h2>

              <!-- Tab Navigation -->
              <div class="border-b border-gray-200 mb-6">
                <nav class="flex gap-8">
                  <button @click="activeTab = 'riwayat'" :class="[
                    activeTab === 'riwayat'
                      ? 'border-b-2 border-[#78AE4E] text-[#78AE4E]'
                      : 'border-b-2 border-transparent text-gray-600 hover:text-gray-900',
                    'py-3 px-1 font-semibold text-sm transition-colors'
                  ]">
                    Riwayat Kehadiran
                  </button>
                  <button @click="activeTab = 'catatan'" :class="[
                    activeTab === 'catatan'
                      ? 'border-b-2 border-[#78AE4E] text-[#78AE4E]'
                      : 'border-b-2 border-transparent text-gray-600 hover:text-gray-900',
                    'py-3 px-1 font-semibold text-sm transition-colors'
                  ]">
                    Catatan Guru
                  </button>
                </nav>
              </div>

              <!-- Tab Content -->
              <div class="space-y-4">
                <div v-if="activeTab === 'riwayat'" class="space-y-4">
                  <div v-for="item in riwayatKehadiran" :key="item.id"
                    class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-5 flex justify-between items-start hover:border-[#78AE4E] hover:shadow-md transition-all">
                    <div class="space-y-2">
                      <h4 class="font-bold text-gray-900">{{ item.pelajaran }}</h4>
                      <div class="flex items-center gap-2 text-sm text-gray-600">
                        <CalendarDaysIcon class="w-4 h-4" />
                        <span>{{ item.tanggal }}</span>
                      </div>
                      <div class="flex items-center gap-2 text-sm text-gray-600">
                        <ClockIcon class="w-4 h-4" />
                        <span>{{ item.waktu }}</span>
                      </div>
                    </div>
                    <span class="bg-[#78AE4E] text-white text-xs font-bold px-4 py-2 rounded-lg whitespace-nowrap">
                      {{ item.status }}
                    </span>
                  </div>
                </div>

                <div v-if="activeTab === 'catatan'" class="space-y-5">
                  <div v-for="catatan in catatanTerbaru" :key="catatan.id" 
                    class="border-l-4 border-[#78AE4E] pl-4 py-2">
                    <div class="flex justify-between items-start mb-2">
                      <p class="font-bold text-gray-900">{{ catatan.pelajaran }}</p>
                      <span class="text-xs text-gray-500 font-medium">{{ catatan.tanggal }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ catatan.isi }}</p>
                    <div class="flex items-center space-x-1 mt-3">
                      <UserCircleIcon class="w-4 h-4 text-[#78AE4E]" />
                      <span class="text-xs text-gray-600 font-medium">{{ catatan.guru }}</span>
                    </div>
                  </div>

                  <router-link to="/dashboard-catatan"
                    class="block w-full text-center py-3 px-4 border-2 border-[#78AE4E] text-[#78AE4E] rounded-xl hover:bg-green-50 text-sm font-bold transition-colors mt-4">
                    Lihat Catatan Lengkap →
                  </router-link>
                </div>
              </div>

            </div>
          </section>

        </main>

        <!-- Right Column: Sidebar -->
        <aside class="lg:col-span-1">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7 sticky top-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
              <span class="w-1 h-6 bg-[#78AE4E] rounded-full"></span>
              Jadwal Mendatang
            </h3>

            <div class="space-y-6">
              <div v-for="jadwal in jadwalMendatang" :key="jadwal.id" class="border-b border-gray-100 pb-5 last:border-0 last:pb-0">
                <div class="flex gap-3">
                  <div class="p-2.5 bg-gradient-to-br from-[#78AE4E] to-[#76B340] rounded-lg h-fit">
                    <CalendarDaysIcon class="w-5 h-5 text-white" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 text-sm">{{ jadwal.pelajaran }}</p>
                    <p class="text-xs text-gray-600 mt-1">{{ jadwal.tanggal }}</p>
                    <div class="flex items-center gap-1 mt-2">
                      <ClockIcon class="w-3.5 h-3.5 text-gray-400" />
                      <span class="text-xs text-gray-600">{{ jadwal.waktu }}</span>
                    </div>
                    <div class="flex items-center gap-1 mt-1">
                      <UserIcon class="w-3.5 h-3.5 text-gray-400" />
                      <span class="text-xs text-gray-600">{{ jadwal.guru }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <router-link to="/dashboard-jadwal"
              class="block w-full text-center py-3 px-4 border-2 border-[#78AE4E] text-[#78AE4E] rounded-xl hover:bg-green-50 text-sm font-bold transition-colors mt-6">
              Lihat Jadwal Lengkap →
            </router-link>
          </div>
        </aside>

      </div>

    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import {
  CheckBadgeIcon,
  DocumentTextIcon,
  CalendarDaysIcon,
  UserCircleIcon,
  ClockIcon,
  UserIcon
} from '@heroicons/vue/24/outline';

// State untuk tab yang aktif
const activeTab = ref('catatan');

// DEFINISIKAN SEMUA VARIABEL DI AWAL (SEBELUM DIGUNAKAN)
const catatanTerbaru = ref([]);
const jadwalMendatang = ref([]);
const riwayatKehadiran = ref([]);

// State Data Dashboard dengan default values
const dashboardData = ref({
  nama_anak: 'Memuat...',
  ringkasan: {
    kehadiran: '-',
    persentase_kehadiran: 0,
    catatan_baru: 0,
    jadwal_berikutnya: '-',
    tanggal_jadwal_berikutnya: '-'
  }
});

const fetchDashboardData = async () => {
  try {
    // Pastikan endpoint benar dan mengembalikan JSON
    const response = await axios.get('/api/dashboard-orang-tua', {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    
    console.log('Dashboard data loaded:', response.data);

    // Validasi response adalah object, bukan HTML string
    if (typeof response.data === 'object' && response.data !== null) {
      dashboardData.value = {
        ...dashboardData.value,
        ...response.data
      };

      // Isi data array dengan fallback ke array kosong
      catatanTerbaru.value = response.data.catatan_terbaru || [];
      jadwalMendatang.value = response.data.jadwal_mendatang || [];
      riwayatKehadiran.value = response.data.riwayat_kehadiran || [];
    } else {
      console.error('API mengembalikan format yang salah (bukan JSON)');
    }

  } catch (error) {
    console.error("Gagal memuat dashboard:", error);
    
    // Handle berbagai jenis error
    if (error.response) {
      if (error.response.status === 401) {
        window.location.href = '/login';
      } else {
        console.error('Server error:', error.response.status);
      }
    } else if (error.request) {
      console.error('Network error - tidak ada response dari server');
    }
  }
};

onMounted(() => {
  fetchDashboardData();
});
</script>

<style scoped>
/* Styling ditangani oleh Tailwind */
</style>