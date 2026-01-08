<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SensorData; // Menggunakan model SensorData yang Anda upload

class MobileFishController extends Controller
{
    // 1. FUNGSI LOGIN (Menerima input JSON dari Flutter)
    public function login(Request $request)
    {
        // Flutter mengirim field: 'username' dan 'password'
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Karena di AuthController.php website Anda pakai 'email',
        // Kita asumsikan input 'username' dari Flutter itu berisi Email.
        $credentials = [
            'email' => $request->username, 
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Kembalikan JSON persis seperti yang diminta Flutter
            return response()->json([
                'status' => 'success',
                'message' => 'Login Berhasil',
                'user' => $user
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Email atau Password salah'
        ], 401);
    }

    // 2. FUNGSI INSERT SUHU (Menerima input dari Flutter)
    public function insertSuhu(Request $request)
    {
        // Flutter mengirim field: 'suhu' (string/double)
        $request->validate([
            'suhu' => 'required'
        ]);

        // Simpan ke tabel sensor_datas
        // Kolom di Model SensorData.php Anda adalah 'temperature'
        SensorData::create([
            'temperature' => $request->suhu,
            // Nilai default untuk kolom lain agar tidak error (karena di model Anda fillable)
            'ph_level' => 0, 
            'turbidity' => 0,
            'feed_level' => 0 
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data suhu berhasil disimpan'
        ], 200);
    }
    
    // 3. FUNGSI AMBIL DATA SUHU TERBARU (Opsional, untuk monitoring Flutter)
    public function getLatestSuhu()
    {
        $data = SensorData::latest()->first();
        
        return response()->json([
            'status' => 'success',
            'suhu' => $data ? $data->temperature : 0
        ]);
    }
}