@extends('layouts.main')

@section('container')
<div class="container mt-5 pt-4">
  <h1 class="mb-5 text-center fw-bold" style="font-family: 'Poppins', sans-serif; color: #2d3748;">
    Post Categories
  </h1>

  <div class="row g-4">
    @foreach ($categories as $category)
      <div class="col-md-4 col-sm-6 col-12">
        <a href="/posts?category={{ $category->slug }}" class="text-decoration-none text-white d-block h-100">
          <div class="card bg-dark text-white border-0 rounded-4 shadow-sm overflow-hidden h-100 category-card"
               style="transition: transform 0.3s ease, box-shadow 0.3s ease; height: 280px;">
            
            {{-- Gambar kategori dengan fallback yang estetis --}}
            <img 
              src="{{ $category->image ? asset($category->image) : 'https://via.placeholder.com/400x280/4a5568/FFFFFF?text=' . urlencode(ucfirst($category->name)) }}" 
              class="card-img w-100" 
              alt="{{ $category->name }}" 
              style="height: 100%; object-fit: cover; transition: transform 0.5s ease;">

            {{-- Overlay nama kategori --}}
            <div class="card-img-overlay d-flex align-items-end p-0">
              <div class="w-100 p-3 bg-gradient-dark text-center">
                <h5 class="card-title mb-0 fs-5 fw-bold text-white">
                  {{ ucfirst($category->name) }}
                </h5>
              </div>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>

<style>
  .bg-gradient-dark {
    background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
    backdrop-filter: blur(2px);
  }

  .category-card:hover .card-img {
    transform: scale(1.05);
  }

  .category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    z-index: 2;
  }

  body {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
  }
</style>
@endsection