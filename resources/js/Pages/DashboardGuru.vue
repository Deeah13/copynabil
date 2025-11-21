<template>
  <div class="min-h-screen flex bg-[#f7f5f2]">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col">
      <div class="px-6 py-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
          <img class="h-10 w-10" src="/public/images/Logo.png" alt="Terminal Pintar logo">
          <div>
            <p class="text-sm text-gray-500">Terminal Pintar</p>
            <p class="text-lg font-semibold text-[#78AE4E]">Guru Panel</p>
          </div>
        </div>
      </div>

      <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
        <!-- Menu Utama -->
        <div>
          <button @click="toggleMenu('menuUtama')"
            class="w-full flex items-center justify-between text-left text-gray-600 hover:text-gray-900">
            <span class="flex items-center gap-3 font-semibold">
              <Bars3Icon class="w-5 h-5" />
              Menu Utama
            </span>
            <ChevronDownIcon :class="menus.menuUtama ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" />
          </button>

          <div v-if="menus.menuUtama" class="mt-4 space-y-2 pl-8">
            <button @click="activeSection = 'beranda'" :class="navClass('beranda')"
              class="flex items-center gap-2 w-full text-sm font-medium">
              <HomeIcon class="w-5 h-5" />
              Beranda
            </button>
          </div>
        </div>

        <!-- Manajemen Akademik -->
        <div>
          <button @click="toggleMenu('manajemen')"
            class="w-full flex items-center justify-between text-left text-gray-600 hover:text-gray-900">
            <span class="flex items-center gap-3 font-semibold">
              <AcademicCapIcon class="w-5 h-5" />
              Manajemen Akademik
            </span>
            <ChevronDownIcon :class="menus.manajemen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" />
          </button>

          <div v-if="menus.manajemen" class="mt-4 space-y-2 pl-8">
            <button @click="activeSection = 'jadwalMateri'" :class="navClass('jadwalMateri')"
              class="flex items-center gap-2 w-full text-sm font-medium">
              <CalendarDaysIcon class="w-5 h-5" />
              Jadwal & Materi
            </button>
            <button @click="activeSection = 'kehadiran'" :class="navClass('kehadiran')"
              class="flex items-center gap-2 w-full text-sm font-medium">
              <ClipboardDocumentCheckIcon class="w-5 h-5" />
              Kehadiran
            </button>
          </div>
        </div>
      </nav>

      <div class="px-6 py-5 border-t border-gray-100 text-xs text-gray-400">
        © {{ new Date().getFullYear() }} Terminal Pintar
      </div>
    </aside>

    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="px-10 py-6 bg-white border-b border-gray-200 flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">{{ headerSubtitle }}</p>
          <h1 class="text-3xl font-bold text-gray-900">Selamat Datang, Ibu Ica</h1>
          <p class="text-gray-500 mt-1">Kelola kegiatan belajar mengajar dan pantau performa siswa di Terminal Pintar</p>
        </div>

        <div class="flex items-center gap-4">
          <button class="px-4 py-2 border border-gray-200 rounded-full text-sm font-medium text-gray-600 hover:border-[#78AE4E]">
            Bahasa Indonesia
          </button>

          <!-- Notifications -->
          <div class="relative">
            <button @click="toggleNotif" class="p-2 rounded-full bg-gray-50 text-gray-600 hover:text-gray-900 notif-button">
              <BellIcon class="w-6 h-6" />
              <span v-if="unreadNotifications" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] px-1 rounded-full">
                {{ unreadNotifications }}
              </span>
            </button>

            <transition enter-active-class="transition duration-150" enter-from-class="opacity-0 translate-y-2"
              enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-100"
              leave-from-class="opacity-100" leave-to-class="opacity-0 translate-y-2">
              <div v-if="isNotifOpen" ref="notifMenu"
                class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-40">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                  <p class="font-semibold text-gray-900">Notifikasi</p>
                  <button class="text-sm text-[#78AE4E] font-medium" @click="markAllNotificationsRead">
                    Tandai semua telah dibaca
                  </button>
                </div>

                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                  <div v-for="notif in notifications" :key="notif.id" class="px-5 py-4 flex gap-3">
                    <span class="mt-1 w-2 h-2 rounded-full"
                      :class="notif.read ? 'bg-gray-300' : 'bg-green-500'"></span>
                    <div>
                      <p class="text-sm font-semibold text-gray-900">{{ notif.title }}</p>
                      <p class="text-sm text-gray-500">{{ notif.message }}</p>
                    </div>
                  </div>
                  <p v-if="!notifications.length" class="px-5 py-8 text-center text-gray-400 text-sm">Tidak ada notifikasi</p>
                </div>
              </div>
            </transition>
          </div>

          <!-- Profile -->
          <div class="relative">
            <button @click="toggleProfile"
              class="flex items-center gap-2 px-3 py-2 rounded-full border border-gray-200 profile-button">
              <UserCircleIcon class="w-8 h-8 text-gray-500" />
              <div class="text-left">
                <p class="text-sm font-semibold text-gray-900">Ica Bali Tri Susmita</p>
                <p class="text-xs text-gray-500">cabal@gmail.com</p>
              </div>
            </button>

            <transition enter-active-class="transition duration-150"
              enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition duration-100" leave-from-class="opacity-100"
              leave-to-class="opacity-0 translate-y-2">
              <div v-if="isProfileOpen" ref="profileMenu"
                class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 z-40">
                <div class="text-center mb-5">
                  <UserCircleIcon class="w-16 h-16 mx-auto text-gray-300" />
                  <p class="text-lg font-semibold text-gray-900">Ica Bali Tri Susmita</p>
                  <p class="text-sm text-gray-500">cabal@gmail.com</p>
                </div>
                <button @click="confirmLogout"
                  class="w-full py-2.5 rounded-xl border border-red-300 text-red-500 font-semibold hover:bg-red-50 transition">
                  Keluar
                </button>
              </div>
            </transition>
          </div>
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto px-10 py-8">
        <section v-if="activeSection === 'beranda'" class="space-y-8">
          <!-- Summary Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <article v-for="card in summaryCards" :key="card.id"
              class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
              <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">{{ card.subtitle }}</p>
              <p class="text-3xl font-bold text-gray-900 mt-2">{{ card.value }}</p>
              <p class="text-sm text-gray-500">{{ card.description }}</p>
              <div class="mt-4 flex items-center gap-2" :class="card.trendColor">
                <component :is="card.trendIcon" class="w-5 h-5" />
                <span class="text-sm font-semibold">{{ card.trendLabel }}</span>
              </div>
            </article>
          </div>

          <!-- Quick Actions -->
          <section class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
              <div>
                <p class="text-sm font-semibold text-[#78AE4E]">Aksi Cepat</p>
                <h2 class="text-xl font-bold text-gray-900">Kelola kegiatan mengajar dengan cepat</h2>
              </div>
              <button class="px-4 py-2 text-sm font-semibold text-white bg-[#78AE4E] rounded-full shadow">
                Tambah Aksi
              </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
              <article v-for="action in quickActions" :key="action.id"
                class="rounded-2xl border border-gray-100 p-4 hover:border-[#78AE4E] transition">
                <div :class="action.iconWrapper" class="w-10 h-10 rounded-full flex items-center justify-center mb-3">
                  <component :is="action.icon" class="w-5 h-5" />
                </div>
                <p class="font-semibold text-gray-900">{{ action.title }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ action.description }}</p>
              </article>
            </div>
          </section>

          <!-- Jadwal Pembelajaran -->
          <section class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div>
                <p class="text-sm font-semibold text-[#78AE4E]">Jadwal Pembelajaran</p>
                <h2 class="text-xl font-bold text-gray-900">Aktivitas minggu ini</h2>
              </div>
              <div class="flex gap-3">
                <button class="px-4 py-2 rounded-full border border-gray-200 text-sm font-semibold text-gray-600">
                  Minggu Ini
                </button>
                <button class="px-4 py-2 rounded-full bg-[#78AE4E] text-white text-sm font-semibold">
                  Buat Jadwal
                </button>
              </div>
            </div>

            <div class="space-y-4">
              <article v-for="lesson in teachingSchedules" :key="lesson.id"
                class="p-5 rounded-2xl border border-gray-100 bg-gradient-to-r from-white to-[#f7fdf3] flex flex-col gap-3">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                  <div>
                    <p class="text-sm text-gray-500">{{ lesson.dateLabel }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ lesson.subject }}</p>
                  </div>
                  <span class="px-4 py-1 rounded-full text-sm font-semibold"
                    :class="lesson.badgeColor">{{ lesson.status }}</span>
                </div>
                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                  <div class="flex items-center gap-1">
                    <ClockIcon class="w-4 h-4" />
                    {{ lesson.time }}
                  </div>
                  <div class="flex items-center gap-1">
                    <UserIcon class="w-4 h-4" />
                    {{ lesson.classroom }}
                  </div>
                  <div class="flex items-center gap-1">
                    <DocumentTextIcon class="w-4 h-4" />
                    {{ lesson.material }}
                  </div>
                </div>
              </article>
            </div>
          </section>
        </section>

        <!-- Jadwal & Materi -->
        <section v-if="activeSection === 'jadwalMateri'" class="space-y-6">
          <article class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <div>
                <p class="text-sm font-semibold text-[#78AE4E]">Unggah Jadwal dan Materi Pembelajaran</p>
                <h2 class="text-2xl font-bold text-gray-900">Lengkapi jadwal dan materi sesuai kelas Anda</h2>
              </div>
              <div class="flex items-center gap-3">
                <button class="px-4 py-2 border border-gray-200 rounded-full text-sm font-semibold text-gray-600">
                  Bahasa Indonesia
                </button>
                <button @click="openAddSchedule" class="px-5 py-2.5 bg-[#78AE4E] text-white rounded-full text-sm font-semibold shadow">
                  + Tambah Jadwal
                </button>
              </div>
            </div>

            <p class="mt-3 text-sm text-gray-500">Unggah jadwal kegiatan belajar mengajar dengan lengkap</p>

            <div v-if="successMessage" class="mt-4 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800 font-semibold">
              {{ successMessage }}
            </div>

            <div v-if="isLoadingJadwal" class="mt-6 space-y-4">
              <div v-for="n in 2" :key="n" class="animate-pulse rounded-2xl bg-gray-100 h-32"></div>
            </div>

            <div v-else class="mt-6 space-y-6">
              <article v-for="schedule in jadwalMateri" :key="schedule.id" class="rounded-3xl border border-gray-100 bg-[#fdfcf9] p-5 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                  <div class="flex-1 space-y-2">
                    <div class="flex items-center gap-3">
                      <p class="text-lg font-semibold text-gray-900">{{ formatFullDate(schedule.waktu_mulai) }}</p>
                      <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="badgeClass(schedule.status)">
                        {{ schedule.status }}
                      </span>
                    </div>
                    <p class="text-xl font-bold text-gray-900">{{ schedule.topik }}</p>
                    <p class="text-sm text-gray-600">Topik: {{ schedule.topik_pembelajaran || '-' }}</p>
                    <p class="text-sm text-gray-500">Deskripsi: {{ schedule.deskripsi || '-' }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-600 mt-3">
                      <div class="flex items-center gap-2">
                        <ClockIcon class="w-5 h-5 text-[#78AE4E]" />
                        <span>{{ formatTimeRange(schedule.waktu_mulai, schedule.waktu_selesai) }}</span>
                      </div>
                      <div class="flex items-center gap-2">
                        <MapPinIcon class="w-5 h-5 text-[#78AE4E]" />
                        <span>{{ schedule.lokasi || 'Lokasi belum diisi' }}</span>
                      </div>
                      <div class="flex items-center gap-2">
                        <UserGroupIcon class="w-5 h-5 text-[#78AE4E]" />
                        <span>{{ schedule.jumlah_peserta ? `${schedule.jumlah_peserta} Peserta` : 'Jumlah peserta belum diisi' }}</span>
                      </div>
                    </div>
                  </div>

                  <div class="flex flex-wrap gap-3 self-start">
                    <button @click="openEditSchedule(schedule)" class="px-4 py-2 rounded-full border border-gray-200 text-sm font-semibold text-gray-700 bg-white">
                      Edit Jadwal
                    </button>
                    <button @click="openEditMateri(schedule)" class="px-4 py-2 rounded-full border border-[#78AE4E]/60 text-sm font-semibold text-[#78AE4E] bg-[#f1f8e9]">
                      Edit Materi
                    </button>
                  </div>
                </div>

                <div class="mt-5 space-y-3">
                  <h3 class="font-semibold text-gray-900">Materi Pembelajaran ({{ schedule.materi.length }} File)</h3>
                  <div v-if="!schedule.materi.length" class="rounded-2xl border border-dashed border-gray-200 p-4 text-sm text-gray-500">
                    Belum ada materi diunggah.
                  </div>
                  <div v-else class="space-y-3">
                    <div v-for="file in schedule.materi" :key="file.id" class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white p-3">
                      <div class="p-2 rounded-xl bg-[#eaf6df] text-[#78AE4E]">
                        <DocumentArrowUpIcon class="w-5 h-5" />
                      </div>
                      <div class="flex-1">
                        <p class="font-semibold text-gray-900">{{ file.judul }}</p>
                        <p class="text-sm text-gray-600">{{ file.deskripsi || 'Deskripsi belum diisi' }}</p>
                        <div class="mt-2 h-2 rounded-full bg-gray-100">
                          <div class="h-2 rounded-full bg-[#78AE4E]" style="width: 100%"></div>
                        </div>
                      </div>
                      <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="badgeClass(file.status)">
                        {{ file.status }}
                      </span>
                      <a v-if="file.url" :href="file.url" target="_blank" class="text-xs font-semibold text-[#78AE4E]">Lihat</a>
                    </div>
                  </div>
                </div>
              </article>
            </div>
          </article>
        </section>

        <!-- Kehadiran -->
        <section v-if="activeSection === 'kehadiran'" class="space-y-8">
          <article class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div>
                <p class="text-sm font-semibold text-[#78AE4E]">Kehadiran Siswa</p>
                <h2 class="text-2xl font-bold text-gray-900">Ringkasan Bulan Ini</h2>
              </div>
              <div class="flex gap-4">
                <div class="text-center">
                  <p class="text-4xl font-bold text-gray-900">{{ attendanceSummary.present }}%</p>
                  <p class="text-sm text-gray-500">Hadir</p>
                </div>
                <div class="text-center">
                  <p class="text-4xl font-bold text-amber-500">{{ attendanceSummary.late }}%</p>
                  <p class="text-sm text-gray-500">Terlambat</p>
                </div>
                <div class="text-center">
                  <p class="text-4xl font-bold text-red-500">{{ attendanceSummary.absent }}%</p>
                  <p class="text-sm text-gray-500">Absen</p>
                </div>
              </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-100">
              <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                  <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Kelas</th>
                    <th class="px-6 py-3">Pertemuan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Catatan</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
                  <tr v-for="student in attendanceRecords" :key="student.id">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ student.name }}</td>
                    <td class="px-6 py-4">{{ student.class }}</td>
                    <td class="px-6 py-4">{{ student.session }}</td>
                    <td class="px-6 py-4">
                      <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="student.badge">
                        {{ student.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ student.note }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </article>
        </section>
      </main>
    </div>

    <!-- Modal Tambah Jadwal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl">
        <header class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div>
            <p class="text-sm text-[#78AE4E] font-semibold">Tambah Jadwal</p>
            <p class="text-xl font-bold text-gray-900">Isi data jadwal kegiatan belajar mengajar dengan lengkap</p>
          </div>
          <button @click="closeAddSchedule" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </header>

        <form @submit.prevent="submitAddSchedule" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-semibold text-gray-700">Mata Pelajaran</label>
              <input v-model="addForm.topik" required type="text" placeholder="Masukkan nama Mata Pelajaran - Kegiatan"
                class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Topik Pembelajaran</label>
              <input v-model="addForm.topik_pembelajaran" type="text" placeholder="Contoh: Topik Pembelajaran"
                class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Hari, Tanggal</label>
              <input v-model="addForm.tanggal" required type="date"
                class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-sm font-semibold text-gray-700">Jam Mulai</label>
                <input v-model="addForm.jam_mulai" required type="time"
                  class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
              </div>
              <div>
                <label class="text-sm font-semibold text-gray-700">Jam Selesai</label>
                <input v-model="addForm.jam_selesai" required type="time"
                  class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
              </div>
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Ruangan/Lokasi</label>
              <input v-model="addForm.lokasi" type="text" placeholder="Isikan lokasi kegiatan belajar mengajar"
                class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Jumlah Peserta Didik</label>
              <input v-model.number="addForm.jumlah_peserta" type="number" min="0"
                class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Status Jadwal</label>
              <select v-model="addForm.status" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
                <option value="Akan Datang">Akan Datang</option>
                <option value="Berlangsung">Berlangsung</option>
                <option value="Selesai">Selesai</option>
              </select>
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Status Materi</label>
              <input v-model="addForm.materi_status" type="text" placeholder="Contoh: Terunggah"
                class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat Materi</label>
            <textarea v-model="addForm.deskripsi" rows="3" placeholder="Tuliskan deskripsi materi yang diajarkan"
              class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]"></textarea>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold text-gray-700">Tambahkan Materi</label>
            <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-4 py-6 text-center cursor-pointer hover:border-[#78AE4E]" @click="materialInput && materialInput.click()">
              <p class="text-sm text-gray-600">Klik untuk upload atau drag and drop</p>
              <p class="text-xs text-gray-400">PNG, MP4, PPT, DOCX, PDF</p>
              <input ref="materialInput" type="file" class="hidden" multiple @change="handleMaterialFiles($event, addForm)" />
            </div>
            <div v-if="addForm.materi_uploads.length" class="space-y-2">
              <div v-for="file in addForm.materi_uploads" :key="file.name" class="flex items-center justify-between rounded-xl bg-white border border-gray-100 px-3 py-2 text-sm">
                <span class="text-gray-700">{{ file.name }}</span>
                <span class="text-xs text-gray-500">{{ (file.size / 1024 / 1024).toFixed(2) }} MB</span>
              </div>
            </div>
            <div v-if="uploadProgress > 0" class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-2 bg-[#78AE4E]" :style="{ width: `${uploadProgress}%` }"></div>
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-2">
            <button type="button" @click="closeAddSchedule" class="px-4 py-2 rounded-2xl border border-gray-200 text-gray-700 font-semibold">Batal</button>
            <button type="submit" class="px-5 py-2 rounded-2xl bg-[#78AE4E] text-white font-semibold shadow">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Edit Jadwal -->
    <div v-if="showEditScheduleModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl">
        <header class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div>
            <p class="text-sm text-[#78AE4E] font-semibold">Edit Jadwal</p>
            <p class="text-xl font-bold text-gray-900">Perbarui jadwal sesuai kebutuhan</p>
          </div>
          <button @click="closeEditSchedule" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </header>

        <form @submit.prevent="submitEditSchedule" class="p-6 space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-semibold text-gray-700">Mata Pelajaran</label>
              <input v-model="editForm.topik" required type="text" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Status Jadwal</label>
              <select v-model="editForm.status" required class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
                <option value="Akan Datang">Akan Datang</option>
                <option value="Berlangsung">Berlangsung</option>
                <option value="Selesai">Selesai</option>
              </select>
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Hari, Tanggal</label>
              <input v-model="editForm.tanggal" required type="date" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-sm font-semibold text-gray-700">Jam Mulai</label>
                <input v-model="editForm.jam_mulai" required type="time" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
              </div>
              <div>
                <label class="text-sm font-semibold text-gray-700">Jam Selesai</label>
                <input v-model="editForm.jam_selesai" required type="time" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
              </div>
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Ruangan/Lokasi</label>
              <input v-model="editForm.lokasi" type="text" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Jumlah Peserta Didik</label>
              <input v-model.number="editForm.jumlah_peserta" type="number" min="0" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
          </div>
          <div>
            <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat Materi</label>
            <textarea v-model="editForm.deskripsi" rows="3" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]"></textarea>
          </div>

          <div class="flex justify-end gap-3">
            <button type="button" @click="closeEditSchedule" class="px-4 py-2 rounded-2xl border border-gray-200 text-gray-700 font-semibold">Batal</button>
            <button type="submit" class="px-5 py-2 rounded-2xl bg-[#78AE4E] text-white font-semibold shadow">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Edit Materi -->
    <div v-if="showEditMateriModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl">
        <header class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div>
            <p class="text-sm text-[#78AE4E] font-semibold">Edit Materi</p>
            <p class="text-xl font-bold text-gray-900">Kelola materi yang sudah diunggah</p>
          </div>
          <button @click="closeEditMateri" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </header>

        <form @submit.prevent="submitEditMateri" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
          <div v-for="material in materiForm.existing" :key="material.id" class="rounded-2xl border border-gray-100 p-4 space-y-3">
            <div>
              <label class="text-sm font-semibold text-gray-700">Judul Materi</label>
              <input v-model="material.judul" required type="text" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat Materi</label>
              <textarea v-model="material.deskripsi" rows="2" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="text-sm font-semibold text-gray-700">Status Materi</label>
                <input v-model="material.status" required type="text" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
              </div>
              <div>
                <label class="text-sm font-semibold text-gray-700">Ganti File (opsional)</label>
                <input type="file" @change="onReplaceFile($event, material)" class="mt-1 w-full text-sm" />
              </div>
            </div>
          </div>

          <div class="space-y-3">
            <p class="text-sm font-semibold text-gray-700">Tambahkan Materi Baru</p>
            <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-4 py-6 text-center cursor-pointer hover:border-[#78AE4E]" @click="newMaterialInput && newMaterialInput.click()">
              <p class="text-sm text-gray-600">Klik untuk upload atau drag and drop</p>
              <p class="text-xs text-gray-400">PNG, MP4, PPT, DOCX, PDF</p>
              <input ref="newMaterialInput" type="file" class="hidden" multiple @change="handleMaterialFiles($event, materiForm)" />
            </div>
            <div v-if="materiForm.materi_uploads.length" class="space-y-2">
              <div v-for="file in materiForm.materi_uploads" :key="file.name" class="flex items-center justify-between rounded-xl bg-white border border-gray-100 px-3 py-2 text-sm">
                <span class="text-gray-700">{{ file.name }}</span>
                <span class="text-xs text-gray-500">{{ (file.size / 1024 / 1024).toFixed(2) }} MB</span>
              </div>
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Status Materi Baru</label>
              <input v-model="materiForm.materi_status" type="text" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]">
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Deskripsi Materi Baru</label>
              <textarea v-model="materiForm.materi_deskripsi" rows="2" class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]"></textarea>
            </div>
            <div v-if="materialUploadProgress > 0" class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
              <div class="h-2 bg-[#78AE4E]" :style="{ width: `${materialUploadProgress}%` }"></div>
            </div>
          </div>

          <div class="flex justify-end gap-3">
            <button type="button" @click="closeEditMateri" class="px-4 py-2 rounded-2xl border border-gray-200 text-gray-700 font-semibold">Batal</button>
            <button type="submit" class="px-5 py-2 rounded-2xl bg-[#78AE4E] text-white font-semibold shadow">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Logout Confirmation -->
    <div v-if="showLogoutModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
      <div class="bg-white rounded-3xl p-8 w-80 text-center shadow-2xl">
        <ExclamationCircleIcon class="w-16 h-16 text-red-500 mx-auto mb-4" />
        <p class="text-xl font-bold text-gray-900 mb-6">Yakin ingin keluar?</p>
        <div class="flex gap-4">
          <button @click="showLogoutModal = false"
            class="flex-1 py-2 rounded-xl border border-blue-200 text-blue-600 font-semibold">Tidak</button>
          <button @click="handleLogout"
            class="flex-1 py-2 rounded-xl bg-red-500 text-white font-semibold shadow-lg">Ya</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, reactive, ref, onMounted, onUnmounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import {
  AcademicCapIcon,
  Bars3Icon,
  BellIcon,
  CalendarDaysIcon,
  CheckCircleIcon,
  ChevronDownIcon,
  ClipboardDocumentCheckIcon,
  ClockIcon,
  DocumentArrowUpIcon,
  DocumentTextIcon,
  ExclamationCircleIcon,
  HomeIcon,
  MapPinIcon,
  UserCircleIcon,
  UserGroupIcon,
  UserIcon
} from '@heroicons/vue/24/outline';
import { ArrowDownCircleIcon, ArrowUpCircleIcon } from '@heroicons/vue/24/solid';

