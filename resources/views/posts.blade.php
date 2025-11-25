@extends('layouts.main')

@php
    // using fully-qualified Str to avoid naming collisions in blade templates
@endphp

@section('container')
    <h2 class="mb-3 text-dark text-center">{{ $title }}</h2>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="/posts">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search"
                           value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    @if ($posts->count())
        {{-- Featured post (only show title on listing) --}}
        @php
            $first = $posts[0];
            if ($first->image) {
                $imageUrl = \Illuminate\Support\Str::startsWith($first->image, 'http') ? $first->image : asset('storage/' . $first->image);
            } else {
                $imageUrl = 'https://picsum.photos/1200/400?random=' . rand(1, 1000);
            }
        @endphp

        <div class="card mb-3">
            <div class="post-hero aspect-banner">
                <img src="{{ $imageUrl }}" alt="{{ $first->title }}" class="img-fluid">
            </div>

            <div class="card-body text-center">
                <h5 class="card-title">
                    <a href="/posts/{{ $first->slug }}" class="text-decoration-none text-dark">{{ $first->title }}</a>
                </h5>
                <a href="/posts/{{ $first->slug }}" class="text-decoration-none btn btn-primary">Baca selengkapnya</a>
            </div>
        </div>

        {{-- Grid list (only title) --}}
        <div class="container">
            <div class="row">
                @foreach ($posts->skip(1) as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="position-absolute post-badge px-3 py-2">
                                <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none text-white">{{ $post->category->name }}</a>
                            </div>

                            @php
                                if ($post->image) {
                                    $imageUrl = \Illuminate\Support\Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image);
                                } else {
                                    $imageUrl = 'https://picsum.photos/500/400?random=' . rand(1, 1000);
                                }
                            @endphp

                            <div class="post-hero aspect-card">
                                <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="img-fluid">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Baca selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">Tidak ada postingan ditemukan.</p>
    @endif

    <div class="d-flex justify-content-end">
        {{ $posts->links() }}
    </div>
@endsection
@extends('layouts.main')

@php
    use Illuminate\Support\Str;
@endphp

@section('container')
    <h2 class="mb-3 text-dark text-center">{{ $title }}</h2>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="/posts">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                {{-- authorship hidden on listing (details available on post page) --}}
                } else {
                    // Jika tidak ada gambar → fallback ke Picsum
                    $imageUrl = 'https://picsum.photos/1200/400?random=' . rand(1, 1000);
                                {{-- authorship hidden on listing (details available on post page) --}}
                    </a>
                </h5>
                {{-- list page: tampilkan hanya judul & tombol baca selengkapnya --}}
                <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Baca selengkapnya</a>
            </div>
        </div>

        <div class="container">
            <div class="row">
                @foreach ($posts->skip(1) as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                               <div class="position-absolute post-badge px-3 py-2">
                                <a href="/posts?category={{ $post->category->slug }}"
                                   class="text-decoration-none text-white">
                                    {{ $post->category->name }}
                                </a>
                            </div>

                            @php
                                if ($post->image) {
                                    $imageUrl = Str::startsWith($post->image, 'http')
                                        ? $post->image
                                        : asset('storage/' . $post->image);
                                } else {
                                    $imageUrl = 'https://picsum.photos/500/400?random=' . rand(1, 1000);
                                }
                            @endphp

                            <div class="post-hero aspect-card">
                                <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="img-fluid">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                {{-- on list view we only show title; details available on post page --}}
                                <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Baca selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">Tidak ada postingan ditemukan.</p>
    @endif

    <div class="d-flex justify-content-end">
        {{ $posts->links() }}
    </div>
@endsection
