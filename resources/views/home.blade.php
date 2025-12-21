@extends('layouts.second')

@section('title', 'Kebun Kita - Tanaman di Kota')

@section('content')
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\File;

    // HERO IMAGE LOGIC
    $first = $latestPosts->first();

    if ($first && $first->category && $first->category->image) {
        $heroImage = Str::startsWith($first->category->image, 'http')
            ? $first->category->image
            : asset($first->category->image);

    } elseif ($first && $first->image && File::exists(public_path('storage/'.$first->image))) {
        $heroImage = asset('storage/'.$first->image);

    } else {
        $heroImage = 'https://picsum.photos/1200/500?random=99';
    }
@endphp

<main class="main" id="top">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-4">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('assets/img/logo-kebunkita.png') }}" height="60">
      </a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/posts">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="/categories">Category</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="pt-7 mt-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 py-6">
          <h1 class="fw-bold text-success">
            Kebun Kita, Tanaman di Kota
          </h1>
          <p class="text-secondary">
            Kami membahas tips & informasi berkebun di ruang terbatas.
          </p>
          <a href="/posts" class="btn btn-primary btn-lg">
            Baca Selengkapnya
          </a>
        </div>

        <div class="col-md-6 text-center">
          <img
            src="{{ $heroImage }}"
            class="img-fluid rounded-3 shadow-sm"
            style="max-height:320px; object-fit:cover;"
          >
        </div>
      </div>
    </div>
  </section>

  <!-- ARTIKEL TERBARU -->
  <section class="pt-5 pb-7">
    <div class="container">
      <div class="text-center mb-5">
        <h3 class="fw-bold text-success">
          Artikel Terbaru
        </h3>
      </div>

      @if($latestPosts->count())
        <div class="row g-4">
          @foreach($latestPosts as $post)

            @php
              // CARD IMAGE LOGIC (ANTI BROKEN)
              if ($post->image && File::exists(public_path('storage/'.$post->image))) {
                  $postImage = asset('storage/'.$post->image);
              } else {
                  $postImage = 'https://picsum.photos/500/300?random='.$post->id;
              }
            @endphp

            <div class="col-md-4">
              <a href="/posts/{{ $post->slug }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0">
                  <img
                    src="{{ $postImage }}"
                    class="card-img-top"
                    style="height:200px; object-fit:cover"
                    alt="{{ $post->title }}"
                  >

                  <div class="card-body">
                    <h5 class="fw-bold text-secondary">
                      {{ $post->title }}
                    </h5>
                    <span class="btn btn-sm btn-outline-primary rounded-pill mt-2">
                      Baca Selengkapnya
                    </span>
                  </div>
                </div>
              </a>
            </div>

          @endforeach
        </div>
      @else
        <p class="text-center text-muted">
          Belum ada artikel.
        </p>
      @endif
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
