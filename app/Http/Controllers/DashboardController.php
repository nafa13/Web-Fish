<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedingLog;
use App\Models\Schedule; // Pastikan Model Schedule di-import
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data dinamis.
     */
    public function index()
    {
        // 1. Ambil jumlah pakan hari ini (Reset setiap tengah malam)
        $totalFeedingToday = FeedingLog::whereDate('fed_at', Carbon::today())->count();

        // 2. Logika Next Schedule (AMBIL DARI DATABASE)
        $now = Carbon::now();
        $currentTimeString = $now->format('H:i:s');

        // Cari jadwal hari ini yang waktunya > waktu sekarang
        // Contoh: Sekarang jam 09:00, cari jadwal jam 12:00, 17:00, dst.
        $nextScheduleData = Schedule::where('is_active', true)
            ->where('feeding_time', '>', $currentTimeString)
            ->orderBy('feeding_time', 'asc')
            ->first();

        if ($nextScheduleData) {
            // Jika ada jadwal nanti hari ini
            $nextSchedule = Carbon::parse($nextScheduleData->feeding_time)->format('H:i');
        } else {
            // Jika tidak ada jadwal lagi hari ini, ambil jadwal paling pagi untuk BESOK
            $firstScheduleTomorrow = Schedule::where('is_active', true)
                ->orderBy('feeding_time', 'asc')
                ->first();
                
            $nextSchedule = $firstScheduleTomorrow 
                ? Carbon::parse($firstScheduleTomorrow->feeding_time)->format('H:i') . ' (Besok)'
                : '--:--'; // Jika database jadwal kosong sama sekali
        }

        return view('dashboard', compact('totalFeedingToday', 'nextSchedule'));
    }

    /**
     * Menangani logika tombol "Feed Now" (Pakan Manual).
     */
    public function feedNow()
    {
        // 1. Logika kirim perintah ke Hardware (ESP32) - Uncomment jika alat sudah siap
        /*
        try {
            // Timeout 3 detik agar loading web tidak lama jika alat mati
            $response = Http::timeout(3)->get('http://192.168.1.100/feed');
            
            if ($response->failed()) {
                return back()->with('error', 'Gagal terkoneksi ke alat pemberi pakan.');
            }
        } catch (\Exception $e) {
            // return back()->with('error', 'Alat tidak ditemukan / Offline.');
        }
        */

        // 2. Simpan Log ke Database
        FeedingLog::create([
            'fed_at' => now(),
            'status' => 'success',
            'type'   => 'manual',
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Perintah pakan berhasil dikirim!');
    }
}