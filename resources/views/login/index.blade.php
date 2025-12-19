@extends('layouts.main')

@section('container')

{{-- Clean, responsive login form matching site style --}}
<div class="row justify-content-center align-items-center min-vh-75 py-5">
  <div class="col-lg-8">
    <div class="card shadow-sm overflow-hidden border-0">
      <div class="row g-0">
        <div class="col-md-5 d-none d-md-flex bg-image align-items-center justify-content-center" style="background-image:url('/assets/img/logo-bg.jpeg'); background-size:cover; background-position:center;">
          <div class="text-center p-4 text-white" style="background:linear-gradient(180deg, rgba(0,0,0,0.3), rgba(0,0,0,0.45)); width:100%; height:100%; display:flex; align-items:center; justify-content:center; flex-direction:column;">
            <img src="/assets/img/logo-kebunkita.png" alt="Kebun Kita" class="img-fluid mb-3" style="width:150px; max-width:40%">
            <h3 class="mb-0 fw-bold">Kebun Kita</h3>
            <small>Komunitas berkebun bersama</small>
          </div>
        </div>

        <div class="col-md-7 p-4">
          <div class="p-3 p-md-4">
            <h2 class="fw-bold mb-1">Masuk ke akun Anda</h2>
            <p class="text-muted mb-3">Masuk untuk mengelola posting dan berpartisipasi di komunitas.</p>

            @if(session()->has('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session()->has('LoginError'))
              <div class="alert alert-danger">{{ session('LoginError') }}</div>
            @endif

            <form action="/login" method="post" class="needs-validation" novalidate>
              @csrf

              <div class="mb-3">
                <label for="login" class="form-label">Email atau Username</label>
                <input type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" placeholder="email@domain.com atau username" value="{{ old('login') }}" required autofocus aria-describedby="loginHelp">
                @if($errors->has('login'))
                  <div class="invalid-feedback">{{ $errors->first('login') }}</div>
                @else
                  <div class="form-text text-muted" id="loginHelp">Masukkan email atau username Anda</div>
                @endif
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="d-flex justify-content-end mt-2"><a href="#" class="small text-muted">Lupa kata sandi?</a></div>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya</label>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
            </form>

            <div class="text-center mt-3">
              <small class="text-muted">Belum punya akun? <a href="/register" class="text-decoration-none">Daftar</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