const router = useRouter();

const menus = reactive({
  menuUtama: true,
  manajemen: true,
});

const activeSection = ref('beranda');
const headerSubtitle = ref('Menu Utama · Beranda');

const summaryCards = [
  {
    id: 'students',
    subtitle: 'Total Siswa',
    value: '32 Siswa',
    description: '4 kelas aktif',
    trendLabel: '3 siswa butuh perhatian',
    trendColor: 'text-amber-500',
    trendIcon: ArrowDownCircleIcon,
  },
  {
    id: 'sessions',
    subtitle: 'Sesi Minggu Ini',
    value: '12 Sesi',
    description: '5 sesi selesai',
    trendLabel: '4 sesi tersisa',
    trendColor: 'text-[#78AE4E]',
    trendIcon: ArrowUpCircleIcon,
  },
  {
    id: 'grades',
    subtitle: 'Laporan Kelas',
    value: '150 Penilaian',
    description: 'Minggu ini',
    trendLabel: '95% sudah dinilai',
    trendColor: 'text-[#78AE4E]',
    trendIcon: CheckCircleIcon,
  },
  {
    id: 'materials',
    subtitle: 'Materi Terunggah',
    value: '28 Materi',
    description: '5 materi baru minggu ini',
    trendLabel: '2 menunggu review',
    trendColor: 'text-amber-500',
    trendIcon: ArrowDownCircleIcon,
  },
];

