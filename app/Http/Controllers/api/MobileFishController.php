<?php

namespace App\Http\Controllers\Api; // PERBAIKAN: Huruf 'A' pada App harus besar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SensorData; 

class MobileFishController extends Controller
{
    // 1. FUNGSI LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // PERBAIKAN: Gunakan 'username' agar cocok dengan data 'admin_final'
        $credentials = [
            'username' => $request->username, // Ubah dari 'email' ke 'username'
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'message' => 'Login Berhasil',
                'user' => $user
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Username atau Password salah'
        ], 401);
    }

    // 2. FUNGSI INSERT SUHU (Tetap)
    public function insertSuhu(Request $request)
    {
        $request->validate([
            'suhu' => 'required'
        ]);

        // Pastikan model SensorData diarahkan ke tabel yang benar (sensor_suhu)
        // Sesuai perbaikan kita sebelumnya di file Model
        SensorData::create([
            'nilai' => $request->suhu, // PERBAIKAN: Sesuaikan dengan kolom DB 'nilai'
            'waktu' => now(),          // Tambahkan waktu saat ini
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data suhu berhasil disimpan'
        ], 200);
    }
    
    // ... fungsi lain biarkan saja

    public function getSchedules() {
    // Ambil semua jadwal, urutkan dari jam terkecil
    $schedules = \App\Models\Schedule::orderBy('waktu', 'asc')->get();
    return response()->json($schedules);
}

public function storeSchedule(Request $request) {
    $request->validate(['waktu' => 'required']);

    \App\Models\Schedule::create([
        'waktu' => $request->waktu,
        'aktif' => 1,
        // Ambil input dari flutter, kalau kosong default 'PAKAN'
        'jenis_jadwal' => $request->jenis_jadwal ?? 'PAKAN' 
    ]);

    return response()->json(['message' => 'Sukses']);
}

// ... fungsi login dll di atas ...

    // 4. FUNGSI TRIGGER MANUAL PAKAN (Dari Tombol Flutter)
    public function triggerPakan()
    {
        // Ganti IP ini dengan IP ESP32 Anda
        $ip_esp32 = '192.168.1.100'; 

        try {
            // Tembak ESP32
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get("http://{$ip_esp32}/feed");
            
            if ($response->successful()) {
                // Catat di Database
                \App\Models\FeedingLog::create(['fed_at' => now()]);
                
                return response()->json(['status' => 'success', 'message' => 'Sukses memberi pakan!']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'ESP32 tidak merespon'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal koneksi ke alat'], 500);
        }
    }

    // 5. FUNGSI TRIGGER MANUAL KURAS
    public function triggerKuras()
    {
        $ip_esp32 = '192.168.1.100'; // Ganti IP ESP32

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get("http://{$ip_esp32}/kuras");
            
            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Proses kuras dimulai!']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'ESP32 tidak merespon'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal koneksi ke alat'], 500);
        }
    }
}