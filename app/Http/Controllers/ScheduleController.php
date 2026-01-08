<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule; // Pastikan Model Schedule di-import

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar jadwal.
     */
    public function index()
    {
        // PERBAIKAN: Menggunakan 'waktu' (sesuai database 'jadwal')
        // Bukan 'feeding_time'
        $schedules = Schedule::orderBy('waktu', 'asc')->get();

        // Pastikan nama file view sesuai folder Anda (misal: schedule/index atau jadwal/index)
        return view('schedule', compact('schedules'));
    }

    /**
     * Menyimpan jadwal baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'waktu' => 'required', // Pastikan input di form HTML name="waktu"
        ]);

        // PERBAIKAN: Simpan ke kolom 'waktu' & 'aktif'
        Schedule::create([
            'waktu' => $request->waktu,
            'aktif' => 1, // Default aktif (1)
            'jenis_jadwal' => $request->jenis_jadwal ?? 'Harian', // Default jika kosong
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Menghapus jadwal.
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule) {
            $schedule->delete();
            return back()->with('success', 'Jadwal dihapus.');
        }
        return back()->with('error', 'Data tidak ditemukan.');
    }

    /**
     * Mengubah status Aktif/Non-aktif (Toggle).
     */
    public function toggle($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule) {
            // PERBAIKAN: Ganti logika 'is_active' jadi 'aktif'
            $schedule->aktif = !$schedule->aktif; 
            $schedule->save();
            return back()->with('success', 'Status jadwal diperbarui.');
        }
        return back()->with('error', 'Data tidak ditemukan.');
    }
}