@extends('layouts.main')

@section('container')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            {{-- JUDUL POST BESAR --}}
            <h1 class="mb-4 fw-bold text-dark fs-2">{{ $post->title }}</h1>

            {{-- METADATA: AUTHOR | TANGGAL | WAKTU BACA | KATEGORI --}}
            @php
                // Hitung waktu baca: jumlah kata / 200 kata per menit
                $readingTime = ceil(str_word_count(strip_tags($post->body)) / 200);
            @endphp

            <div class="d-flex flex-wrap gap-3 mb-4 p-3 bg-light rounded-3 shadow-sm">
                {{-- AUTHOR (LINK KE POSTNYA) --}}
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-fill text-muted me-2"></i>
                    <a href="{{ route('posts.index', ['author' => $post->author->username]) }}"
                       class="text-decoration-none text-dark fw-medium">
                        {{ $post->author->name }}
                    </a>
                </div>

                {{-- TANGGAL PUBLISH --}}
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar3 text-muted me-2"></i>
                    <span class="text-muted">{{ $post->created_at->isoFormat('D MMMM YYYY') }}</span>
                </div>

                {{-- WAKTU BACA --}}
                <div class="d-flex align-items-center">
                    <i class="bi bi-clock text-muted me-2"></i>
                    <span class="text-muted">{{ $readingTime }} menit baca</span>
                </div>

                {{-- KATEGORI (LINK KE POST KATEGORI) --}}
                <div class="d-flex align-items-center">
                    <i class="bi bi-tag text-muted me-2"></i>
                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
                       class="text-decoration-none badge bg-primary-subtle text-primary px-2 py-1">
                        {{ $post->category->name }}
                    </a>
                </div>
            </div>

            {{-- GAMBAR POST (SMART FALLBACK) --}}
            @php
                // Gambar pintar: storage → external URL → random picsum
                $imageUrl = $post->image
                    ? (Str::startsWith($post->image, 'http')
                        ? $post->image
                        : asset('storage/' . $post->image))
                    : 'https://picsum.photos/1200/500?random=' . rand(1, 9999);
            @endphp

            <div class="rounded-4 overflow-hidden shadow-lg mb-5">
                <img src="{{ $imageUrl }}"
                     alt="{{ $post->title }}"
                     class="img-fluid w-100"
                     style="height: 500px; object-fit: cover;">
            </div>

            {{-- ISI ARTIKEL (RICH HTML) --}}
            <article class="fs-5 lh-lg" style="line-height: 1.8; color: #333;">
                {!! $post->body !!}
            </article>

            {{-- TOMBOl KEMBALI --}}
            <div class="mt-5 pt-4 border-top border-2 border-light">
                <a href="{{ route('posts.index') }}"
                   class="btn btn-outline-primary px-4 py-2 rounded-pill fw-medium">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali ke Semua Post
                </a>
            </div>
        </div>
    </div>
</div>

{{-- KOMENTAR DISQUS --}}
<div class="container py-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4 pb-2 border-bottom">💬 Komentar</h4>
            <div id="disqus_thread"></div>
        </div>
    </div>
</div>

{{-- DISQUS SCRIPT --}}
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
    <p class="text-center py-5">
        <strong>Harap aktifkan JavaScript</strong> untuk melihat komentar.
    </p>
</noscript>
@endsection
