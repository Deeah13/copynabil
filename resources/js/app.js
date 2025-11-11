/**
 * Pertama, kita impor file-file yang diperlukan
 */
import './bootstrap'; // Ini file 'bootstrap.js' bawaan Laravel, bukan CSS

// Impor fungsi 'createApp' dari Vue
import { createApp } from 'vue';

// Impor router Anda (yang akan menentukan halaman mana yang dimuat)
import router from './router'; 

// Impor komponen "cangkang" utama aplikasi Anda (jika ada)
// Seringkali ini hanya berisi <router-view>
import App from './components/App.vue'; 

/**
 * Selanjutnya, kita buat aplikasi Vue
 */
const app = createApp(App); // Buat aplikasi dengan komponen App sebagai dasarnya

app.use(router); // Beritahu aplikasi untuk menggunakan router

/**
 * Terakhir, kita "pasang" (mount) aplikasi Vue ke dalam file HTML.
 * Ini memberitahu Vue untuk mengambil alih semua yang ada di dalam
 * elemen <div id="app"> di file welcome.blade.php Anda.
 */
app.mount('#app');