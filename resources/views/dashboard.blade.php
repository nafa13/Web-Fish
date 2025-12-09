@extends('layouts.app')

@section('content')
    <div class="alert mb-5 text-white border-0 d-flex align-items-center" 
         style="background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%); border-left: 5px solid #3b82f6;">
        <i class="bi bi-emoji-smile fs-3 me-3 text-primary"></i>
        <div>
            Welcome back, <strong class="text-primary">{{ auth()->user()->name }}</strong>! 
            <span class="d-block text-muted small">System is running smoothly.</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 h-100 position-relative overflow-hidden">
                <div class="position-absolute end-0 top-0 p-3 opacity-25">
                    <i class="bi bi-calendar-check fs-1 text-primary"></i>
                </div>
                <h5>Total Feeding</h5>
                <h2 class="mt-2 mb-0 display-5 fw-bold">12 <span class="fs-6 text-muted">Times</span></h2>
                <small class="text-success mt-3 d-block"><i class="bi bi-arrow-up"></i> Today's activity</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100 position-relative overflow-hidden">
                <div class="position-absolute end-0 top-0 p-3 opacity-25">
                    <i class="bi bi-stopwatch fs-1 text-warning"></i>
                </div>
                <h5>Next Schedule</h5>
                <h2 class="mt-2 mb-0 display-5 fw-bold">14:00</h2>
                <small class="text-warning mt-3 d-block"><i class="bi bi-clock"></i> Upcoming</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100 text-center d-flex flex-column justify-content-center border-primary" 
                 style="background: rgba(59, 130, 246, 0.05);">
                <h5 class="text-primary mb-3">Manual Control</h5>
                <button class="btn btn-primary w-100 py-3 fw-bold text-uppercase shadow-lg">
                    <i class="bi bi-play-circle-fill me-2"></i> Feed Now
                </button>
            </div>
        </div>
    </div>
@endsection