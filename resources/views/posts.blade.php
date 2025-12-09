@extends('layouts.main')

@php
    use Illuminate\Support\Str;
@endphp

@section('container')
@php
    if (isset($title) && $title === 'All Posts') {
        $title = 'Semua Artikel';
    }
@endphp

<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold" style="font-family: 'Poppins', sans-serif; color: #2d3748;">
        {{ $title }}
    </h2>

    <!-- Pencarian -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <form action="/posts" method="GET">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="input-group">
                    <input 
                        type="text" 
                        class="form-control rounded-start-pill" 
                        placeholder="Cari artikel..." 
                        name="search" 
                        value="{{ request('search') }}"
                    >
                    <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($posts->count())
        <!-- Hero Post (Post Pertama) -->
        @php
            $first = $posts[0];
            // Jika sedang memfilter berdasarkan kategori dan kategori punya gambar,
            // gunakan gambar kategori sebagai hero agar tampilan sinkron.
            if (isset($category) && $category && $category->image) {
                $heroImage = Str::startsWith($category->image, 'http')
                    ? $category->image
                    : asset($category->image);
            } elseif ($first->image) {
                $heroImage = Str::startsWith($first->image, 'http')
                    ? $first->image
                    : asset('storage/' . $first->image);
            } else {
                $heroImage = 'https://picsum.photos/1200/500?random=' . rand(1, 1000);
            }
        @endphp

        <div class="card rounded-4 shadow-lg mb-5 overflow-hidden border-0">
            <div class="position-relative">
                <img 
                    src="{{ $heroImage }}" 
                    alt="{{ $first->title }}" 
                    class="w-100" 
                    style="height: 320px; object-fit: cover;"
                >
                <div class="position-absolute top-0 start-0 bg-primary px-3 py-1">
                    <a href="/posts?category={{ $first->category->slug }}" class="text-white text-decoration-none fw-semibold">
                        {{ $first->category->name }}
                    </a>
                </div>
            </div>
            <div class="card-body text-center p-4">
                <h3 class="card-title fw-bold h4 mb-3">
                    <a href="/posts/{{ $first->slug }}" class="text-dark text-decoration-none">
                        {{ $first->title }}
                    </a>
                </h3>
                <a href="/posts/{{ $first->slug }}" class="btn btn-primary px-4 py-2 rounded-pill fw-medium">
                    Baca Selengkapnya
                </a>
            </div>
        </div>

        <!-- Daftar Postingan Lainnya -->
        <div class="row g-4">
            @foreach($posts->skip(1) as $post)
                @php
                    $img = $post->image 
                        ? (Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image))
                        : 'https://picsum.photos/500/350?random=' . rand(1, 1000);
                @endphp

                <div class="col-md-4 col-sm-6 col-12">
                    <a href="/posts/{{ $post->slug }}" class="text-decoration-none h-100">
                        <div class="card rounded-4 border-0 shadow-sm h-100 post-card"
                             style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <div class="position-relative">
                                <img 
                                    src="{{ $img }}" 
                                    alt="{{ $post->title }}" 
                                    class="card-img-top" 
                                    style="height: 200px; object-fit: cover;"
                                >
                                <div class="position-absolute top-0 start-0 bg-primary px-2 py-1 rounded-bottom-end">
                                    <span class="text-white fw-semibold small">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2">{{ $post->title }}</h5>
                                <div class="mt-auto">
                                    <span class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        Baca Selengkapnya
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    @else
        <div class="text-center py-5">
            <p class="fs-4 text-muted">Tidak ada postingan ditemukan.</p>
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>

<style>
    .post-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }
    .card-img-top {
        transition: transform 0.4s ease;
    }
    .post-card:hover .card-img-top {
        transform: scale(1.03);
    }
    body {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
</style>
@endsection