const quickActions = [
  {
    id: 'session',
    title: 'Buat Sesi Baru',
    description: 'Susun pertemuan dengan cepat',
    icon: CalendarDaysIcon,
    iconWrapper: 'bg-[#eaf6df] text-[#78AE4E]',
  },
  {
    id: 'material',
    title: 'Upload Materi',
    description: 'Bagikan bahan ajar terbaru',
    icon: DocumentArrowUpIcon,
    iconWrapper: 'bg-[#fcefdc] text-[#f08c2e]',
  },
  {
    id: 'report',
    title: 'Laporan Kehadiran',
    description: 'Pantau disiplin siswa',
    icon: ClipboardDocumentCheckIcon,
    iconWrapper: 'bg-[#eaf3ff] text-[#3b82f6]',
  },
  {
    id: 'history',
    title: 'Riwayat Penilaian',
    description: 'Lihat hasil terbaru',
    icon: DocumentTextIcon,
    iconWrapper: 'bg-[#fdecef] text-[#ef476f]',
  },
];

const teachingSchedules = [
  {
    id: 1,
    dateLabel: '17 Oktober 2025 · 08.00 - 09.40',
    subject: 'Matematika',
    status: 'Akan Datang',
    badgeColor: 'bg-[#eaf6df] text-[#78AE4E] font-semibold',
    time: '08.00 - 09.40',
    classroom: 'Kelas 10 IPA',
    material: 'Aljabar Lanjutan',
  },
  {
    id: 2,
    dateLabel: '17 Oktober 2025 · 10.00 - 11.40',
    subject: 'Fisika',
    status: 'Akan Datang',
    badgeColor: 'bg-[#eaf6df] text-[#78AE4E] font-semibold',
    time: '10.00 - 11.40',
    classroom: 'Kelas 12 IPA',
    material: 'Hukum Newton',
  },
  {
    id: 3,
    dateLabel: '17 Oktober 2025 · 13.00 - 14.40',
    subject: 'Matematika',
    status: 'Selesai',
    badgeColor: 'bg-gray-100 text-gray-600 font-semibold',
    time: '13.00 - 14.40',
    classroom: 'Kelas 11 IPA',
    material: 'Integral Dasar',
  },
];

