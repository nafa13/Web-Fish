<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedingLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http; // Tambahkan ini untuk komunikasi ke ESP32 nanti

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil jumlah pakan hari ini (Reset setiap tengah malam)
        $totalFeedingToday = FeedingLog::whereDate('fed_at', Carbon::today())->count();

        // 2. Logika Menentukan Jadwal Berikutnya (Sederhana)
        // Misal jadwal kita adalah jam 08:00 dan 16:00
        $schedules = ['08:00', '16:00'];
        $nextSchedule = '--:--';

        $now = Carbon::now();
        
        foreach ($schedules as $time) {
            $scheduleTime = Carbon::createFromFormat('H:i', $time);
            
            // Jika jadwal jam ini belum lewat dari waktu sekarang
            if ($scheduleTime->greaterThan($now)) {
                $nextSchedule = $time;
                break; // Ambil jadwal pertama yang ketemu
            }
        }

        // Jika semua jadwal hari ini sudah lewat, set ke jadwal pertama besok
        if ($nextSchedule == '--:--') {
            $nextSchedule = $schedules[0] . ' (Besok)';
        }

        return view('dashboard', compact('totalFeedingToday', 'nextSchedule'));
    }

    public function feedNow()
    {
        // 1. Coba kirim perintah ke Hardware (Opsional: Aktifkan jika alat sudah ada)
        /*
        try {
            // Ganti IP sesuai IP ESP32 Anda
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
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Perintah pakan berhasil dikirim!');
    }
}