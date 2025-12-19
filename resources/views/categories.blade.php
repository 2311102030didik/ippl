@extends('layouts.main')

@section('container')
<div class="container mt-5 pt-4">
  <h1 class="mb-5 text-center fw-bold" style="font-family: 'Poppins', sans-serif; color: #2d3748;">
    Post Categories
  </h1>

  <div class="row g-4">
    @foreach ($categories as $category)
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <a href="/posts?category={{ $category->slug }}" class="text-decoration-none d-block h-100">
          <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 category-card d-flex flex-column align-items-center p-3" style="min-height: 280px;">

            {{-- Gambar kategori --}}
            <div class="category-image-wrapper d-flex align-items-center justify-content-center w-100">
              <img 
                src="{{ $category->image ? asset($category->image) : 'https://via.placeholder.com/400x280/4a5568/FFFFFF?text=' . urlencode(ucfirst($category->name)) }}" 
                class="category-img"
                alt="{{ $category->name }}">
            </div>

            {{-- Caption --}}
            <div class="category-caption w-100 text-center mt-3">
              <h5 class="mb-1 fw-semibold text-dark" style="letter-spacing: .2px">{{ ucfirst($category->name) }}</h5>
              {{-- small subtitle placeholder if needed --}}
              {{-- <p class="text-muted small mb-0">{{ $category->posts_count ?? '' }}</p> --}}
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>

<style>
  /* New category card styling for better UI/UX */
  .category-image-wrapper {
    height: 160px;
    padding: 8px 12px;
    overflow: hidden;
  }

  .category-img {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 12px;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    box-shadow: 0 8px 18px rgba(15,23,42,0.06);
    background: #fff;
  }

  .category-card:hover .category-img {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 18px 36px rgba(15,23,42,0.10);
  }

  .category-caption h5 {
    font-size: 1.05rem;
  }

  .category-card {
    transition: transform 0.28s ease, box-shadow 0.28s ease;
  }

  .category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 36px rgba(15,23,42,0.06);
    z-index: 2;
  }

  /* Responsive tweaks */
  @media (max-width: 576px) {
    .category-img { width: 110px; height: 110px; }
    .category-image-wrapper { height: 130px; }
  }

  body {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }
</style>
@endsection