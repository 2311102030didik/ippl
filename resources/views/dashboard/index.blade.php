@extends('dashboard.layouts.main')

@section('container')
  <div class="row g-4">
    <div class="col-12 mb-4">
      <div class="card p-3 shadow-sm">
        <div class="d-flex align-items-center gap-3">
          <div>
            <h4 class="mb-1">Selamat datang kembali, <span class="fw-semibold">{{ $user->name }}</span></h4>
            <div class="small text-muted mt-1">Masuk terakhir: {{ $lastLogin ? \Carbon\Carbon::parse($lastLogin)->isoFormat('D MMM YYYY, HH:mm') : '—' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 text-center shadow-sm">
        <div class="text-muted small mb-1">Total Post</div>
        <div class="fs-3 fw-bold">{{ $totalPosts }}</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 text-center shadow-sm">
        <div class="text-muted small mb-1">Kategori</div>
        <div class="fs-3 fw-bold">{{ $totalCategories }}</div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3 text-center shadow-sm">
        <div class="text-muted small mb-1">Akun</div>
        <div class="fs-3 fw-bold">{{ $user->username }}</div>
      </div>
    </div>
  </div>
@endsection