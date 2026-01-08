<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData; // Pastikan Model ini sudah diarahkan ke tabel 'sensor_suhu'

class FishStatusController extends Controller
{
    /**
     * Menampilkan halaman status ikan dengan data awal.
     */
    public function index()
    {
        // 1. Ambil data terakhir berdasarkan ID terbesar
        // Kita pakai orderBy 'id' karena Anda menggunakan kolom 'waktu', bukan 'created_at'
        $latest = SensorData::orderBy('id', 'desc')->first();

        // 2. Ambil 10 data terakhir untuk tabel riwayat
        $history = SensorData::orderBy('id', 'desc')->limit(10)->get();

        // 3. Handle jika database kosong agar tidak error
        if (!$latest) {
            $latest = new SensorData();
            $latest->nilai = 0; // Default suhu 0
            $latest->waktu = '-';
        }

        return view('fish-status', compact('latest', 'history'));
    }

    /**
     * Endpoint API untuk mengambil data terbaru secara Real-Time (AJAX).
     */
    public function getRealTimeData()
    {
        // 1. Ambil data terakhir
        $latest = SensorData::orderBy('id', 'desc')->first();

        // 2. Mapping Data dari Database ke Variabel
        // Karena database Anda hanya punya kolom 'nilai' (Suhu)
        $suhu = $latest ? $latest->nilai : 0; 
        
        // Data lain kita set 0 karena kolomnya tidak ada di tabel sensor_suhu
        $ph   = 0; 
        $turb = 0; // Dianggap sebagai feed_level/kekeruhan

        // 3. Siapkan Logika Warna & Label
        
        // --- LOGIKA SUHU (Dari kolom 'nilai') ---
        $suhuStatus = ($suhu >= 25 && $suhu <= 30) ? 'success' : 'danger';
        $suhuLabel  = ($suhu >= 25 && $suhu <= 30) ? 'Normal' : 'Bahaya';

        // --- LOGIKA PH (Dummy / 0) ---
        $phStatus = 'warning'; 
        $phLabel  = 'No Data';

        // --- LOGIKA TURBIDITY/PAKAN (Dummy / 0) ---
        $turbStatus = 'secondary';
        $turbLabel  = 'No Data';

        // 4. Susun Data JSON untuk dikirim ke JavaScript
        $data = [
            'temperature' => [
                'value' => number_format($suhu, 1),
                'percent' => ($suhu / 50) * 100, // Asumsi max grafik 50 derajat
                'status_class' => $suhuStatus,
                'label' => $suhuLabel,
            ],
            'ph' => [
                'value' => number_format($ph, 1),
                'percent' => 0, // 0 karena tidak ada sensor
                'status_class' => $phStatus,
                'label' => $phLabel,
            ],
            'feed' => [ // Kita namakan 'feed' agar sesuai dengan script JS di view
                'value' => $turb,
                'percent' => 0, 
                'status_class' => $turbStatus,
                'label' => $turbLabel,
            ],
            // Mengirim waktu update terakhir
            'last_updated' => ($latest && $latest->waktu) ? $latest->waktu : '-',
        ];

        return response()->json($data);
    }
}