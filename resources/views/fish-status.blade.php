@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    {{-- Baris Kartu Status Utama --}}
    <div class="row g-4 mb-4">
        
        {{-- Kartu 1: Suhu Air --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 position-relative">
                    <h6 class="text-muted fw-bold text-uppercase mb-3">Suhu Air</h6>
                    <div class="d-flex align-items-center">
                        <h1 class="display-4 fw-bold mb-0 text-dark me-2">{{ number_format($latest->temperature, 1) }}°C</h1>
                        {{-- Logika Warna Badge: Ideal 25-30 derajat --}}
                        @php
                            $tempStatus = ($latest->temperature >= 25 && $latest->temperature <= 30) ? 'success' : 'danger';
                            $tempLabel = ($latest->temperature >= 25 && $latest->temperature <= 30) ? 'Normal' : 'Bahaya';
                        @endphp
                        <span class="badge bg-{{ $tempStatus }} bg-opacity-10 text-{{ $tempStatus }} px-3 py-2 rounded-pill">
                            {{ $tempLabel }}
                        </span>
                    </div>
                    <small class="text-muted mt-2 d-block">Ideal: 25°C - 30°C</small>
                    
                    {{-- Ikon Background --}}
                    <i class="bi bi-thermometer-half position-absolute text-danger opacity-25" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
                </div>
                {{-- Progress Bar Visual --}}
                <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($latest->temperature / 50) * 100 }}%"></div>
                </div>
            </div>
        </div>

        {{-- Kartu 2: pH Air --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 position-relative">
                    <h6 class="text-muted fw-bold text-uppercase mb-3">pH Air (Keasaman)</h6>
                    <div class="d-flex align-items-center">
                        <h1 class="display-4 fw-bold mb-0 text-dark me-2">{{ number_format($latest->ph_level, 1) }}</h1>
                        @php
                            $phStatus = ($latest->ph_level >= 6.5 && $latest->ph_level <= 8.5) ? 'success' : 'warning';
                            $phLabel = ($latest->ph_level >= 6.5 && $latest->ph_level <= 8.5) ? 'Normal' : 'Perhatian';
                        @endphp
                        <span class="badge bg-{{ $phStatus }} bg-opacity-10 text-{{ $phStatus }} px-3 py-2 rounded-pill">
                            {{ $phLabel }}
                        </span>
                    </div>
                    <small class="text-muted mt-2 d-block">Ideal: 6.5 - 8.5</small>
                    
                    <i class="bi bi-droplet-half position-absolute text-info opacity-25" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
                </div>
                <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ ($latest->ph_level / 14) * 100 }}%"></div>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Sisa Pakan --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 position-relative">
                    <h6 class="text-muted fw-bold text-uppercase mb-3">Level Pakan</h6>
                    <div class="d-flex align-items-center">
                        <h1 class="display-4 fw-bold mb-0 text-dark me-2">{{ $latest->feed_level }}%</h1>
                        @php
                            $feedColor = $latest->feed_level > 20 ? 'success' : 'danger';
                            $feedLabel = $latest->feed_level > 20 ? 'Cukup' : 'Hampir Habis';
                        @endphp
                        <span class="badge bg-{{ $feedColor }} bg-opacity-10 text-{{ $feedColor }} px-3 py-2 rounded-pill">
                            {{ $feedLabel }}
                        </span>
                    </div>
                    <small class="text-muted mt-2 d-block">Kapasitas Tabung</small>
                    
                    <i class="bi bi-bucket position-absolute text-success opacity-25" style="font-size: 6rem; right: -20px; bottom: -20px;"></i>
                </div>
                <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $latest->feed_level }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Sensor --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">Riwayat Pemantauan Kualitas Air</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Waktu</th>
                            <th>Suhu (°C)</th>
                            <th>pH</th>
                            <th>Kekeruhan (NTU)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $log)
                            <tr>
                                <td class="ps-4 text-muted fw-medium">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                <td class="fw-bold">{{ $log->temperature }}°C</td>
                                <td>{{ $log->ph_level }}</td>
                                <td>{{ $log->turbidity }}</td>
                                <td>
                                    {{-- Logika Status Keseluruhan Baris --}}
                                    @if($log->temperature >= 25 && $log->temperature <= 30 && $log->ph_level >= 6.5 && $log->ph_level <= 8.5)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Bagus
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Buruk
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada data sensor yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection