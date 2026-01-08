<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedingLog;

class FeedingLogController extends Controller
{
    // Fungsi ini dipanggil oleh Flutter
    public function storeFromFlutter(Request $request)
    {
        FeedingLog::create([
            'fed_at' => now(), // Catat waktu sekarang
        ]);

        return response()->json(['message' => 'Log pakan berhasil disimpan'], 200);
    }
}