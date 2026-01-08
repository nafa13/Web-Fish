@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-primary">Status Kolam Real-Time</h4>
        <span class="badge bg-white text-muted border px-3 py-2 rounded-pill">
            <i class="bi bi-clock me-1"></i> Update Terakhir: <span id="last-updated">{{ $latest->waktu ?? '-' }}</span>
        </span>
    </div>

    {{-- Baris Kartu Status Utama --}}
    <div class="row g-4 mb-4">
        
        {{-- KARTU 1: SUHU AIR (Data Asli dari Database) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 position-relative">
                    <h6 class="text-muted fw-bold text-uppercase mb-3">Suhu Air</h6>
                    <div class="d-flex align-items-center">
                        {{-- PERBAIKAN: Menggunakan $latest->nilai --}}
                        <h1 class="display-4 fw-bold mb-0 text-dark me-2">
                            <span id="temp-val">{{ number_format($latest->nilai ?? 0, 1) }}</span>°C
                        </h1>
                        
                        {{-- Logika Badge PHP (Initial Load) --}}
                        @php
                            $valSuhu = $latest->nilai ?? 0;
                            // Logika: 25-30 Normal, Selain itu Bahaya
                            $suhuClass = ($valSuhu >= 25 && $valSuhu <= 30) ? 'success' : 'danger';
                            $suhuLabel = ($valSuhu >= 25 && $valSuhu <= 30) ? 'Normal' : 'Bahaya';
                        @endphp
                        
                        <span id="temp-badge" class="badge bg-{{ $suhuClass }} bg-opacity-10 text-{{ $suhuClass }} px-3 py-2 rounded-pill">
                            {{ $suhuLabel }}
                        </span>
                    </div>
                    <small class="text-muted mt-2 d-block">Ideal: 25°C - 30°C</small>
                    <i class="bi bi-thermometer-half position-absolute text-danger opacity-25" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
                </div>
                {{-- Progress Bar --}}
                <div class="progress" style="height: 5px;">
                    <div id="temp-bar" class="progress-bar bg-danger" role="progressbar" style="width: {{ (($latest->nilai ?? 0) / 50) * 100 }}%"></div>
                </div>
            </div>
        </div>

        {{-- KARTU 2: pH AIR (Dummy - Karena tidak ada di DB) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 position-relative">
                    <h6 class="text-muted fw-bold text-uppercase mb-3">pH Air</h6>
                    <div class="d-flex align-items-center">
                        <h1 class="display-4 fw-bold mb-0 text-dark me-2">
                            <span id="ph-val">0</span>
                        </h1>
                        <span id="ph-badge" class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                            No Sensor
                        </span>
                    </div>
                    <small class="text-muted mt-2 d-block">Sensor belum terpasang</small>
                    <i class="bi bi-droplet-half position-absolute text-info opacity-25" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
                </div>
                <div class="progress" style="height: 5px;">
                    <div id="ph-bar" class="progress-bar bg-info" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
        </div>

        {{-- KARTU 3: KEKERUHAN / PAKAN (Dummy - Karena tidak ada di DB) --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 position-relative">
                    <h6 class="text-muted fw-bold text-uppercase mb-3">Kekeruhan</h6>
                    <div class="d-flex align-items-center">
                        <h1 class="display-4 fw-bold mb-0 text-dark me-2">
                            <span id="feed-val">0</span> NTU
                        </h1>
                        <span id="feed-badge" class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                            No Sensor
                        </span>
                    </div>
                    <small class="text-muted mt-2 d-block">Sensor belum terpasang</small>
                    <i class="bi bi-water position-absolute text-success opacity-25" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
                </div>
                <div class="progress" style="height: 5px;">
                    <div id="feed-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Sensor --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">Riwayat Suhu Terakhir</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Waktu</th>
                            <th>Suhu (°C)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $log)
                            <tr>
                                {{-- PERBAIKAN: Gunakan kolom 'waktu' --}}
                                <td class="ps-4 text-muted fw-medium">{{ $log->waktu ?? '-' }}</td>
                                
                                {{-- PERBAIKAN: Gunakan kolom 'nilai' --}}
                                <td class="fw-bold">{{ number_format($log->nilai ?? 0, 1) }}°C</td>
                                
                                <td>
                                    @if(($log->nilai ?? 0) >= 25 && ($log->nilai ?? 0) <= 30)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                            Normal
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                            Bahaya
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">Belum ada data sensor yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT REAL-TIME UPDATE (AJAX) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        function updateDashboard() {
            // Memanggil Route API yang sudah kita buat
            fetch('{{ route("fish.status.realtime") }}')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // --- 1. UPDATE SUHU (Data Asli) ---
                    // Update Angka
                    document.getElementById('temp-val').innerText = data.temperature.value;
                    
                    // Update Badge Warna & Label
                    const tempBadge = document.getElementById('temp-badge');
                    // Reset class lama, masukkan class baru dari Controller
                    tempBadge.className = `badge ${data.temperature.status_class} bg-opacity-10 px-3 py-2 rounded-pill`;
                    // Perbaiki text-class manual karena bg-opacity butuh text-color eksplisit
                    if(data.temperature.status_class === 'success') {
                        tempBadge.classList.add('text-success', 'bg-success');
                    } else {
                        tempBadge.classList.add('text-danger', 'bg-danger');
                    }
                    tempBadge.innerText = data.temperature.label;

                    // Update Progress Bar
                    document.getElementById('temp-bar').style.width = data.temperature.percent + '%';

                    // --- 2. UPDATE WAKTU TERAKHIR ---
                    if(data.last_updated) {
                        document.getElementById('last-updated').innerText = data.last_updated;
                    }

                    // --- 3. Update pH & Feed (Dummy - Tidak berubah banyak) ---
                    // Biarkan tetap 0 seperti settingan controller
                })
                .catch(error => console.error('Gagal mengambil data:', error));
        }

        // Jalankan update setiap 3 detik (3000 ms)
        setInterval(updateDashboard, 3000);
    });
</script>

@endsection