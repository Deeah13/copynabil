<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalSesi;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GuruKehadiranController extends Controller
{
    public function index(Request $request)
    {
        $records = $this->getAttendanceForGuru($request->user());

        return response()->json([
            'data' => $records->map(fn (Kehadiran $item) => $this->transformAttendance($item)),
            'summary' => $this->buildSummary($records),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswa,id'],
            'sesi_id' => ['required', 'exists:jadwal_sesi,id'],
            'status' => ['required', 'in:Hadir,Sakit,Izin,Alpha'],
        ]);

        $sesi = JadwalSesi::whereKey($validated['sesi_id'])
            ->when($request->user(), fn ($query, $user) => $query->where('guru_id', $user->id))
            ->first();

        if (!$sesi) {
            abort(403, 'Anda tidak dapat mengubah kehadiran untuk sesi ini.');
        }

        $kehadiran = Kehadiran::updateOrCreate(
            [
                'siswa_id' => $validated['siswa_id'],
                'sesi_id' => $validated['sesi_id'],
            ],
            ['status' => $validated['status']]
        )->load(['siswa', 'jadwalSesi']);

        $records = $this->getAttendanceForGuru($request->user());

        return response()->json([
            'message' => 'Status kehadiran berhasil disimpan.',
            'data' => $this->transformAttendance($kehadiran),
            'summary' => $this->buildSummary($records),
        ]);
    }

    public function destroy(Kehadiran $kehadiran, Request $request)
    {
        $isOwnedByGuru = $kehadiran->jadwalSesi
            ? $kehadiran->jadwalSesi->guru_id === optional($request->user())->id
            : false;

        abort_unless($isOwnedByGuru, 403, 'Anda tidak diizinkan menghapus kehadiran ini.');

        $kehadiran->delete();

        $records = $this->getAttendanceForGuru($request->user());

        return response()->json([
            'message' => 'Data kehadiran berhasil dihapus.',
            'summary' => $this->buildSummary($records),
        ]);
    }

    private function getAttendanceForGuru($guru): Collection
    {
        return Kehadiran::with(['siswa', 'jadwalSesi'])
            ->when($guru, fn ($query) => $query->whereHas('jadwalSesi', fn ($sesi) => $sesi->where('guru_id', $guru->id)))
            ->orderByDesc('updated_at')
            ->get();
    }

    private function buildSummary(Collection $records): array
    {
        return [
            'hadir' => $records->where('status', 'Hadir')->count(),
            'sakit' => $records->where('status', 'Sakit')->count(),
            'izin' => $records->where('status', 'Izin')->count(),
            'alpha' => $records->where('status', 'Alpha')->count(),
        ];
    }

    private function transformAttendance(Kehadiran $item): array
    {
        return [
            'id' => $item->id,
            'status' => $item->status,
            'siswa_id' => $item->siswa_id,
            'siswa_nama' => $item->siswa->nama ?? 'Tidak diketahui',
            'sesi_id' => $item->sesi_id,
            'sesi_topik' => $item->jadwalSesi->topik ?? 'Sesi tanpa judul',
            'sesi_waktu_mulai' => $item->jadwalSesi->waktu_mulai ?? null,
            'sesi_waktu_selesai' => $item->jadwalSesi->waktu_selesai ?? null,
        ];
    }
}
