@extends('layouts.second')

@section('title', 'Kebun Kita - Tanaman di Kota')

@section('content')
<main class="main" id="top">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-4" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('assets/img/logo-kebunkita.png') }}" height="60" alt="logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto align-items-lg-center align-items-start">
          <li class="nav-item px-3"><a class="nav-link fw-medium" href="/">Home</a></li>
          <li class="nav-item px-3"><a class="nav-link fw-medium" href="/posts">Blog</a></li>
          <li class="nav-item px-3"><a class="nav-link fw-medium" href="/categories">Category</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="pt-7 mt-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-md-start text-center py-6">
          <h1 class="hero-title mb-3 fw-bold text-success">Kebun Kita, Tanaman di Kota</h1>
          <p class="mb-4 fw-medium text-secondary">
            Kami membahas berbagai tips dan informasi seputar tanaman dalam kota.
            Melalui artikel dan panduan praktis, Kebun Kita menginspirasi masyarakat
            untuk berkebun di ruang terbatas dan menciptakan lingkungan yang lebih hijau.
          </p>
          <a class="btn btn-primary btn-lg border-0 primary-btn-shadow" href="/posts" role="button">
            Baca Selengkapnya
          </a>
        </div>
        <div class="col-md-6 text-center">
          <img class="img-fluid rounded-3 shadow-sm" src="{{ asset('assets/img/logo-hero.png') }}" alt="Tanaman Perkotaan">
        </div>
      </div>
    </div>
  </section>

  <!-- Artikel Terpopuler -->
  <section class="pt-5 pb-7" id="destination">
    <div class="container">
      <div class="text-center mb-5">
        <h3 class="fs-2 fw-bold text-success font-cursive">Artikel Terpopuler</h3>
      </div>
      <div class="row">
        @if($latestPosts->count())
  <div class="row g-4">
    @foreach($latestPosts as $post)
      <div class="col-md-4">
        <a href="/posts/{{ $post->slug }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm border-0">
            <img src="{{ $post->image
                ? asset('storage/'.$post->image)
                : 'https://picsum.photos/500/300' }}"
                class="card-img-top"
                style="height:200px; object-fit:cover">

            <div class="card-body">
              <h5 class="fw-bold">{{ $post->title }}</h5>
              <span class="btn btn-sm btn-outline-primary rounded-pill">
                Baca Selengkapnya
              </span>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
@endif

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="site-footer home-footer">
    <div class="container">
      <div class="row gy-4">
        <div class="col-md-6 col-lg-4">
          <div class="footer-brand">
            <img src="{{ asset('assets/img/logo-kebunkita.png') }}" alt="Kebun Kita">
            <div>
              <div class="text-white fw-bold h5 mb-0">Kebun Kita</div>
              <div class="text-white-50 small">Membawa kebun ke ruang kota Anda</div>
            </div>
          </div>
          <p class="mt-3 text-white-50">Kebun Kita menyediakan artikel, tips, dan tutorial singkat untuk berkebun di ruang terbatas dari hidroponik sampai kompos organik.</p>
        </div>

        <div class="col-6 col-md-3 col-lg-2 footer-links">
          <h5 class="mb-3">Blog</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="/posts">Artikel Terbaru</a></li>
            <li class="mb-2"><a href="/categories">Kategori</a></li>
            <li class="mb-2"><a href="/about">Tentang</a></li>
          </ul>
        </div>

        <div class="col-6 col-md-3 col-lg-2 footer-links">
          <h5 class="mb-3">Dukungan</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="/privacy">Kebijakan Privasi</a></li>
            <li class="mb-2"><a href="/terms">Syarat & Ketentuan</a></li>
          </ul>
        </div>

        <div class="col-md-12 col-lg-4">
          <h5 class="text-white mb-3">Ikuti kami</h5>
          <div class="social-icons mb-3">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          </div>

          <div class="footer-bottom d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div class="small text-white-50">© {{ date('Y') }} Kebun Kita — All rights reserved.</div>
            <div class="small text-white-50 mt-2 mt-sm-0">Made with ♥ for plant lovers</div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</main>
@endsection
