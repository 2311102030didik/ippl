@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-center align-items-center min-vh-100 py-5 bg-light">
  <div class="col-lg-4 col-md-6 col-11">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

      <div class="card-body p-4 p-sm-5">

        <div class="text-center mb-4">
          <h1 class="fw-bold text-dark" style="font-size: 1.6rem;">Buat Akun Baru</h1>
          <p class="text-muted small">Isi data di bawah untuk membuat akun</p>
        </div>

        <form action="/register" method="POST" id="registerForm">
          @csrf

          {{-- Nama Lengkap --}}
          <div class="form-floating mb-3 modern-input">
            <input 
              type="text"
              class="form-control @error('name') is-invalid @enderror"
              name="name"
              id="name"
              placeholder=" "
              value="{{ old('name') }}"
              required>
            <label for="name">Nama Lengkap</label>
            @error('name') 
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Username --}}
          <div class="form-floating mb-3 modern-input">
            <input 
              type="text"
              class="form-control @error('username') is-invalid @enderror"
              name="username"
              id="username"
              placeholder=" "
              value="{{ old('username') }}"
              required>
            <label for="username">Username</label>
            @error('username') 
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Email --}}
          <div class="form-floating mb-3 modern-input">
            <input 
              type="email"
              class="form-control @error('email') is-invalid @enderror"
              name="email"
              id="email"
              placeholder=" "
              value="{{ old('email') }}"
              required>
            <label for="email">Alamat Email</label>
            @error('email') 
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Password --}}
          <div class="form-floating mb-4 modern-input">
            <input 
              type="password"
              class="form-control @error('password') is-invalid @enderror"
              name="password"
              id="password"
              placeholder=" "
              required>
            <label for="password">Kata Sandi</label>
            @error('password') 
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Tombol Daftar --}}
          <button 
            type="submit"
            id="registerButton"
            class="btn btn-success w-100 py-2 rounded-3 fw-semibold shadow-sm submit-btn">
            Daftar
          </button>

        </form>

        <div class="text-center mt-4">
          <small class="text-muted">Sudah punya akun?
            <a href="/login" class="text-decoration-none fw-medium text-success">
              Masuk di sini
            </a>
          </small>
        </div>

      </div>

    </div>
  </div>
</div>

<style>
  /* Efek modern pada input */
  .modern-input .form-control {
    border-radius: 12px;
    border: 1.5px solid #ddd;
    transition: all 0.25s ease-in-out;
    padding-left: 1rem !important;
  }

  .modern-input .form-control:focus {
    border-color: #198754 !important;
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
  }

  /* Button modern */
  .submit-btn {
    font-size: 1.05rem;
    transition: 0.2s;
  }

  .submit-btn:hover {
    background-color: #157347;
    transform: translateY(-1px);
  }
</style>

<script>
  // Disable button on submit
  document.getElementById('registerForm').addEventListener('submit', function () {
    const btn = document.getElementById('registerButton');
    btn.disabled = true;
    btn.innerHTML =
      '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
  });
</script>

@endsection