const detailedSchedules = [
  {
    id: 1,
    day: 'Senin',
    subject: 'Matematika Terapan',
    time: '08.00 - 09.40',
    class: 'XI IPA 1',
    room: 'Ruang 203',
    material: 'Limit Fungsi',
  },
  {
    id: 2,
    day: 'Selasa',
    subject: 'Fisika Modern',
    time: '10.00 - 11.40',
    class: 'XII IPA 2',
    room: 'Lab Fisika',
    material: 'Dualisme Gelombang',
  },
  {
    id: 3,
    day: 'Rabu',
    subject: 'Matematika',
    time: '13.00 - 14.40',
    class: 'XI IPA 3',
    room: 'Ruang 205',
    material: 'Deret Tak Hingga',
  },
];

const latestMaterials = [
  {
    id: 1,
    title: 'Modul Latihan Limit',
    subject: 'Matematika',
    class: 'XI IPA',
    updatedAt: 'Diunggah 2 jam lalu',
    status: 'Sukses',
    badge: 'bg-green-100 text-green-700',
  },
  {
    id: 2,
    title: 'Video Eksperimen Newton',
    subject: 'Fisika',
    class: 'X IPA',
    updatedAt: 'Diunggah kemarin',
    status: 'Dalam Review',
    badge: 'bg-amber-100 text-amber-700',
  },
  {
    id: 3,
    title: 'Rangkuman Geometri',
    subject: 'Matematika',
    class: 'XII IPA',
    updatedAt: 'Diunggah 3 hari lalu',
    status: 'Sukses',
    badge: 'bg-green-100 text-green-700',
  },
];

