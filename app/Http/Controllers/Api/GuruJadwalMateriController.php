<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalSesi;
use App\Models\Materi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruJadwalMateriController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = JadwalSesi::with('materi')->orderBy('waktu_mulai');
        if ($user) {
            $query->where('guru_id', $user->id);
        }

        $data = $query->get()->map(function ($item) {
            $item = $this->refreshStatus($item);

            return $this->mapSchedule($item);
        });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $guruId = optional($request->user())->id;

        if (!$guruId) {
            abort(401, 'Guru tidak terautentikasi.');
        }

        $validator = Validator::make($request->all(), [
            'topik' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'waktu_mulai' => ['required', 'date_format:H:i'],
            'waktu_selesai' => ['required', 'date_format:H:i'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'topik_pembelajaran' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'jumlah_peserta' => ['nullable', 'integer', 'min:0'],
            'materi_deskripsi' => ['nullable', 'string'],
            'materi_titles' => ['array'],
            'materi_titles.*' => ['nullable', 'string', 'max:255'],
            'materi_uploads' => ['array'],
            'materi_uploads.*' => ['file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg,mp4'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->filled(['waktu_mulai', 'waktu_selesai'])) {
                $start = Carbon::createFromFormat('H:i', $request->input('waktu_mulai'));
                $end = Carbon::createFromFormat('H:i', $request->input('waktu_selesai'));

                if ($end->lessThanOrEqualTo($start)) {
                    $validator->errors()->add('waktu_selesai', 'Jam selesai harus lebih besar dari jam mulai.');
                }
            }
        });

        $validated = $validator->validate();

        $start = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_mulai']);
        $end = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_selesai']);

        $jadwal = JadwalSesi::create([
            'topik' => $validated['topik'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'waktu_mulai' => $start,
            'waktu_selesai' => $end,
            'lokasi' => $validated['lokasi'] ?? null,
            'jumlah_peserta' => $validated['jumlah_peserta'] ?? null,
            'status' => $this->resolveStatus($start, $end),
            'topik_pembelajaran' => $validated['topik_pembelajaran'] ?? null,
            'guru_id' => $guruId,
        ]);

        $this->storeUploads($request, $jadwal, $validated);

        return response()->json([
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $this->mapSchedule($jadwal->fresh('materi')),
        ], 201);
    }

    public function update(Request $request, JadwalSesi $jadwalSesi)
    {
        $validator = Validator::make($request->all(), [
            'topik' => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal' => ['sometimes', 'required', 'date'],
            'waktu_mulai' => ['sometimes', 'required', 'date_format:H:i'],
            'waktu_selesai' => ['sometimes', 'required', 'date_format:H:i'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'topik_pembelajaran' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'jumlah_peserta' => ['nullable', 'integer', 'min:0'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->filled(['waktu_mulai', 'waktu_selesai'])) {
                $start = Carbon::createFromFormat('H:i', $request->input('waktu_mulai'));
                $end = Carbon::createFromFormat('H:i', $request->input('waktu_selesai'));

                if ($end->lessThanOrEqualTo($start)) {
                    $validator->errors()->add('waktu_selesai', 'Jam selesai harus lebih besar dari jam mulai.');
                }
            }
        });

        $validated = $validator->validate();

        if (isset($validated['tanggal']) && isset($validated['waktu_mulai'])) {
            $jadwalSesi->waktu_mulai = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_mulai']);
        }
        if (isset($validated['tanggal']) && isset($validated['waktu_selesai'])) {
            $jadwalSesi->waktu_selesai = Carbon::parse($validated['tanggal'] . ' ' . $validated['waktu_selesai']);
        }

        $jadwalSesi->fill(collect($validated)->except(['tanggal', 'waktu_mulai', 'waktu_selesai'])->toArray());
        $jadwalSesi->status = $this->resolveStatus($jadwalSesi->waktu_mulai, $jadwalSesi->waktu_selesai);
        $jadwalSesi->save();

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $this->mapSchedule($jadwalSesi->fresh('materi')),
        ]);
    }

    public function storeMaterial(Request $request, JadwalSesi $jadwalSesi)
    {
        $validated = $request->validate([
            'materi_deskripsi' => ['nullable', 'string'],
            'materi_titles' => ['array'],
            'materi_titles.*' => ['nullable', 'string', 'max:255'],
            'materi_uploads' => ['required', 'array'],
            'materi_uploads.*' => ['file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg,mp4'],
        ]);

        $this->storeUploads($request, $jadwalSesi, $validated);

        return response()->json([
            'message' => 'Materi berhasil ditambahkan',
            'data' => $this->mapSchedule($jadwalSesi->fresh('materi')),
        ], 201);
    }

    public function updateMaterial(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg,mp4'],
        ]);

        if ($request->hasFile('file')) {
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $path = $request->file('file')->store('materi', 'public');
            $materi->file_path = $path;
        }

        $materi->judul = $validated['judul'];
        $materi->deskripsi = $validated['deskripsi'] ?? null;
        $materi->status = 'Terunggah';
        $materi->save();

        return response()->json([
            'message' => 'Materi berhasil diperbarui',
            'data' => $materi,
        ]);
    }

    protected function resolveStatus(Carbon $start, Carbon $end): string
    {
        $now = Carbon::now();

        if ($now->lt($start)) {
            return 'Akan Datang';
        }

        if ($now->between($start, $end)) {
            return 'Berlangsung';
        }

        return 'Selesai';
    }

    protected function refreshStatus(JadwalSesi $jadwal): JadwalSesi
    {
        $status = $this->resolveStatus($jadwal->waktu_mulai, $jadwal->waktu_selesai);

        if ($jadwal->status !== $status) {
            $jadwal->status = $status;
            $jadwal->save();
        }

        return $jadwal;
    }

    protected function storeUploads(Request $request, JadwalSesi $jadwal, array $validated): void
    {
        $files = $request->file('materi_uploads', []);
        $titles = $validated['materi_titles'] ?? [];
        $status = 'Terunggah';
        $deskripsi = $validated['materi_deskripsi'] ?? null;

        foreach ($files as $index => $file) {
            $path = $file->store('materi', 'public');
            $judul = $titles[$index] ?? $file->getClientOriginalName();

            $jadwal->materi()->create([
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'file_path' => $path,
                'status' => $status,
            ]);
        }
    }

    protected function mapSchedule(JadwalSesi $jadwal): array
    {
        // Guard against unexpected payloads reaching this mapper so we never raise a
        // type error back to the client. When an id or raw array slips through, we
        // resolve it to a full JadwalSesi instance with materi already loaded.
        if (is_numeric($jadwal) || is_string($jadwal)) {
            $jadwal = JadwalSesi::with('materi')->find($jadwal);
        }

        if ($jadwal instanceof JadwalSesi === false) {
            abort(422, 'Jadwal tidak valid atau tidak ditemukan.');
        }

        if (!$jadwal->relationLoaded('materi')) {
            $jadwal->load('materi');
        }

        $jadwal = $this->refreshStatus($jadwal);

        return [
            'id' => $jadwal->id,
            'topik' => $jadwal->topik,
            'deskripsi' => $jadwal->deskripsi,
            'waktu_mulai' => $jadwal->waktu_mulai,
            'waktu_selesai' => $jadwal->waktu_selesai,
            'lokasi' => $jadwal->lokasi,
            'jumlah_peserta' => $jadwal->jumlah_peserta,
            'status' => $jadwal->status,
            'topik_pembelajaran' => $jadwal->topik_pembelajaran,
            'materi' => $jadwal->materi->map(function ($materi) {
                return [
                    'id' => $materi->id,
                    'judul' => $materi->judul,
                    'deskripsi' => $materi->deskripsi,
                    'status' => $materi->status,
                    'file_path' => $materi->file_path,
                    'url' => $materi->file_path ? Storage::url($materi->file_path) : null,
                ];
            }),
        ];
    }
}
