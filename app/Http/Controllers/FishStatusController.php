<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class FishStatusController extends Controller
{
    public function index()
    {
        // Ambil data sensor terakhir untuk ditampilkan di kartu utama
        $latest = SensorData::latest()->first();

        // Ambil 10 data terakhir untuk tabel riwayat
        $history = SensorData::latest()->limit(10)->get();

        // Jika belum ada data sama sekali, buat data dummy sementara agar tampilan tidak error
        if (!$latest) {
            $latest = new SensorData([
                'temperature' => 0,
                'ph_level' => 0,
                'turbidity' => 0,
                'feed_level' => 0
            ]);
        }

        return view('fish-status', compact('latest', 'history'));
    }
}