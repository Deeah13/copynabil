<!-- <template>
  <div class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <div class="text-2xl font-bold text-green-700">Terminal Pintar</div>
        <div class="hidden md:flex space-x-6 items-center">
          <a href="#kegiatan" class="text-gray-600 hover:text-green-700">Kegiatan</a>
          <a href="#tentang" class="text-gray-600 hover:text-green-700">Tentang Kami</a>
          <a href="#kontak" class="text-gray-600 hover:text-green-700">Kontak</a>
          <router-link 
            to="/login"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Login
          </router-link>
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
</style> -->


<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const kegiatan = ref([]);
const isLoading = ref(true);

onMounted(async () => {
  try {
    const response = await axios.get('/api/kegiatan-terbaru');
    kegiatan.value = response.data;
  } catch (error) {
    console.error("Gagal mengambil data kegiatan:", error);
  } finally {
    isLoading.value = false;
  }
});

const formatTanggal = (dateString) => {
  if (!dateString) return '';
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>

<template>
  <div class="landing-page font-sans">
    
    <header class="bg-white border-b border-gray-200 py-4 sticky top-0 z-50">
      <div class="px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center">
          <img src="/public/images/Logo.png" alt="Logo Terminal Pintar" class="h-10 w-10 mr-3 rounded-full">
          <span class="text-2xl font-bold text-[#76B340]">
            Terminal Pintar
          </span>
        </div>
        
        <nav class="flex items-center space-x-6">
          <a href="#kegiatan" class="text-gray-700 font-medium hover:text-[#76B340] transition-colors">Kegiatan</a>
          <a href="#tentang" class="text-gray-700 font-medium hover:text-[#76B340] transition-colors">Tentang Kami</a>
          <a href="#kontak" class="text-gray-700 font-medium hover:text-[#76B340] transition-colors">Kontak</a>
          <Link 
            href="/login" 
            class="bg-[#76B340] text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-opacity-80 transition-colors"
          >
            Login
          </Link>
        </nav>
      </div>
    </header>
    
    <section 
    class="hero-section relative bg-cover bg-center h-[350px] flex items-center text-white"
    style="background-image: url('images/hero.jpg');"
    >

      <div class="absolute inset-0 bg-[#76B340] opacity-60"></div>
      
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10 relative">
        <h1 class="text-5xl font-bold mb-4 italic">
          Halo, Selamat Datang di Terminal Pintar!
        </h1>
        <p class="text-lg font-light max-w-2xl mx-auto mb-8 italic">
          Mari bergabung bersama kami untuk belajar, berbagi inspirasi, menjadi relawan, atau berdonasi demi mendukung masa depan yang lebih baik.
        </p>
        <a 
        href="#kegiatan"
        class="bg-white text-[#76B340] px-6 py-3 rounded-full text-base font-semibold hover:bg-gray-100 transition-colors"
        >
        Jelajah lebih lanjut
      </a>
      </div>
    </section>

    <section id="kegiatan" class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-[#76B340] mb-12">
          Dokumentasi Kegiatan Terbaru Kami
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <div v-if="!isLoading && kegiatan.length > 0" v-for="item in kegiatan" :key="item.id" class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
            <img :src="item.gambar_url || 'https://via.placeholder.com/400x200'" :alt="item.judul" class="h-56 w-full object-cover">
            <div class="p-6 grow">
              <h3 class="font-bold text-xl mb-2">{{ item.judul }}</h3>
              <p class="text-sm text-gray-500 mb-3">{{ formatTanggal(item.tanggal_kegiatan) }}</p>
              <p class="text-gray-700 text-base mb-4">{{ item.deskripsi_singkat }}</p>
            </div>
            <div class="p-6 pt-0">
              <a href="#" class="bg-white border border-[#76B340] text-[#76B340] px-5 py-2 rounded text-sm font-semibold hover:bg-gray-50 transition-colors">Baca Selengkapnya</a>
            </div>
          </div>

          <div v-if="isLoading" v-for="n in 3" :key="n" class="bg-white rounded-lg shadow-lg overflow-hidden animate-pulse">
            <div class="h-56 w-full bg-gray-300"></div>
            <div class="p-6">
              <div class="h-6 bg-gray-300 rounded mb-2"></div>
              <div class="h-4 bg-gray-300 rounded w-1/2 mb-3"></div>
              <div class="h-4 bg-gray-300 rounded mb-1"></div>
              <div class="h-4 bg-gray-300 rounded mb-4"></div>
              <div class="h-5 bg-gray-300 rounded w-1/3"></div>
            </div>
          </div>

        </div>
        
        <div class="text-center mt-12">
          <a 
            href="#"
            class="bg-[#76B340] text-white px-6 py-3 rounded text-base font-semibold hover:bg-opacity-80 transition-colors"
          >
            Lihat semua kegiatan
          </a>
        </div>
      </div>
    </section>

    <section id="tentang" class="py-20 bg-white">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-[#76B340] mb-12">
          Tentang Kami
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
          <div class="border-2 border-gray-200 p-8 rounded-lg shadow-sm">
            <h3 class="font-bold text-2xl text-[#76B340] mb-4 text-center">SEJARAH</h3>
            <p class="text-gray-700 leading-relaxed text-center">
              Dibangun pada tanggal 17 Agustus 1502 berdasarkan perintah Kaisar dari Dinasti Ming. Pendiri diberikan kewenangan untuk mengurus komunitas dengan bantuan penuh dari Kaisar dan kemudian komunitas ini makin membesar dan terkenal di masyarakat umum. Beberapa tahun setelahnya, banyak relawan yang ikut meramaikan komunitas ini dan memberi bantuan yang sangat berarti untuk mencerdasakan kehidupan bangsa.
              </p>
          </div>
          <div class="border-2 border-gray-200 p-8 rounded-lg shadow-sm">
            <h3 class="font-bold text-2xl text-[#76B340] mb-4 text-center">VISI</h3>
            <p class="text-gray-700 leading-relaxed text-center">
              Visi yang diusung adalah menjadikan Terminal Pintar sebagai “teman perjalanan” bagi anak-anak untuk menemukan kembali arti rumah, pendidikan, dan harapan. Artinya, tempat ini tidak dimaksudkan menggantikan sekolah formal, melainkan melengkapi dengan nuansa yang lebih hangat, menyenangkan, dan relevan dengan kehidupan mereka.
              </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-[#76B340] mb-16">
          Pengurus
        </h2>
        <div class="flex flex-wrap justify-center gap-x-16 gap-y-10">
          <div class="flex flex-col items-center text-center w-48">
            <img src="/public/images/pengurus.jpg" alt="Nabila Nurshani" class="w-32 h-32 rounded-full object-cover mb-4 shadow-md">
            <h4 class="font-bold text-xl text-gray-800">Nabila Nurshani</h4>
            <p class="text-gray-600">Pengurus</p>
          </div>
          <div class="flex flex-col items-center text-center w-48">
            <img src="/public/images/pengurus.jpg" alt="Andi Rahmadi" class="w-32 h-32 rounded-full object-cover mb-4 shadow-md">
            <h4 class="font-bold text-xl text-gray-800">Andi Rahmadi</h4>
            <p class="text-gray-600">Pengurus</p>
          </div>
          <div class="flex flex-col items-center text-center w-48">
            <img src="/public/images/pengurus.jpg" alt="Hanifah Ahmad" class="w-32 h-32 rounded-full object-cover mb-4 shadow-md">
            <h4 class="font-bold text-xl text-gray-800">Hanifah Ahmad</h4>
            <p class="text-gray-600">Pengurus</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-20 bg-white">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-center text-[#76B340] mb-12">
      Mari Berkontribusi Membangun Harapan!
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
      
      <div class="bg-white border border-gray-200 rounded-lg p-8 text-center shadow-lg">
        
        <img src="/public/images/donasi.jpg" alt="Donasi" class="h-20 w-20 mx-auto mb-4 rounded-full">
        
        <h3 class="font-bold text-2xl text-[#76B340] mb-3">DONASI</h3>
        <p class="text-gray-600 mb-6">Mari ikut berdonasi untuk membantu mereka yang membutuhkan. Dukungan Anda sangat berarti..</p>
        <a 
          href="#"
          class="bg-[#76B340] text-white px-6 py-3 rounded-lg text-base font-semibold hover:bg-opacity-80 transition-opacity"
        >
          Lihat Cara Berdonasi
        </a>
      </div>
      
      <div class="bg-white border border-gray-200 rounded-lg p-8 text-center shadow-lg">
        
        <img src="/public/images/relawan.jpg" alt="Relawan" class="h-20 w-20 mx-auto mb-4 rounded-full">
        
        <h3 class="font-bold text-2xl text-[#EB9232] mb-3">RELAWAN</h3>
        <p class="text-gray-600 mb-6">Mari ikut menjadi relawan untuk membantu mereka yang membutuhkan. Bantuan Anda..</p>
        <a 
          href="#"
          class="bg-[#EB9232] text-white px-6 py-3 rounded-lg text-base font-semibold hover:bg-opacity-80 transition-opacity"
        >
          Lihat Cara Mendaftar
        </a>
      </div>

    </div>
  </div>
</section>

    <footer id="kontak" class="bg-[#76B340] text-white pt-16 pb-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:justify-center gap-8 md:gap-24 px-8">
        <div>
          <h4 class="font-bold text-xl mb-4">Kontak Kami</h4>
          <p class="mb-2">📞 +628123456789</p>
          <p class="mb-2">✉ terminalpintar@gmail.com</p>
        </div>
        
        <div>
          <h4 class="font-bold text-xl mb-4">Media Sosial</h4>
          <p class="mb-2">@terminalpintar_id</p>
          <p class="mb-2">@terminalpintar</p>
          <p class="mb-2">Terminal Pintar</p>
        </div>

      </div>
      
      <div class="mt-12 border-t border-green-700 pt-6 text-center text-sm text-green-200">
        <p>&copy; 2025 Terminal Pintar. All rights reserved.</p>
      </div>
    </footer>

  </div>
</template>