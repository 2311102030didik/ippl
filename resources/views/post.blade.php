@extends('layouts.main')

@section('container')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Judul -->
            <h1 class="mb-4 fw-bold text-dark">{{ $post->title }}</h1>

            <!-- Metadata: Author, Date, Category -->
            @php
                $readingTime = ceil(str_word_count(strip_tags($post->body)) / 200);
            @endphp
            <div class="d-flex flex-wrap gap-3 mb-4 p-3 bg-light rounded-3">
                <div>
                    <i class="bi bi-person text-muted me-1"></i>
                    <a href="{{ route('posts.index', ['author' => $post->author->username]) }}" class="text-decoration-none text-dark fw-medium">
                        {{ $post->author->name }}
                    </a>
                </div>
                <div>
                    <i class="bi bi-calendar text-muted me-1"></i>
                    <span class="text-muted">{{ $post->created_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
                <div>
                    <i class="bi bi-clock text-muted me-1"></i>
                    <span class="text-muted">{{ $readingTime }} menit baca</span>
                </div>
                <div>
                    <i class="bi bi-tag text-muted me-1"></i>
                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}" class="text-decoration-none text-primary">
                        {{ $post->category->name }}
                    </a>
                </div>
            </div>

            <!-- Gambar Post -->
            @php
                $imageUrl = $post->image
                    ? (\Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image))
                    : 'https://picsum.photos/1200/500?random=' . rand(1, 9999);
            @endphp

            <div class="rounded-4 overflow-hidden shadow-sm mb-5">
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $post->title }}"
                    class="img-fluid w-100"
                    style="height: auto; max-height: 500px; object-fit: cover;"
                >
            </div>

            <!-- Konten Artikel -->
            <article class="fs-5 text-justify" style="line-height: 1.8; color: #333;">
                {!! $post->body !!}
            </article>

            <!-- Tombol Kembali -->
            <div class="mt-5 pt-4 border-top">
                <a href="/posts" class="btn btn-outline-primary px-4 py-2 rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Semua Post
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Disqus Comments -->
<div class="container py-5">
    <div id="disqus_thread"></div>
    <script>
        var disqus_config = function () {
            this.page.url = "{{ url()->current() }}";
            this.page.identifier = "post-{{ $post->id }}";
        };
        (function() {
            var d = document, s = d.createElement('script');
            s.src = 'https://zonadien-com.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>
        Please enable JavaScript to view the
        <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
    </noscript>
</div>
@endsection
