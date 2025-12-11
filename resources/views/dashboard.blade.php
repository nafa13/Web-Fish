@extends('layouts.app')

@section('content')
    {{-- 1. Tambahkan Alert untuk menampilkan pesan sukses setelah memberi pakan --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="alert mb-5 text-white border-0 d-flex align-items-center" 
         style="background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%); border-left: 5px solid #3b82f6;">
        <i class="bi bi-emoji-smile fs-3 me-3 text-primary"></i>
        <div>
            Welcome back, <strong class="text-primary">{{ auth()->user()->name }}</strong>! 
            <span class="d-block text-muted small">System is running smoothly.</span>
        </div>
    </div>

    <div class="row g-4">
        {{-- Card 1: Total Feeding --}}
        <div class="col-md-4">
            <div class="card p-4 h-100 position-relative overflow-hidden">
                <div class="position-absolute end-0 top-0 p-3 opacity-25">
                    <i class="bi bi-calendar-check fs-1 text-primary"></i>
                </div>
                <h5>Total Feeding</h5>
                {{-- Perbaikan: Variabel dinamis diletakkan di sini --}}
                <h2 class="mt-2 mb-0 display-5 fw-bold">
                    {{ $totalFeedingToday ?? 0 }} <span class="fs-6 text-muted">Times</span>
                </h2>
                <small class="text-success mt-3 d-block"><i class="bi bi-arrow-up"></i> Today's activity</small>
            </div>
        </div>

        {{-- Card 2: Next Schedule --}}
        <div class="col-md-4">
            <div class="card p-4 h-100 position-relative overflow-hidden">
                <div class="position-absolute end-0 top-0 p-3 opacity-25">
                    <i class="bi bi-stopwatch fs-1 text-warning"></i>
                </div>
                <h5>Next Schedule</h5>
                {{-- Gunakan variabel jika ada, jika tidak gunakan default --}}
                <h2 class="mt-2 mb-0 display-5 fw-bold">{{ $nextSchedule ?? '14:00' }}</h2>
                <small class="text-warning mt-3 d-block"><i class="bi bi-clock"></i> Upcoming</small>
            </div>
        </div>

        {{-- Card 3: Manual Control --}}
        <div class="col-md-4">
            <div class="card p-4 h-100 text-center d-flex flex-column justify-content-center border-primary" 
                 style="background: rgba(59, 130, 246, 0.05);">
                <h5 class="text-primary mb-3">Manual Control</h5>
                
                {{-- Perbaikan: Tombol dibungkus form agar berfungsi --}}
                <form action="{{ route('feed.now') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-uppercase shadow-lg">
                        <i class="bi bi-play-circle-fill me-2"></i> Feed Now
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection