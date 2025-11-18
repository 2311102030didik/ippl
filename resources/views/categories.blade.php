@extends('layouts.main')

@section('container')
  <div class="container mt-5 pt-5">
    <h1 class="mb-5 text-center">Post Categories</h1>

    <div class="row">
      @foreach ($categories as $category)
        <div class="col-md-4 mb-4">
          <a href="/posts?category={{ $category->slug }}" class="text-decoration-none text-white">
            <div class="card bg-dark text-white border-0 shadow-sm">
              {{-- 🖼️ Gambar kategori --}}
              <img 
                  src="{{ asset($category->image ?? 'img/category/default.jpg') }}" 
                  class="card-img" 
                  alt="{{ $category->name }}" 
                  style="height: 250px; object-fit: cover;">

              {{-- 🏷️ Overlay Nama Kategori --}}
              <div class="card-img-overlay d-flex align-items-center justify-content-center p-0">
                <h5 class="card-title text-center flex-fill p-3 fs-4 fw-bold" 
                    style="background-color: rgba(0, 0, 0, 0.6);">
                  {{ ucfirst($category->name) }}
                </h5>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
@endsection