const attendanceSummary = reactive({
  present: 92,
  late: 5,
  absent: 3,
});

const attendanceRecords = [
  { id: 1, name: 'Rafi Pratama', class: 'XI IPA 1', session: 'Matematika - Pertemuan 5', status: 'Hadir', badge: 'bg-green-100 text-green-700', note: 'Aktif bertanya' },
  { id: 2, name: 'Syifa Putri', class: 'XI IPA 1', session: 'Matematika - Pertemuan 5', status: 'Hadir', badge: 'bg-green-100 text-green-700', note: 'Catatan lengkap' },
  { id: 3, name: 'Hafidz Fadil', class: 'X IPA 2', session: 'Fisika - Pertemuan 4', status: 'Terlambat', badge: 'bg-amber-100 text-amber-700', note: 'Terlambat 10 menit' },
  { id: 4, name: 'Dini Safitri', class: 'XI IPA 3', session: 'Matematika - Pertemuan 4', status: 'Absen', badge: 'bg-red-100 text-red-600', note: 'Izin sakit' },
];

const notifications = ref([
  { id: 1, title: 'Materi yang berhasil diunggah', message: 'Minggu ini terdapat 5 materi yang berhasil diunggah', read: false },
  { id: 2, title: 'Laporan Penilaian Siswa', message: 'Sebanyak 1 siswa telah dinilai untuk pembelajaran minggu ini', read: false },
]);

