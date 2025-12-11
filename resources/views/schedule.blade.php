@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Kolom Kiri: Form Tambah Jadwal --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3">
                            <i class="bi bi-alarm-fill fs-4"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">Tambah Jadwal</h5>
                    </div>
                    
                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase">Pilih Waktu</label>
                            <input type="time" name="feeding_time" class="form-control form-control-lg border-2 bg-light text-center fw-bold fs-2" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">
                            <i class="bi bi-plus-lg me-2"></i> Simpan Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Jadwal --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">Daftar Jadwal Pakan Otomatis</h5>
                    
                    @if($schedules->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 mb-3 d-block opacity-50"></i>
                            <p>Belum ada jadwal yang diatur.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="border-0 py-3 ps-4 rounded-start">Waktu</th>
                                        <th class="border-0 py-3">Status</th>
                                        <th class="border-0 py-3 text-end pe-4 rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td class="ps-4">
                                                <h4 class="mb-0 fw-bold text-dark font-monospace">
                                                    {{ \Carbon\Carbon::parse($schedule->feeding_time)->format('H:i') }}
                                                </h4>
                                            </td>
                                            <td>
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-light text-danger btn-sm p-2 rounded-circle hover-danger" title="Hapus">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection