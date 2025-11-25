@extends('dashboard.layouts.main')

@section('container')
<div class="container py-3">
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="fw-bold">{{ $post->title }}</h2>
                    <small class="text-muted">
                        Category: <span class="badge bg-secondary">{{ $post->category->name }}</span>
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="/dashboard/posts" class="btn btn-sm btn-outline-secondary" title="Back">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-warning text-white" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-sm btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this post?')" 
                            title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            @if ($post->image)
                <div class="rounded-3 overflow-hidden shadow-sm mb-4">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
                </div>
            @else
                <div class="rounded-3 overflow-hidden shadow-sm mb-4">
                    <img src="https://source.unsplash.com/1200x400?{{ urlencode($post->category->name) }}"
                        alt="{{ $post->category->name }}" class="img-fluid">
                </div>
            @endif

            <article class="fs-5" style="line-height: 1.8; color: #333;">
                {!! $post->body !!}
            </article>
        </div>
    </div>
</div>
@endsection