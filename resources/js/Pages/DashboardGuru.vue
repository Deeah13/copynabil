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
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
              <button type="button" v-for="action in quickActions" :key="action.id"
                @click="handleQuickAction(action.id)"
                class="text-left rounded-2xl border border-gray-100 p-4 hover:border-[#78AE4E] hover:shadow transition bg-white">
                <div :class="action.iconWrapper" class="w-10 h-10 rounded-full flex items-center justify-center mb-3">
                  <component :is="action.icon" class="w-5 h-5" />
                </div>
                <p class="font-semibold text-gray-900">{{ action.title }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ action.description }}</p>
              </button>
            </div>
          </section>

          <!-- Jadwal Pembelajaran -->
          <section class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div>
                <p class="text-sm font-semibold text-[#78AE4E]">Jadwal Pembelajaran</p>
                <h2 class="text-xl font-bold text-gray-900">Aktivitas minggu ini</h2>
              </div>
            </div>

            <div class="space-y-4">
              <article v-for="lesson in teachingSchedules" :key="lesson.id" @click="openScheduleDetail(lesson)"
                class="cursor-pointer p-5 rounded-2xl border border-gray-100 bg-gradient-to-r from-white to-[#f7fdf3] flex flex-col gap-3 hover:shadow">
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
              <p v-if="!teachingSchedules.length" class="text-center text-gray-400 text-sm py-4">Belum ada aktivitas di minggu ini</p>
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
            <div v-if="errorMessage" class="mt-4 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 font-semibold">
              {{ errorMessage }}
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
                    <button type="button" v-for="file in schedule.materi" :key="file.id" @click="openMaterialPreview(file)" class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white p-3 w-full text-left">
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
                      <span v-if="file.url" class="text-xs font-semibold text-[#78AE4E]">Lihat</span>
                    </button>
                  </div>
                </div>
              </article>
            </div>
          </article>
        </section>

        <!-- Kehadiran -->
        <section v-if="activeSection === 'kehadiran'" class="space-y-6">
          <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
              <p class="text-sm font-semibold text-[#78AE4E]">Kehadiran</p>
              <h2 class="text-2xl font-bold text-gray-900">Rekapitulasi Kehadiran</h2>
              <p class="text-sm text-gray-500">Pantau kehadiran siswa dan tambahkan catatan perkembangan</p>
            </div>
            <button class="px-4 py-2 border border-gray-200 rounded-full text-sm font-semibold text-gray-600">
              Bahasa Indonesia
            </button>
          </header>

          <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
            <article v-for="card in attendanceSummaryCards" :key="card.id"
              class="rounded-3xl border border-gray-100 bg-white shadow-sm p-4 flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">{{ card.label }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ card.value }}</p>
                <p class="text-xs text-gray-400">{{ card.subtitle }}</p>
              </div>
              <span :class="card.badge" class="px-3 py-1 rounded-full text-sm font-semibold">{{ card.label }}</span>
            </article>
          </div>

          <article class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
              <div>
                <p class="text-sm font-semibold text-[#78AE4E]">Detail Kehadiran</p>
                <h3 class="text-xl font-bold text-gray-900">Akses detail catatan kehadiran</h3>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full px-3 py-2">
                  <MagnifyingGlassIcon class="w-5 h-5 text-gray-400" />
                  <input v-model="attendanceFilters.query" type="text" placeholder="Cari nama siswa"
                    class="bg-transparent focus:outline-none text-sm text-gray-700" />
                </div>
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full px-3 py-2">
                  <FunnelIcon class="w-5 h-5 text-gray-400" />
                  <select v-model="attendanceFilters.status" class="bg-transparent focus:outline-none text-sm text-gray-700">
                    <option v-for="option in attendanceStatusOptions" :key="option" :value="option">{{ option }}</option>
                  </select>
                </div>
              </div>
            </div>

            <div v-if="successMessage" class="mb-4 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800 font-semibold">
              {{ successMessage }}
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-100">
              <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                  <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Siswa</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Catatan Perkembangan Siswa</th>
                    <th class="px-6 py-3">Aksi</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
                  <tr v-for="(student, index) in paginatedAttendance" :key="student.id">
                    <td class="px-6 py-4">{{ attendanceStartIndex + index }}</td>
                    <td class="px-6 py-4">
                      <p class="font-semibold text-gray-900">{{ student.name }}</p>
                      <p class="text-xs text-gray-500">{{ student.session }}</p>
                    </td>
                    <td class="px-6 py-4">
                      <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="statusBadgeClass(student.status)">
                        {{ student.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <button @click="openNoteModal(student)"
                        class="px-4 py-2 rounded-full border border-gray-200 text-sm font-semibold text-gray-700 hover:border-[#78AE4E] hover:text-[#78AE4E] flex items-center gap-2">
                        <DocumentTextIcon class="w-5 h-5" />
                        Catatan Perkembangan Siswa
                      </button>
                      <p v-if="student.note" class="mt-2 text-xs text-gray-500">{{ student.note }}</p>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                      <button @click="handleEditAttendance(student)" class="text-[#78AE4E] hover:text-green-700" title="Edit">
                        <PencilSquareIcon class="w-5 h-5" />
                      </button>
                      <button @click="removeAttendance(student.id)" class="text-red-500 hover:text-red-600" title="Hapus">
                        <TrashIcon class="w-5 h-5" />
                      </button>
                    </td>
                  </tr>
                  <tr v-if="!paginatedAttendance.length">
                    <td colspan="5" class="px-6 py-6 text-center text-gray-400">Tidak ada data kehadiran</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4 text-sm text-gray-500">
              <p>{{ attendanceRangeLabel }}</p>
              <div class="flex items-center gap-2 text-xs">
                <span class="w-3 h-3 rounded-full bg-[#eaf6df]"></span>
                <span>Hadir</span>
                <span class="w-3 h-3 rounded-full bg-blue-100 ml-4"></span>
                <span>Izin</span>
                <span class="w-3 h-3 rounded-full bg-amber-100 ml-4"></span>
                <span>Sakit</span>
                <span class="w-3 h-3 rounded-full bg-red-100 ml-4"></span>
                <span>Alpha</span>
              </div>
            </div>
          </article>
        </section>
      </main>
    </div>

    <!-- Detail Aktivitas Minggu Ini -->
    <div v-if="selectedSchedule" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden">
        <header class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-[#f7f5f2]">
          <div>
            <p class="text-sm text-[#78AE4E] font-semibold">Detail Jadwal</p>
            <p class="text-lg font-bold text-gray-900">{{ selectedSchedule.subject }}</p>
          </div>
          <button @click="closeScheduleDetail" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </header>

        <div class="p-6 space-y-3 text-sm text-gray-700">
          <div class="flex items-center justify-between">
            <span class="text-gray-500">Tanggal</span>
            <span class="font-semibold text-gray-900">{{ selectedSchedule.dateLabel }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-gray-500">Waktu</span>
            <span class="font-semibold text-gray-900">{{ selectedSchedule.time }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-gray-500">Kelas</span>
            <span class="font-semibold text-gray-900">{{ selectedSchedule.classroom }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-gray-500">Status</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="selectedSchedule.badgeColor">{{ selectedSchedule.status }}</span>
          </div>
          <div class="pt-3 border-t border-gray-100">
            <p class="text-gray-500 mb-1">Materi</p>
            <p class="font-semibold text-gray-900">{{ selectedSchedule.material }}</p>
          </div>
        </div>

        <footer class="px-6 py-4 border-t border-gray-100 bg-[#f7f5f2] flex items-center justify-end gap-3">
          <button @click="closeScheduleDetail" class="px-5 py-2 rounded-full border border-gray-200 text-sm font-semibold text-gray-600">Tutup</button>
          <button @click="handleQuickAction('session')" class="px-6 py-2 rounded-full bg-[#78AE4E] text-white font-semibold shadow">Kelola Jadwal</button>
        </footer>
      </div>
    </div>

    <!-- Modal Catatan Perkembangan Siswa -->
    <div v-if="showNoteModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden">
        <header class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-[#f7f5f2]">
          <p class="text-lg font-bold text-gray-900">Catatan Perkembangan Siswa</p>
          <button @click="closeNoteModal" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </header>

        <div class="p-6 space-y-4">
          <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
            <p class="text-sm text-gray-500">Nama Siswa</p>
            <p class="text-lg font-semibold text-gray-900">{{ activeNoteStudent?.name }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ activeNoteStudent?.session }}</p>
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat Perkembangan Siswa</label>
            <textarea v-model="noteForm.description" rows="4"
              class="mt-2 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]"
              placeholder="Tuliskan deskripsi singkat perkembangan siswa.."></textarea>
          </div>
        </div>

        <footer class="px-6 py-4 border-t border-gray-100 bg-[#f7f5f2] flex items-center justify-end gap-3">
          <button @click="closeNoteModal" class="px-5 py-2 rounded-full border border-gray-200 text-sm font-semibold text-gray-600">
            Batal
          </button>
          <button @click="saveNote" class="px-6 py-2 rounded-full bg-[#78AE4E] text-white font-semibold shadow">
            Simpan
          </button>
        </footer>
      </div>
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
                <p v-if="addTimeError" class="mt-2 text-xs text-red-600 font-semibold">{{ addTimeError }}</p>
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
            </div>

          <div>
            <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat Materi</label>
            <textarea v-model="addForm.deskripsi" rows="3" placeholder="Tuliskan deskripsi materi yang diajarkan"
              class="mt-1 w-full rounded-2xl border border-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#78AE4E]"></textarea>
          </div>

          <div class="space-y-2">
            <label class="text-sm font-semibold text-gray-700">Tambahkan Materi</label>
            <p class="text-xs text-gray-500">Status materi akan otomatis menjadi "Terunggah" ketika proses berhasil.</p>
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
            <div class="mt-1 flex items-center gap-2 text-sm text-gray-600">
              <span>Status saat ini:</span>
              <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="badgeClass(editForm.status)">{{ editForm.status || 'Akan Datang' }}</span>
            </div>
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
                <p v-if="editTimeError" class="mt-2 text-xs text-red-600 font-semibold">{{ editTimeError }}</p>
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
                <div class="flex items-center gap-2 text-sm text-gray-600">
                  <span class="text-xs px-3 py-1 rounded-full bg-[#eaf6df] text-[#78AE4E] font-semibold">Status: {{ material.status || 'Terunggah' }}</span>
                  <span class="text-xs text-gray-500">Otomatis diperbarui setelah upload berhasil</span>
                </div>
                <div>
                  <label class="text-sm font-semibold text-gray-700">Ganti File (opsional)</label>
                  <input type="file" @change="onReplaceFile($event, material)" class="mt-1 w-full text-sm" />
                </div>
              </div>
          </div>

            <div class="space-y-3">
              <p class="text-sm font-semibold text-gray-700">Tambahkan Materi Baru</p>
              <p class="text-xs text-gray-500">Status materi baru akan otomatis menjadi "Terunggah" ketika upload sukses.</p>
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

    <div v-if="showMaterialPreview" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden">
        <header class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div>
            <p class="text-sm text-[#78AE4E] font-semibold">Pratinjau Materi</p>
            <p class="text-xl font-bold text-gray-900">{{ selectedMaterialFile?.judul }}</p>
            <p class="text-sm text-gray-600">{{ selectedMaterialFile?.deskripsi || 'Deskripsi belum diisi' }}</p>
          </div>
          <button @click="closeMaterialPreview" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
        </header>
        <div class="p-6 space-y-4">
          <div class="flex items-center gap-3 text-sm text-gray-600">
            <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="badgeClass(selectedMaterialFile?.status || 'Terunggah')">
              {{ selectedMaterialFile?.status || 'Terunggah' }}
            </span>
            <a v-if="selectedMaterialFile?.url" :href="selectedMaterialFile.url" target="_blank" class="text-[#78AE4E] font-semibold">Buka di tab baru</a>
          </div>
          <div v-if="selectedMaterialFile?.url" class="border border-gray-100 rounded-2xl overflow-hidden h-[480px]">
            <iframe :src="selectedMaterialFile.url" class="w-full h-full" />
          </div>
          <p v-else class="text-sm text-gray-500">File tidak tersedia.</p>
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
  FunnelIcon,
  DocumentArrowUpIcon,
  DocumentTextIcon,
  ExclamationCircleIcon,
  HomeIcon,
  MagnifyingGlassIcon,
  MapPinIcon,
  UserCircleIcon,
  UserGroupIcon,
  UserIcon,
  PencilSquareIcon,
  TrashIcon
} from '@heroicons/vue/24/outline';
import { ArrowDownCircleIcon, ArrowUpCircleIcon } from '@heroicons/vue/24/solid';

const router = useRouter();

const menus = reactive({
  menuUtama: true,
  manajemen: true,
});

const activeSection = ref('beranda');
const headerSubtitle = ref('Menu Utama · Beranda');

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

const attendanceStatusOptions = ['Semua', 'Hadir', 'Izin', 'Sakit', 'Alpha'];

const attendanceRecords = ref([
  { id: 1, name: 'Hanif Juansyah', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Hadir', note: 'Aktif dan fokus' },
  { id: 2, name: 'Fathiya Salsabila', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Izin', note: 'Izin karena tugas lomba' },
  { id: 3, name: 'Muhammad Umar', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Hadir', note: 'Menyelesaikan tugas tepat waktu' },
  { id: 4, name: 'Yayi Tisay', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Sakit', note: 'Sakit, beristirahat di UKS' },
  { id: 5, name: 'Cakim Mahendra', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Hadir', note: 'Siswa menunjukkan peningkatan' },
  { id: 6, name: 'Zovey Zahra', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Alpha', note: 'Belum memberikan kabar' },
  { id: 7, name: 'Sally', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Hadir', note: 'Responsif saat diskusi' },
  { id: 8, name: 'Dufi Nugraheni', session: 'Bahasa Indonesia - Pertemuan 3', status: 'Hadir', note: 'Suka membantu teman' },
]);

const attendanceFilters = reactive({
  query: '',
  status: 'Semua',
});

const attendancePagination = reactive({
  page: 1,
  perPage: 8,
});

const showNoteModal = ref(false);
const activeNoteStudent = ref(null);
const noteForm = reactive({
  description: '',
});

const attendanceSummaryCards = computed(() => {
  const totals = attendanceRecords.value.reduce((acc, record) => {
    acc[record.status] = (acc[record.status] || 0) + 1;
    return acc;
  }, {});

  const baseCards = [
    { id: 'hadir', label: 'Hadir', badge: 'bg-[#eaf6df] text-[#78AE4E]' },
    { id: 'izin', label: 'Izin', badge: 'bg-blue-100 text-blue-700' },
    { id: 'sakit', label: 'Sakit', badge: 'bg-amber-100 text-amber-700' },
    { id: 'alpha', label: 'Alpha', badge: 'bg-red-100 text-red-600' },
  ];

  return baseCards.map((card) => ({
    ...card,
    value: `${totals[card.label] || 0} Siswa`,
    subtitle: 'Rekap hari ini',
    badge: `${card.badge} font-semibold`,
  }));
});

const filteredAttendanceRecords = computed(() => {
  const query = attendanceFilters.query.toLowerCase();
  return attendanceRecords.value.filter((record) => {
    const matchesQuery = record.name.toLowerCase().includes(query) || record.session.toLowerCase().includes(query);
    const matchesStatus = attendanceFilters.status === 'Semua' || record.status === attendanceFilters.status;
    return matchesQuery && matchesStatus;
  });
});

const attendanceStartIndex = computed(() => {
  if (!filteredAttendanceRecords.value.length) return 0;
  return (attendancePagination.page - 1) * attendancePagination.perPage + 1;
});

const paginatedAttendance = computed(() => {
  const start = (attendancePagination.page - 1) * attendancePagination.perPage;
  const end = start + attendancePagination.perPage;
  return filteredAttendanceRecords.value.slice(start, end);
});

const attendanceRangeLabel = computed(() => {
  const total = filteredAttendanceRecords.value.length;
  if (!total) return 'Menampilkan 0 dari 0 siswa';
  const start = attendanceStartIndex.value;
  const end = Math.min(start + attendancePagination.perPage - 1, total);
  return `Menampilkan ${start}-${end} dari ${total} siswa`;
});

const statusBadgeClass = (status) => {
  if (status === 'Hadir') return 'bg-[#eaf6df] text-[#78AE4E]';
  if (status === 'Izin') return 'bg-blue-100 text-blue-700';
  if (status === 'Sakit') return 'bg-amber-100 text-amber-700';
  return 'bg-red-100 text-red-600';
};

const openNoteModal = (student) => {
  activeNoteStudent.value = student;
  noteForm.description = student.note || '';
  showNoteModal.value = true;
};

const closeNoteModal = () => {
  showNoteModal.value = false;
  noteForm.description = '';
  activeNoteStudent.value = null;
};

const saveNote = () => {
  if (activeNoteStudent.value) {
    activeNoteStudent.value.note = noteForm.description;
    setSuccess('Catatan perkembangan siswa berhasil disimpan.');
  }
  closeNoteModal();
};

const handleEditAttendance = (student) => {
  openNoteModal(student);
};

const removeAttendance = (studentId) => {
  attendanceRecords.value = attendanceRecords.value.filter((record) => record.id !== studentId);
  attendancePagination.page = 1;
  setSuccess('Data kehadiran berhasil dihapus.');
};

const notifications = ref([
  { id: 1, title: 'Materi yang berhasil diunggah', message: 'Minggu ini terdapat 5 materi yang berhasil diunggah', read: false },
  { id: 2, title: 'Laporan Penilaian Siswa', message: 'Sebanyak 1 siswa telah dinilai untuk pembelajaran minggu ini', read: false },
]);

const jadwalMateri = ref([]);
const isLoadingJadwal = ref(true);
const successMessage = ref('');
const errorMessage = ref('');
const uploadProgress = ref(0);
const materialUploadProgress = ref(0);
const addTimeError = ref('');
const editTimeError = ref('');

const showAddModal = ref(false);
const showEditScheduleModal = ref(false);
const showEditMateriModal = ref(false);
const showMaterialPreview = ref(false);
const materialInput = ref(null);
const newMaterialInput = ref(null);
const selectedSchedule = ref(null);
const selectedMaterialFile = ref(null);

const addForm = reactive({
  topik: '',
  topik_pembelajaran: '',
  tanggal: '',
  jam_mulai: '',
  jam_selesai: '',
  lokasi: '',
  jumlah_peserta: '',
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

const handleQuickAction = (actionId) => {
  if (actionId === 'session' || actionId === 'material') {
    activeSection.value = 'jadwalMateri';
    closeScheduleDetail();
    return;
  }

  if (actionId === 'report' || actionId === 'history') {
    activeSection.value = 'kehadiran';
  }
};

const openScheduleDetail = (schedule) => {
  selectedSchedule.value = schedule;
};

const closeScheduleDetail = () => {
  selectedSchedule.value = null;
};

watch(activeSection, (value) => {
  const labelMap = {
    beranda: 'Menu Utama · Beranda',
    jadwalMateri: 'Manajemen Akademik · Jadwal & Materi',
    kehadiran: 'Manajemen Akademik · Kehadiran',
  };
  headerSubtitle.value = labelMap[value] || 'Terminal Pintar';
});

watch(
  () => [attendanceFilters.query, attendanceFilters.status],
  () => {
    attendancePagination.page = 1;
  }
);

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
  addForm.deskripsi = '';
  addForm.materi_uploads = [];
  uploadProgress.value = 0;
  errorMessage.value = '';
  addTimeError.value = '';
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

const setError = (message) => {
  errorMessage.value = message;
  setTimeout(() => {
    errorMessage.value = '';
  }, 4000);
};

const setSuccess = (message) => {
  errorMessage.value = '';
  successMessage.value = message;
  setTimeout(() => {
    successMessage.value = '';
  }, 4000);
};

const isValidTimeRange = (start, end) => {
  if (!start || !end) return true;
  const [startHour, startMinute] = start.split(':').map(Number);
  const [endHour, endMinute] = end.split(':').map(Number);
  const startTotal = startHour * 60 + startMinute;
  const endTotal = endHour * 60 + endMinute;
  return endTotal > startTotal;
};

watch(
  [() => addForm.jam_mulai, () => addForm.jam_selesai],
  ([start, end]) => {
    if (!start || !end) {
      addTimeError.value = '';
      return;
    }

    addTimeError.value = isValidTimeRange(start, end)
      ? ''
      : 'Jam selesai harus lebih besar dari jam mulai.';
  }
);

watch(
  [() => editForm.jam_mulai, () => editForm.jam_selesai],
  ([start, end]) => {
    if (!start || !end) {
      editTimeError.value = '';
      return;
    }

    editTimeError.value = isValidTimeRange(start, end)
      ? ''
      : 'Jam selesai harus lebih besar dari jam mulai.';
  }
);

const submitAddSchedule = async () => {
  if (!isValidTimeRange(addForm.jam_mulai, addForm.jam_selesai)) {
    addTimeError.value = 'Jam selesai harus lebih besar dari jam mulai.';
    return;
  }

  const formData = new FormData();
  formData.append('topik', addForm.topik);
  formData.append('tanggal', addForm.tanggal);
  formData.append('waktu_mulai', addForm.jam_mulai);
  formData.append('waktu_selesai', addForm.jam_selesai);
  formData.append('lokasi', addForm.lokasi);
  formData.append('topik_pembelajaran', addForm.topik_pembelajaran);
  formData.append('deskripsi', addForm.deskripsi);
  formData.append('jumlah_peserta', addForm.jumlah_peserta);
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
    setError('Jam selesai harus setelah jam mulai atau periksa kembali kelengkapan form.');
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

const startOfWeek = () => {
  const now = new Date();
  const start = new Date(now);
  const day = now.getDay() === 0 ? 6 : now.getDay() - 1;
  start.setDate(now.getDate() - day);
  start.setHours(0, 0, 0, 0);
  return start;
};

const isWithinCurrentWeek = (value) => {
  if (!value) return false;
  const date = new Date(value);
  const start = startOfWeek();
  const end = new Date(start);
  end.setDate(start.getDate() + 6);
  end.setHours(23, 59, 59, 999);
  return date >= start && date <= end;
};

const teachingSchedules = computed(() => {
  return jadwalMateri.value
    .filter((item) => isWithinCurrentWeek(item.waktu_mulai))
    .map((item) => {
      const dateLabel = `${formatFullDate(item.waktu_mulai)} · ${formatTimeRange(item.waktu_mulai, item.waktu_selesai)}`;
      const material = item.materi?.[0]?.judul || 'Belum ada materi';

      return {
        id: item.id,
        dateLabel,
        subject: item.topik,
        status: item.status,
        badgeColor: badgeClass(item.status),
        time: formatTimeRange(item.waktu_mulai, item.waktu_selesai),
        classroom: item.lokasi || 'Lokasi belum diisi',
        material,
      };
    });
});

const summaryCards = computed(() => {
  const totalStudents = new Set(attendanceRecords.value.map((record) => record.name)).size;
  const classCount = new Set(attendanceRecords.value.map((record) => record.session)).size;
  const statusTotals = attendanceRecords.value.reduce((acc, record) => {
    acc[record.status] = (acc[record.status] || 0) + 1;
    return acc;
  }, {});

  const weeklySessions = teachingSchedules.value.length;
  const completedSessions = teachingSchedules.value.filter((session) => session.status?.toLowerCase() === 'selesai').length;
  const materialsCount = jadwalMateri.value.reduce((acc, schedule) => acc + (schedule.materi?.length || 0), 0);
  const weeklyMaterials = jadwalMateri.value
    .filter((schedule) => isWithinCurrentWeek(schedule.waktu_mulai))
    .reduce((acc, schedule) => acc + (schedule.materi?.length || 0), 0);
  const pendingMaterials = jadwalMateri.value.reduce(
    (acc, schedule) => acc + (schedule.materi?.filter((m) => m.status && m.status.toLowerCase().includes('unggu')).length || 0),
    0
  );

  return [
    {
      id: 'students',
      subtitle: 'Total Siswa',
      value: `${totalStudents} Siswa`,
      description: `${classCount} kelas aktif`,
      trendLabel: `${statusTotals.Alpha || 0} siswa butuh perhatian`,
      trendColor: statusTotals.Alpha ? 'text-amber-500' : 'text-[#78AE4E]',
      trendIcon: statusTotals.Alpha ? ArrowDownCircleIcon : CheckCircleIcon,
    },
    {
      id: 'sessions',
      subtitle: 'Sesi Minggu Ini',
      value: `${weeklySessions} Sesi`,
      description: `${Math.max(weeklySessions - completedSessions, 0)} sesi tersisa`,
      trendLabel: `${completedSessions} sesi selesai`,
      trendColor: 'text-[#78AE4E]',
      trendIcon: ArrowUpCircleIcon,
    },
    {
      id: 'grades',
      subtitle: 'Laporan Kelas',
      value: `${attendanceRecords.value.length} Laporan`,
      description: `${classCount} kelas tercatat`,
      trendLabel: `${statusTotals.Hadir || 0} siswa hadir`,
      trendColor: 'text-[#78AE4E]',
      trendIcon: CheckCircleIcon,
    },
    {
      id: 'materials',
      subtitle: 'Materi Terunggah',
      value: `${materialsCount} Materi`,
      description: `${weeklyMaterials} materi minggu ini`,
      trendLabel: pendingMaterials ? `${pendingMaterials} menunggu review` : 'Semua materi aktif',
      trendColor: pendingMaterials ? 'text-amber-500' : 'text-[#78AE4E]',
      trendIcon: pendingMaterials ? ArrowDownCircleIcon : CheckCircleIcon,
    },
  ];
});

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
  editTimeError.value = '';
  showEditScheduleModal.value = true;
};

const closeEditSchedule = () => {
  showEditScheduleModal.value = false;
  editTimeError.value = '';
};

const submitEditSchedule = async () => {
  if (!isValidTimeRange(editForm.jam_mulai, editForm.jam_selesai)) {
    editTimeError.value = 'Jam selesai harus lebih besar dari jam mulai.';
    return;
  }

  try {
    await axios.put(`/api/guru/jadwal/${editForm.id}`, {
      topik: editForm.topik,
      tanggal: editForm.tanggal,
      waktu_mulai: editForm.jam_mulai,
      waktu_selesai: editForm.jam_selesai,
      lokasi: editForm.lokasi,
      jumlah_peserta: editForm.jumlah_peserta,
      deskripsi: editForm.deskripsi,
    });
    showEditScheduleModal.value = false;
    setSuccess('Jadwal berhasil diperbarui.');
    await loadJadwalMateri();
  } catch (error) {
    console.error('Gagal memperbarui jadwal:', error);
    setError('Tidak dapat memperbarui jadwal. Pastikan rentang waktunya benar.');
  }
};

const openEditMateri = (schedule) => {
  materiForm.scheduleId = schedule.id;
  materiForm.existing = schedule.materi.map((item) => ({ ...item, newFile: null }));
  materiForm.materi_uploads = [];
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
    setError('Materi gagal diperbarui. Coba unggah ulang file.');
  } finally {
    materialUploadProgress.value = 0;
  }
};

const openMaterialPreview = (material) => {
  selectedMaterialFile.value = material;
  showMaterialPreview.value = true;
};

const closeMaterialPreview = () => {
  showMaterialPreview.value = false;
  selectedMaterialFile.value = null;
};
</script>
