<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FeedingLog;
use App\Models\Schedule;
use App\Models\SensorData; // Pastikan model ini ada
use Carbon\Carbon;

class ApiController extends Controller
{
    // 1. API LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'user' => $user,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Email atau password salah',
        ], 401);
    }

    // 2. API DASHBOARD (Total Pakan & Jadwal)
    public function getDashboardData()
    {
        // Hitung total pakan hari ini
        $totalFeedingToday = FeedingLog::whereDate('created_at', Carbon::today())->count();

        // Cari jadwal berikutnya
        $now = Carbon::now();
        $currentTimeString = $now->format('H:i:s');

        $nextScheduleData = Schedule::where('is_active', true)
            ->where('feeding_time', '>', $currentTimeString)
            ->orderBy('feeding_time', 'asc')
            ->first();

        if ($nextScheduleData) {
            $nextSchedule = Carbon::parse($nextScheduleData->feeding_time)->format('H:i');
        } else {
            $firstScheduleTomorrow = Schedule::where('is_active', true)
                ->orderBy('feeding_time', 'asc')
                ->first();
            
            $nextSchedule = $firstScheduleTomorrow 
                ? Carbon::parse($firstScheduleTomorrow->feeding_time)->format('H:i') . ' (Besok)'
                : '--:--';
        }

        // Ambil data sensor terakhir (Suhu, pH)
        $latestSensor = SensorData::latest()->first();

        return response()->json([
            'status' => 'success',
            'total_feeding' => $totalFeedingToday,
            'next_schedule' => $nextSchedule,
            'sensor' => $latestSensor ?? [
                'temperature' => 0,
                'ph_level' => 0,
                'turbidity' => 0
            ]
        ]);
    }

    // 3. API FEED NOW (Perintah Pakan)
    public function feedNow(Request $request)
    {
        // Simpan Log (User ID 1 sementara jika dari HP tanpa token)
        FeedingLog::create([
            'fed_at' => now(),
            'status' => 'success',
            'type'   => 'manual',
            'user_id' => $request->user_id ?? 1, 
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pakan berhasil diberikan'
        ]);
    }
    
    // 4. API SIMPAN SENSOR (Untuk Arduino/ESP32 kirim ke Server)
    public function storeSensorData(Request $request)
    {
        SensorData::create([
            'temperature' => $request->temperature,
            'ph_level' => $request->ph_level,
            'turbidity' => $request->turbidity,
            'feed_level' => $request->feed_level
        ]);

        return response()->json(['status' => 'success']);
    }
}