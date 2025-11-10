@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 fw-bold text-primary"> My Posts</h1>
        <a href="/dashboard/posts/create" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Create New Post
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-8 shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card col-lg-10 shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Your Posts List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $post->title }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $post->category->name }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="/dashboard/posts/{{ $post->slug }}" class="btn btn-sm btn-info text-white me-1 shadow-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-warning text-white me-1 shadow-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this post?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-emoji-frown fs-3 d-block mb-2"></i>
                                    You haven’t created any posts yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
