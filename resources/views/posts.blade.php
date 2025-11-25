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
                </div>
            </form>
        </div>
    </div>

    @if ($posts->count())
        <div class="card mb-3">
            @php
                if ($posts[0]->image) {
                    // Jika URL dari internet (Faker/Picsum)
                    $imageUrl = Str::startsWith($posts[0]->image, 'http')
                        ? $posts[0]->image
                        : asset('storage/' . $posts[0]->image);
                } else {
                    // Jika tidak ada gambar → fallback ke Picsum
                    $imageUrl = 'https://picsum.photos/1200/400?random=' . rand(1, 1000);
                }
            @endphp

            <div class="post-hero aspect-banner">
                <img src="{{ $imageUrl }}" alt="{{ $posts[0]->category->name }}" class="img-fluid">
            </div>

            <div class="card-body text-center">
                {{-- featured meta: author + date + reading time --}}
                @php
                    $first = $posts[0];
                    $readingTime = ceil(str_word_count(strip_tags($first->body)) / 200);
                    $authorInitials = collect(explode(' ', trim($first->author->name)))->map(function($n){ return strtoupper(substr($n,0,1)); })->take(2)->implode('');
                @endphp
                <div class="post-meta justify-content-center">
                    <div class="author-avatar">{{ $authorInitials }}</div>
                    <div>
                        <div class="small">By <a class="text-decoration-none text-dark fw-bold" href="/posts?author={{ $first->author->username }}">{{ $first->author->name }}</a></div>
                        <div class="small text-muted">{{ $first->created_at->format('M d, Y') }} · {{ $readingTime }} min read</div>
                    </div>
                </div>
                <h5 class="card-title">
                    <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">
                        {{ $posts[0]->title }}
                    </a>
                </h5>
                <p>
                    <small class="text-muted">
                        By.
                        <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">
                            {{ $posts[0]->author->name }}
                        </a>
                        in
                        <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none">
                            {{ $posts[0]->category->name }}
                        </a>
                        {{ $posts[0]->created_at->diffForHumans() }}
                    </small>
                </p>

                <p class="card-text card-excerpt">{{ $posts[0]->excerpt }}</p>
                <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read more</a>
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
                                @php
                                    $readingTime = ceil(str_word_count(strip_tags($post->body)) / 200);
                                    $initials = collect(explode(' ', trim($post->author->name)))->map(function($n){ return strtoupper(substr($n,0,1)); })->take(2)->implode('');
                                @endphp
                                <div class="post-meta">
                                    <div class="author-avatar">{{ $initials }}</div>
                                    <div>
                                        <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none text-dark small fw-bold">{{ $post->author->name }}</a>
                                        <div class="small text-muted">{{ $post->created_at->format('M d, Y') }} · {{ $readingTime }} min read</div>
                                    </div>
                                </div>
                                <p>
                                    <small class="text-muted">
                                        By.
                                        <a href="/posts?author={{ $post->author->username }}"
                                            class="text-decoration-none">{{ $post->author->name }}</a>
                                        in
                                        <a href="/categories/{{ $post->category->slug }}"
                                            class="text-decoration-none">{{ $post->category->name }}</a>
                                        {{ $post->created_at->diffForHumans() }}
                                    </small>
                                </p>
                                                                <p class="card-text card-excerpt">{{ $post->excerpt }}</p>
                                                                <div class="post-tags">
                                                                    <div class="tag">{{ $post->category->name }}</div>
                                                                </div>
                                <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No post found.</p>
    @endif

    <div class="d-flex justify-content-end">
        {{ $posts->links() }}
    </div>
@endsection
