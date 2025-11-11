<template>
  <div class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <div class="text-2xl font-bold text-green-700">Terminal Pintar</div>
        <div class="hidden md:flex space-x-6 items-center">
          <a href="#kegiatan" class="text-gray-600 hover:text-green-700">Kegiatan</a>
          <a href="#tentang" class="text-gray-600 hover:text-green-700">Tentang Kami</a>
          <a href="#kontak" class="text-gray-600 hover:text-green-700">Kontak</a>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Login
          </button>
        </div>
        </div>
    </nav>

    <header class="bg-green-700 text-white p-12 md:p-20 text-center" style="background-color: #79a87c; /* Warna hijau dari gambar */">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Halo, Selamat Datang di Terminal Pintar!</h1>
      <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto">
        Mari bergabung bersama kami membangun komunitas untuk anak-anak Indonesia demi mendukung masa depan yang lebih baik.
      </p>
      <button class="bg-white text-green-700 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100">
        Jelajah lebih lanjut
      </button>
    </header>

    <main class="container mx-auto px-6 py-12">
      
      <section id="kegiatan" class="mb-16">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Dokumentasi Kegiatan Terbaru Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <div v-for="kegiatan in kegiatanTerbaru" :key="kegiatan.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img :src="kegiatan.imageUrl" alt="Foto Kegiatan" class="w-full h-48 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">{{ kegiatan.judul }}</h3>
              <p class="text-sm text-gray-500 mb-3">{{ kegiatan.tanggal }}</p>
              <p class="text-gray-700 mb-4">{{ kegiatan.deskripsi }}</p>
              <a href="#" class="text-green-600 font-semibold hover:underline">Baca Selengkapnya</a>
            </div>
          </div>
          
        </div>
        <div class="text-center mt-8">
          <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Lihat Semua Kegiatan
          </button>
        </div>
      </section>

      <section id="tentang" class="mb-16 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Tentang Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h3 class="text-2xl font-semibold text-green-700 mb-3">SEJARAH</h3>
            <p class="text-gray-700 leading-relaxed">
              Pibleungon pada tanggal 17 Agustus 1953 (ini adalah placeholder, ganti dengan teks Anda)...
            </p>
          </div>
          <div>
            <h3 class="text-2xl font-semibold text-green-700 mb-3">VISI</h3>
            <p class="text-gray-700 leading-relaxed">
              Visi yang diusung adalah menjadikan Terminal Pintar sebagai "teman perjalanan" bagi anak-anak... 
            </p>
          </div>
        </div>
      </section>

      <section id="pengurus" class="mb-16">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Tim Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
          
          <div v-for="orang in pengurus" :key="orang.id" class="bg-white p-6 rounded-lg shadow-lg">
            <img :src="orang.imageUrl" alt="Foto Pengurus" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold">{{ orang.nama }}</h3>
            <p class="text-gray-600">{{ orang.jabatan }}</p>
          </div>

        </div>
      </section>

      <section id="kontribusi" class="mb-16 bg-green-100 p-8 rounded-lg text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Mari Berkontribusi Membangun Harapan!</h2>
        <div class="flex flex-col md:flex-row justify-center gap-6">
          <div class="bg-white p-6 rounded-lg shadow-md flex-1">
            <h3 class="text-2xl font-semibold text-yellow-600 mb-3">DONASI</h3>
            <p class="text-gray-700 mb-4">Mari ikut berkontribusi untuk membantu mereka yang membutuhkan.</p>
            <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
              Lihat Cara Donasi
            </button>
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md flex-1">
            <h3 class="text-2xl font-semibold text-yellow-600 mb-3">RELAWAN</h3>
            <p class="text-gray-700 mb-4">Mari ikut mengajar dan berbagi untuk membantu mereka yang membutuhkan.</p>
            <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
              Lihat Cara Mendaftar
            </button>
          </div>
        </div>
      </section>
    </main>

    <footer class="bg-gray-800 text-white p-8">
      <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
          <h4 class="text-lg font-semibold mb-3">Kontak Kami</h4>
          <p class="mb-2">📞 +628123456789</p>
          <p>✉️ terminalpintar@gmail.com</p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-3">Media Sosial</h4>
          <p class="mb-2">Instagram: @terminalpintar_id</p>
          <p class="mb-2">Twitter: @TerminalPintar</p>
          <p>YouTube: Terminal Pintar</p>
        </div>
      </div>
      <div class="text-center text-gray-500 mt-8 border-t border-gray-700 pt-4">
        © 2025 Terminal Pintar. All rights reserved.
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios'; // Pastikan Anda sudah install axios

// Refs untuk menampung data dari API
const kegiatanTerbaru = ref([]);
const pengurus = ref([]);

// Fungsi untuk mengambil data dari backend Laravel
const fetchLandingData = async () => {
  try {
    // URL ini akan mengarah ke route API Laravel Anda
    const response = await axios.get('/api/landing-data');
    
    // Mengisi data ke refs
    kegiatanTerbaru.value = response.data.kegiatan;
    pengurus.value = response.data.pengurus;

  } catch (error) {
    console.error('Gagal mengambil data landing page:', error);
  }
};

// Panggil fungsi fetchLandingData() saat komponen di-mount
onMounted(() => {
  fetchLandingData();
});
</script>

<style scoped>
/* Anda bisa tambahkan style kustom di sini jika diperlukan */
</style>