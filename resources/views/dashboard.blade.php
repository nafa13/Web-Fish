@extends('layouts.app')

@section('content')
    {{-- Custom CSS untuk Efek Hover Kartu --}}
    <style>
        .hover-card {
            transition: all 0.3s ease;
            border: none;
        }
        .hover-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
        .icon-bg {
            opacity: 0.15;
            font-size: 5rem;
            transform: rotate(-15deg);
        }
    </style>

    {{-- Alert Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0 rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header Selamat Datang --}}
    <div class="card border-0 mb-5 rounded-4 overflow-hidden text-white shadow-lg" 
         style="background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);">
        <div class="card-body p-5 d-flex align-items-center justify-content-between position-relative">
            <div style="z-index: 2;">
                <h2 class="fw-bold mb-1">Halo, {{ auth()->user()->name }}! 🐟</h2>
                <p class="mb-0 opacity-75">Selamat datang di Panel Kontrol Pemberi Makan Ikan Pintar.</p>
            </div>
            <div class="d-none d-md-block" style="z-index: 2;">
                <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-wifi me-1"></i> Device Online
                </span>
            </div>
            {{-- Dekorasi Background --}}
            <i class="bi bi-water position-absolute end-0 bottom-0 text-white" style="font-size: 10rem; opacity: 0.1; margin-right: -20px; margin-bottom: -30px;"></i>
        </div>
    </div>

    {{-- Grid Statistik & Kontrol --}}
    <div class="row g-4">
        
        {{-- Card 1: Total Feeding (Warna Aksen: Hijau Mint) --}}
        <div class="col-md-4">
            <div class="card h-100 hover-card rounded-4 position-relative overflow-hidden" style="background: #f0fdf4;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-success fw-bold text-uppercase mb-1">Total Pakan Hari Ini</h6>
                            <h2 class="display-4 fw-bold text-dark mb-0">{{ $totalFeedingToday ?? 0 }}</h2>
                            <small class="text-muted">Kali pemberian</small>
                        </div>
                        <div class="icon-circle bg-success bg-opacity-25 p-3 rounded-circle text-success">
                            <i class="bi bi-bucket-fill fs-4"></i>
                        </div>
                    </div>
                    {{-- Ikon Besar Transparan --}}
                    <div class="position-absolute end-0 bottom-0 p-3 icon-bg text-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Next Schedule (Warna Aksen: Kuning/Oranye) --}}
        <div class="col-md-4">
            <div class="card h-100 hover-card rounded-4 position-relative overflow-hidden" style="background: #fffbeb;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-warning fw-bold text-uppercase mb-1">Jadwal Berikutnya</h6>
                            <h2 class="display-4 fw-bold text-dark mb-0">{{ $nextSchedule ?? '--:--' }}</h2>
                            <small class="text-muted">Waktu pakan otomatis</small>
                        </div>
                        <div class="icon-circle bg-warning bg-opacity-25 p-3 rounded-circle text-warning">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                    </div>
                    <div class="position-absolute end-0 bottom-0 p-3 icon-bg text-warning">
                        <i class="bi bi-stopwatch"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Manual Control (Warna Aksen: Biru Utama) --}}
        <div class="col-md-4">
            <div class="card h-100 hover-card rounded-4 border-0 shadow-sm">
                <div class="card-body p-4 d-flex flex-column justify-content-center text-center">
                    <h5 class="fw-bold mb-3 text-primary">Kontrol Manual</h5>
                    <p class="text-muted small mb-4">Tekan tombol di bawah untuk memberi makan ikan saat ini juga.</p>
                    
                    <form action="{{ route('feed.now') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg py-3 position-relative overflow-hidden group">
                            <span class="position-relative z-1"><i class="bi bi-send-fill me-2"></i> BERI MAKAN SEKARANG</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Kecil (Opsional) --}}
    <div class="text-center mt-5 text-muted small opacity-50">
        &copy; {{ date('Y') }} Smart Fish Feeder System
    </div>
@endsection