const jadwalMateri = ref([]);
const isLoadingJadwal = ref(true);
const successMessage = ref('');
const uploadProgress = ref(0);
const materialUploadProgress = ref(0);

const showAddModal = ref(false);
const showEditScheduleModal = ref(false);
const showEditMateriModal = ref(false);
const materialInput = ref(null);
const newMaterialInput = ref(null);

const addForm = reactive({
  topik: '',
  topik_pembelajaran: '',
  tanggal: '',
  jam_mulai: '',
  jam_selesai: '',
  lokasi: '',
  jumlah_peserta: '',
  status: 'Akan Datang',
  materi_status: 'Terunggah',
  deskripsi: '',
  materi_uploads: [],
});

const editForm = reactive({
  id: null,
  topik: '',
  tanggal: '',
  jam_mulai: '',
  jam_selesai: '',
  lokasi: '',
  jumlah_peserta: '',
  status: 'Akan Datang',
  deskripsi: '',
});

const materiForm = reactive({
  scheduleId: null,
  existing: [],
  materi_uploads: [],
  materi_status: 'Terunggah',
  materi_deskripsi: '',
});

const isNotifOpen = ref(false);
const notifMenu = ref(null);
const isProfileOpen = ref(false);
const profileMenu = ref(null);
const showLogoutModal = ref(false);

