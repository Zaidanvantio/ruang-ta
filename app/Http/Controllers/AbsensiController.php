<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar absensi berdasarkan bulan dan tahun.
     */
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request, atau gunakan tanggal saat ini sebagai default
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Ambil data absensi dari database
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->orderBy('tanggal', 'asc')
                            ->get();

        // Hitung jumlah cuti
        $jumlahCuti = Absensi::whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun)
                            ->where('cuti', true)->count();
        
        return view('absensi.index', compact('absensi', 'jumlahCuti', 'bulan', 'tahun'));
    }

    /**
     * Menampilkan form untuk membuat data absensi baru.
     */
    public function create()
    {
        return view('absensi.create');
    }

    /**
     * Menyimpan data absensi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_datang' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after:jam_datang',
            'uraian_pekerjaan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['cuti'] = $request->has('cuti');

        // Hitung jam kerja hanya jika jam datang dan pulang diisi
        if ($request->jam_datang && $request->jam_pulang) {
            $datang = Carbon::parse($request->jam_datang);
            $pulang = Carbon::parse($request->jam_pulang);
            $durasi = $pulang->diff($datang);
            $data['jam_kerja'] = $durasi->format('%H:%I');
        } else {
            $data['jam_kerja'] = null; // Pastikan jam kerja null jika tidak lengkap
        }

        Absensi::create($data);

        return redirect()->route('absensi.index')
                         ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data absensi.
     */
    public function edit(Absensi $absensi)
    {
        return view('absensi.edit', compact('absensi'));
    }

    /**
     * Memperbarui data absensi di database.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_datang' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after:jam_datang',
            'uraian_pekerjaan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['cuti'] = $request->has('cuti');

        // Hitung ulang jam kerja hanya jika jam datang dan pulang diisi
        if ($request->jam_datang && $request->jam_pulang) {
            $datang = Carbon::parse($request->jam_datang);
            $pulang = Carbon::parse($request->jam_pulang);
            $durasi = $pulang->diff($datang);
            $data['jam_kerja'] = $durasi->format('%H:%I');
        } else {
            $data['jam_kerja'] = null; // Pastikan jam kerja null jika tidak lengkap
        }

        $absensi->update($data);

        return redirect()->route('absensi.index')
                         ->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Menghapus data absensi dari database.
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return redirect()->route('absensi.index')
                         ->with('success', 'Data absensi berhasil dihapus.');
    }
}