<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Schedule;
use App\Models\FeedingLog;
use Carbon\Carbon;

class TriggerJadwalPakan extends Command
{
    // Nama command tetap sama agar tidak perlu ubah settingan Kernel/Console
    protected $signature = 'pakan:trigger';
    protected $description = 'Cek jadwal otomatis untuk Pakan & Kuras';

    public function handle()
    {
        // 1. Ambil Jam Sekarang (Hanya Jam & Menit)
        $now = Carbon::now()->format('H:i'); 

        // 2. Cari di Database: Jadwal yang AKTIF & WAKTUNYA SAMA
        $jadwal = Schedule::where('aktif', 1)
                          ->where('waktu', 'like', $now . '%') 
                          ->first();

        if ($jadwal) {
            $this->info("⏰ Jadwal Ditemukan: [{$jadwal->jenis_jadwal}] pada jam $now");

            // --- PENTING: Ganti IP ini dengan IP ESP32 Anda yang muncul di Serial Monitor ---
            $ip_esp32 = '192.168.1.100'; 

            try {
                // 3. CEK JENIS JADWAL (Logika Percabangan)
                if ($jadwal->jenis_jadwal == 'PAKAN') {
                    
                    // --- A. JIKA JADWAL PAKAN ---
                    $response = Http::timeout(5)->get("http://{$ip_esp32}/feed");
                    
                    if ($response->successful()) {
                        $this->info("✅ Sukses: Perintah MAKAN dikirim ke Servo.");

                        // Catat Log Pakan (Agar tidak double input dalam 1 menit)
                        if (!FeedingLog::where('fed_at', 'like', date('Y-m-d H:i').'%')->exists()) {
                            FeedingLog::create(['fed_at' => now()]);
                        }
                    } else {
                        $this->error("❌ Gagal: ESP32 merespon error untuk Pakan.");
                    }

                } elseif ($jadwal->jenis_jadwal == 'KURAS') {
                    
                    // --- B. JIKA JADWAL KURAS ---
                    $response = Http::timeout(5)->get("http://{$ip_esp32}/kuras");
                    
                    if ($response->successful()) {
                        $this->info("✅ Sukses: Perintah KURAS dikirim ke Alat.");
                        // (Opsional: Tambahkan logika logging khusus kuras jika perlu)
                    } else {
                        $this->error("❌ Gagal: ESP32 merespon error untuk Kuras.");
                    }

                } else {
                    $this->warn("⚠️ Jenis jadwal tidak dikenali: {$jadwal->jenis_jadwal}");
                }

            } catch (\Exception $e) {
                $this->error("⚠️ Gagal koneksi ke ESP32: " . $e->getMessage());
                $this->error("Pastikan Laptop & ESP32 terhubung ke WiFi yang sama.");
            }
        } else {
            // $this->info("Tidak ada jadwal di jam $now");
        }
    }
}