const unreadNotifications = computed(() => notifications.value.filter((notif) => !notif.read).length);

const toggleMenu = (menuKey) => {
  menus[menuKey] = !menus[menuKey];
};

const navClass = (section) => [
  'px-3 py-2 rounded-xl transition text-left',
  activeSection.value === section
    ? 'bg-[#f0f9eb] text-[#78AE4E] font-semibold'
    : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50',
];

watch(activeSection, (value) => {
  const labelMap = {
    beranda: 'Menu Utama · Beranda',
    jadwalMateri: 'Manajemen Akademik · Jadwal & Materi',
    kehadiran: 'Manajemen Akademik · Kehadiran',
  };
  headerSubtitle.value = labelMap[value] || 'Terminal Pintar';
});

const toggleNotif = () => {
  isNotifOpen.value = !isNotifOpen.value;
  if (isNotifOpen.value) {
    isProfileOpen.value = false;
  }
};

const toggleProfile = () => {
  isProfileOpen.value = !isProfileOpen.value;
  if (isProfileOpen.value) {
    isNotifOpen.value = false;
  }
};

const handleClickOutside = (event) => {
  if (isNotifOpen.value && notifMenu.value && !notifMenu.value.contains(event.target) && !event.target.closest('.notif-button')) {
    isNotifOpen.value = false;
  }
  if (isProfileOpen.value && profileMenu.value && !profileMenu.value.contains(event.target) && !event.target.closest('.profile-button')) {
    isProfileOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  loadJadwalMateri();
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

const markAllNotificationsRead = () => {
  notifications.value = notifications.value.map((notif) => ({ ...notif, read: true }));
};

const confirmLogout = () => {
  isProfileOpen.value = false;
  showLogoutModal.value = true;
};

const handleLogout = async () => {
  try {
    await axios.post('/api/logout');
  } catch (error) {
    console.error('Logout error:', error);
  } finally {
    localStorage.removeItem('token');
    delete axios.defaults.headers.common['Authorization'];
    router.push('/login');
  }
};

const loadJadwalMateri = async () => {
  isLoadingJadwal.value = true;
  try {
    const { data } = await axios.get('/api/guru/jadwal-materi');
    jadwalMateri.value = data.data || [];
  } catch (error) {
    console.error('Gagal memuat jadwal guru:', error);
  } finally {
    isLoadingJadwal.value = false;
  }
};

const resetAddForm = () => {
  addForm.topik = '';
  addForm.topik_pembelajaran = '';
  addForm.tanggal = '';
  addForm.jam_mulai = '';
  addForm.jam_selesai = '';
  addForm.lokasi = '';
  addForm.jumlah_peserta = '';
  addForm.status = 'Akan Datang';
  addForm.materi_status = 'Terunggah';
  addForm.deskripsi = '';
  addForm.materi_uploads = [];
  uploadProgress.value = 0;
};

const openAddSchedule = () => {
  resetAddForm();
  showAddModal.value = true;
};

const closeAddSchedule = () => {
  showAddModal.value = false;
};

const handleMaterialFiles = (event, targetForm) => {
  const files = Array.from(event.target.files || []);
  targetForm.materi_uploads = [...(targetForm.materi_uploads || []), ...files];
};

const setSuccess = (message) => {
  successMessage.value = message;
  setTimeout(() => {
    successMessage.value = '';
  }, 4000);
};

const submitAddSchedule = async () => {
  const formData = new FormData();
  formData.append('topik', addForm.topik);
  formData.append('tanggal', addForm.tanggal);
  formData.append('waktu_mulai', addForm.jam_mulai);
  formData.append('waktu_selesai', addForm.jam_selesai);
  formData.append('lokasi', addForm.lokasi);
  formData.append('status', addForm.status);
  formData.append('topik_pembelajaran', addForm.topik_pembelajaran);
  formData.append('deskripsi', addForm.deskripsi);
  formData.append('jumlah_peserta', addForm.jumlah_peserta);
  formData.append('materi_status', addForm.materi_status);
  addForm.materi_uploads.forEach((file, index) => {
    formData.append(`materi_uploads[${index}]`, file);
    formData.append(`materi_titles[${index}]`, file.name);
  });

  try {
    await axios.post('/api/guru/jadwal', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
      onUploadProgress: (progressEvent) => {
        uploadProgress.value = Math.round((progressEvent.loaded * 100) / (progressEvent.total || 1));
      },
    });
    showAddModal.value = false;
    setSuccess('Jadwal dan materi berhasil ditambahkan.');
    await loadJadwalMateri();
  } catch (error) {
    console.error('Gagal menambahkan jadwal:', error);
  } finally {
    uploadProgress.value = 0;
  }
};

const formatFullDate = (value) => {
  if (!value) return '-';
  return new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }).format(new Date(value));
};

