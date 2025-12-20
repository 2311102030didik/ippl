@extends('dashboard.layouts.main')

@section('container')
<div class="container py-3">
    <div class="row">
        <div class="col-lg-8">
            {{-- HEADER: JUDUL + BUTTON --}}
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    {{-- JUDUL POST BESAR --}}
                    <h2 class="fw-bold mb-2">{{ $post->title }}</h2>

                    {{-- KATEGORI + INFO --}}
                    <div class="d-flex align-items-center gap-3 mb-0">
                        <small class="text-muted">
                            Kategori:
                            <span class="badge bg-secondary px-2 py-1">{{ $post->category->name }}</span>
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->created_at->format('d M Y') }}
                        </small>
                        <small class="text-muted">
                            Oleh: {{ $post->author->name }}
                        </small>
                    </div>
                </div>

                {{-- BUTTON: KEMBALI, EDIT, HAPUS --}}
                <div class="d-flex gap-2">
                    {{-- KEMBALI KE LIST --}}
                    <a href="/dashboard/posts"
                       class="btn btn-sm btn-outline-secondary"
                       title="Kembali">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    {{-- EDIT POST --}}
                    <a href="/dashboard/posts/{{ $post->slug }}/edit"
                       class="btn btn-sm btn-warning text-white"
                       title="Edit">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    {{-- HAPUS POST --}}
                    <form action="/dashboard/posts/{{ $post->slug }}"
                          method="POST"
                          class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus post \"{{ $post->title }}\"?')"
                                title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- GAMBAR POST --}}
            <div class="rounded-3 overflow-hidden shadow-sm mb-4">
                @if ($post->image)
                    {{-- GAMBAR UPLOAD USER --}}
                    <img src="{{ asset('storage/' . $post->image) }}"
                         alt="{{ $post->title }}"
                         class="img-fluid">
                @else
                    {{-- GAMBAR DARI UNSPLASH (AUTO) --}}
                    <img src="https://source.unsplash.com/1200x400?{{ urlencode($post->category->name) }}"
                         alt="{{ $post->category->name }}"
                         class="img-fluid">
                @endif
            </div>

            {{-- ISI POST (HTML RICH TEXT) --}}
            <article class="fs-5 lh-lg" style="color: #333; line-height: 1.8;">
                {!! $post->body !!}
            </article>
        </div>
    </div>
</div>
@endsection
