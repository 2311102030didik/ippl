<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kebun Kita - Tanaman di Kota</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="/pu">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="assets/css/theme.css" rel="stylesheet" />
  </head>

  <body>
    @extends('layouts.second')

    <main class="main" id="top">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-4" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container">
          <a class="navbar-brand" href="/">
            <img src="assets/img/logo-kebunkita.png" height="60" alt="logo" />
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
              <img class="img-fluid rounded-3 shadow-sm" src="assets/img/logo-hero.png" alt="Tanaman Perkotaan">
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
            <div class="col-md-4 mb-4">
              <div class="card shadow-sm border-0 h-100">
                <img class="card-img-top" src="assets/img/logo-bg.jpeg" alt="Tutorial hidroponik" />
                <div class="card-body">
                  <h5 class="fw-bold text-secondary">Tutorial Hidroponik</h5>
                  <p class="text-muted mb-0">Panduan sederhana untuk menanam sayuran segar di rumah dengan sistem hidroponik.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card shadow-sm border-0 h-100">
                <img class="card-img-top" src="assets/img/logo-bg.jpeg" alt="Tanaman hias" />
                <div class="card-body">
                  <h5 class="fw-bold text-secondary">Tanaman Hias untuk Ruang Sempit</h5>
                  <p class="text-muted mb-0">Ide tanaman yang cocok untuk apartemen atau ruang minimalis agar tetap asri.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card shadow-sm border-0 h-100">
                <img class="card-img-top" src="assets/img/logo-bg.jpeg" alt="Pupuk Kompos" />
                <div class="card-body">
                  <h5 class="fw-bold text-secondary">Membuat Pupuk Kompos Sendiri</h5>
                  <p class="text-muted mb-0">Langkah-langkah mudah membuat pupuk alami dari sisa dapur untuk tanaman Anda.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <section class="py-3" style="background-color: #6aa84f;">
        <div class="container">
            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4 mb-md-0">
                    <h2 class="text-white fs-4 fw-light mb-1">Ikutlah</h2>
                    <h3 class="text-warning fs-1 fw-bold">Berpartisipasi</h3>
                                        <hr class="border-2 border-white opacity-50 w-75 mt-3 mb-5" />
                </div>

                                <div class="col-6 col-md-3 col-lg-2 mb-4 mb-lg-0">
                    <h5 class="text-white mb-3 fw-bold">Content Footer</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="link-light text-decoration-none" href="#!">Link here</a></li>
                        <li class="mb-2"><a class="link-light text-decoration-none" href="#!">Link here</a></li>
                        <li class="mb-2"><a class="link-light text-decoration-none" href="#!">Link here</a></li>
                    </ul>
                </div>

                                <div class="col-6 col-md-3 col-lg-2">
                    <h5 class="text-white mb-3 fw-bold">Content Footer</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="link-light text-decoration-none" href="#!">Link here</a></li>
                        <li class="mb-2"><a class="link-light text-decoration-none" href="#!">Link here</a></li>
                        <li class="mb-2"><a class="link-light text-decoration-none" href="#!">Link here</a></li>
                    </ul>
                </div>
            </div>
        </div>
      </section>

           
    </main>

        <script src="vendors/@popperjs/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="assets/js/theme.js"></script>
  </body>
</html>