const formatTime = (value) => {
  if (!value) return '';
  const date = new Date(value);
  return `${String(date.getHours()).padStart(2, '0')}.${String(date.getMinutes()).padStart(2, '0')}`;
};

const formatTimeRange = (start, end) => {
  const startTime = formatTime(start);
  const endTime = formatTime(end);
  return startTime && endTime ? `${startTime} - ${endTime}` : '-';
};

const badgeClass = (status) => {
  if (status === 'Akan Datang') return 'bg-[#eaf6df] text-[#78AE4E] font-semibold';
  if (status === 'Berlangsung') return 'bg-amber-100 text-amber-700 font-semibold';
  return 'bg-gray-100 text-gray-700 font-semibold';
};

const openEditSchedule = (schedule) => {
  editForm.id = schedule.id;
  editForm.topik = schedule.topik;
  editForm.tanggal = schedule.waktu_mulai ? new Date(schedule.waktu_mulai).toISOString().slice(0, 10) : '';
  const start = formatTime(schedule.waktu_mulai);
  const end = formatTime(schedule.waktu_selesai);
  editForm.jam_mulai = start ? start.replace('.', ':') : '';
  editForm.jam_selesai = end ? end.replace('.', ':') : '';
  editForm.lokasi = schedule.lokasi;
  editForm.jumlah_peserta = schedule.jumlah_peserta;
  editForm.status = schedule.status;
  editForm.deskripsi = schedule.deskripsi;
  showEditScheduleModal.value = true;
};

const closeEditSchedule = () => {
  showEditScheduleModal.value = false;
};

const submitEditSchedule = async () => {
  try {
    await axios.put(`/api/guru/jadwal/${editForm.id}`, {
      topik: editForm.topik,
      tanggal: editForm.tanggal,
      waktu_mulai: editForm.jam_mulai,
      waktu_selesai: editForm.jam_selesai,
      lokasi: editForm.lokasi,
      jumlah_peserta: editForm.jumlah_peserta,
      status: editForm.status,
      deskripsi: editForm.deskripsi,
    });
    showEditScheduleModal.value = false;
    setSuccess('Jadwal berhasil diperbarui.');
    await loadJadwalMateri();
  } catch (error) {
    console.error('Gagal memperbarui jadwal:', error);
  }
};

const openEditMateri = (schedule) => {
  materiForm.scheduleId = schedule.id;
  materiForm.existing = schedule.materi.map((item) => ({ ...item, newFile: null }));
  materiForm.materi_uploads = [];
  materiForm.materi_status = 'Terunggah';
  materiForm.materi_deskripsi = '';
  materialUploadProgress.value = 0;
  showEditMateriModal.value = true;
};

const closeEditMateri = () => {
  showEditMateriModal.value = false;
};

const onReplaceFile = (event, material) => {
  const file = event.target.files?.[0];
  if (file) {
    material.newFile = file;
  }
};

const submitEditMateri = async () => {
  try {
    for (const material of materiForm.existing) {
      const formData = new FormData();
      formData.append('judul', material.judul);
      formData.append('deskripsi', material.deskripsi || '');
      formData.append('status', material.status);
      if (material.newFile) {
        formData.append('file', material.newFile);
      }
      await axios.post(`/api/guru/materi/${material.id}?_method=PUT`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
    }

    if (materiForm.materi_uploads.length) {
      const formData = new FormData();
      materiForm.materi_uploads.forEach((file, index) => {
        formData.append(`materi_uploads[${index}]`, file);
        formData.append(`materi_titles[${index}]`, file.name);
      });
      formData.append('materi_status', materiForm.materi_status);
      formData.append('materi_deskripsi', materiForm.materi_deskripsi);

      await axios.post(`/api/guru/jadwal/${materiForm.scheduleId}/materi`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
        onUploadProgress: (progressEvent) => {
          materialUploadProgress.value = Math.round((progressEvent.loaded * 100) / (progressEvent.total || 1));
        },
      });
    }

    showEditMateriModal.value = false;
    setSuccess('Materi berhasil diperbarui.');
    await loadJadwalMateri();
  } catch (error) {
    console.error('Gagal memperbarui materi:', error);
  } finally {
    materialUploadProgress.value = 0;
  }
};
</script>
