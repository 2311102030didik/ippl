@extends('layouts.main')

@section('container')
<style>
  body {
    background-color: #7dc47d; /* Ubah ke hijau penuh */
    font-family: 'Poppins', sans-serif;
  }

  .login-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 2rem 0;
  }

  .login-container {
    display: flex;
    background: #fff;
    width: 850px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.25);
  }

  .login-left {
    flex: 1;
    background: url('/assets/img/logo-bg.jpeg') center/cover no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }

  .login-left::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.3);
  }

  .login-left img {
    position: relative;
    z-index: 1;
    width: 180px;
  }

  .login-right {
    flex: 1;
    padding: 3rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .login-right h2 {
    font-weight: 700;
    margin-bottom: 10px;
  }

  .login-right p {
    color: #555;
    margin-bottom: 25px;
  }

  .form-control {
    border-radius: 6px;
    margin-bottom: 1rem;
  }

  .btn-login {
    background-color: #5cb85c;
    border: none;
    color: white;
    padding: 0.75rem;
    border-radius: 6px;
    font-weight: 500;
  }

  .btn-login:hover {
    background-color: #4cae4c;
  }

  .footer {
    background-color: #7dc47d;
    padding: 1.5rem;
    color: white;
    text-align: center;
    border-top: 2px solid #6bb36a;
  }

  .footer a {
    color: #fff;
    margin: 0 10px;
  }

  .footer h5 {
    font-weight: 600;
  }
</style>

<div class="login-wrapper">
  <div class="login-container">

    {{-- LEFT SIDE --}}
    <div class="login-left">
      <img src="/assets/img/logo-kebunkita.png" alt="Kebun Kita Logo">
    </div>

    {{-- RIGHT SIDE --}}
    <div class="login-right">
      <h2>Sign In</h2>
      <p>Akses Secara Gratis Komunitas Kami</p>

      @if(session()->has('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if(session()->has('LoginError'))
      <div class="alert alert-danger">{{ session('LoginError') }}</div>
      @endif

      <form action="/login" method="post">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" id="email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Masukkan Email Anda" value="{{ old('email') }}" required>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
          <div class="text-end mt-1">
            <a href="#" class="text-muted small">Lupa password?</a>
          </div>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" class="form-check-input" id="remember">
          <label for="remember" class="form-check-label">Ingat saya</label>
        </div>

        <button type="submit" class="btn-login w-100">Masuk</button>
      </form>
    </div>
  </div>
</div>

{{-- FOOTER --}}
<div class="footer mt-2">
  <p>Ikutlah <strong>Berpartisipasi</strong></p>
  <div>
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
  </div>
  <div class="mt-3">
    <h5>Content Footer</h5>
    <p>Link here | Link here | Link here</p>
  </div>
</div>
@endsection
