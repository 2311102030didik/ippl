<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" role="navigation" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="/" aria-label="Kebun Kita - Home">
      <img src="{{ asset('assets/img/logo-kebunkita.png') }}" height="48" alt="kebunkita logo" />
      <span class="brand-text ms-2">Kebun Kita</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto align-items-lg-center align-items-start gap-2">
        <li class="nav-item"><a class="nav-link fw-medium" href="/">Beranda</a></li>
        <li class="nav-item"><a class="nav-link fw-medium" href="/posts">Blog</a></li>
        <li class="nav-item"><a class="nav-link fw-medium" href="/categories">Categories</a></li>
        <!-- contact removed (not used) -->
      </ul>
    </div>
  </div>
</nav>
