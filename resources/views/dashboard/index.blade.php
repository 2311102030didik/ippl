@extends('dashboard.layouts.main')

@section('container')
<div class="row g-4">
    {{-- WELCOME CARD (atas) --}}
    <div class="col-12 mb-4">
        <div class="card p-3 shadow-sm border-0">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-grow-1">
                    {{-- HALO NAMA USER --}}
                    <h4 class="mb-1 fw-bold text-primary">
                        Selamat datang kembali,
                        <span class="text-dark">{{ $user->name }}</span>!
                    </h4>

                    {{-- WAKTU LOGIN TERAKHIR --}}
                    <div class="small text-muted">
                        <i class="bi bi-clock-history me-1"></i>
                        Masuk terakhir:
                        {{ $lastLogin ? $lastLogin->isoFormat('D MMM YYYY, HH:mm') : 'Belum pernah' }}
                    </div>
                </div>

                {{-- QUICK ACTION BUTTON --}}
                <a href="/dashboard/posts" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-journal-text me-1"></i>
                    Kelola Post
                </a>
            </div>
        </div>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-4">
        {{-- 1. TOTAL POST USER --}}
        <div class="col-md-4">
            <div class="card h-100 p-4 text-center shadow-sm border-0 hover-shadow">
                <div class="text-muted small mb-2">Post Kamu</div>
                <div class="fs-2 fw-bold text-primary mb-1">{{ $totalPosts }}</div>
                <a href="/dashboard/posts" class="text-decoration-none small text-primary">
                    Kelola post <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        {{-- 2. TOTAL KATEGORI --}}
        <div class="col-md-4">
            <div class="card h-100 p-4 text-center shadow-sm border-0 hover-shadow">
                <div class="text-muted small mb-2">Kategori Tersedia</div>
                <div class="fs-2 fw-bold text-success mb-1">{{ $totalCategories }}</div>
                <small class="text-muted">Total kategori sistem</small>
            </div>
        </div>

        {{-- 3. INFO AKUN --}}
        <div class="col-md-4">
            <div class="card h-100 p-4 text-center shadow-sm border-0 hover-shadow">
                <div class="text-muted small mb-2">Username</div>
                <div class="fs-2 fw-bold text-info mb-1">{{ $user->username }}</div>
                <div class="text-muted small">
                    {{ $user->email }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS HOVER EFFECT --}}
<style>
.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    transition: all 0.2s ease;
}
.card {
    transition: all 0.2s ease;
}
</style>
@endsection
