@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 fw-bold text-primary">Edit Post</h1>
</div>

<div class="col-lg-8">
    <form method="post" 
          action="/dashboard/posts/{{ $post->slug }}" 
          class="mb-5" 
          enctype="multipart/form-data">
        
        @method('put')
        @csrf

        {{-- TITLE --}}
        <div class="mb-4">
            <label for="title" class="form-label fw-medium">Title</label>
            <input type="text" 
                   class="form-control @error('title') is-invalid @enderror" 
                   id="title" 
                   name="title"
                   value="{{ old('title', $post->title) }}" 
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- SLUG --}}
        <div class="mb-4">
            <label for="slug" class="form-label fw-medium">Slug</label>
            <input type="text" 
                   class="form-control @error('slug') is-invalid @enderror" 
                   id="slug" 
                   name="slug"
                   value="{{ old('slug', $post->slug) }}" 
                   required>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- CATEGORY --}}
        <div class="mb-4">
            <label for="category_id" class="form-label fw-medium">Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" 
                    id="category_id" 
                    name="category_id" 
                    required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- IMAGE --}}
        <div class="mb-4">
            <label for="image" class="form-label fw-medium">Post Image</label>

            {{-- Simpan path gambar lama --}}
            <input type="hidden" name="oldImage" value="{{ $post->image }}">

            {{-- Tampilkan gambar lama --}}
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" 
                     class="img-preview img-fluid mb-3 col-sm-5 d-block">
            @else
                <img class="img-preview img-fluid mb-3 col-sm-5">
            @endif

            <input class="form-control @error('image') is-invalid @enderror" 
                type="file" id="image" name="image" onchange="previewImage()" accept="image/*">

            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- BODY --}}
        <div class="mb-4">
            <label for="body" class="form-label fw-medium">Content</label>
            @error('body')
                <div class="text-danger mb-2">{{ $message }}</div>
            @enderror

            <input id="body" 
                   type="hidden" 
                   name="body" 
                   value="{{ old('body', $post->body) }}">

            <trix-editor input="body" class="trix-content"></trix-editor>
        </div>

        {{-- BUTTON --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="/dashboard/posts" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-warning px-4 text-white">Update Post</button>
        </div>

    </form>
</div>

<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    // Auto generate slug
    title.addEventListener('change', function () {
        fetch('/dashboard/posts/checkSlug?title=' + encodeURIComponent(title.value))
            .then(response => response.json())
            .then(data => slug.value = data.slug);
    });

    // Disable file upload di trix
    document.addEventListener('trix-file-accept', function (e) {
        e.preventDefault();
    });

    // Preview image
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>

<style>
    .trix-button-row {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .trix-content {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
</style>

@endsection
