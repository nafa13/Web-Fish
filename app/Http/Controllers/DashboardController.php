<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedingLog;
use App\Models\Schedule; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil jumlah pakan hari ini
        $totalFeedingToday = FeedingLog::whereDate('fed_at', Carbon::today())->count();

        // 2. Logika Next Schedule (SUDAH DIPERBAIKI)
        
        // Cari jadwal hari ini yang waktunya > waktu sekarang
        // Menggunakan kolom: 'aktif' dan 'waktu'
        $nextScheduleData = Schedule::where('aktif', 1)
                                    ->where('waktu', '>', now()->format('H:i:s'))
                                    ->orderBy('waktu', 'asc')
                                    ->first();

        if ($nextScheduleData) {
            // JIKA ADA jadwal hari ini
            // Perbaikan: Gunakan ->waktu bukan ->feeding_time
            $nextSchedule = Carbon::parse($nextScheduleData->waktu)->format('H:i');
        } else {
            // JIKA TIDAK ADA, ambil jadwal paling pagi untuk BESOK
            // Perbaikan: Gunakan 'aktif' dan 'waktu' di sini juga
            $firstScheduleTomorrow = Schedule::where('aktif', 1)
                ->orderBy('waktu', 'asc')
                ->first();
                
            $nextSchedule = $firstScheduleTomorrow 
                ? Carbon::parse($firstScheduleTomorrow->waktu)->format('H:i') . ' (Besok)'
                : '--:--'; 
        }

        return view('dashboard', compact('totalFeedingToday', 'nextSchedule'));
    }

}