@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 fw-bold text-primary">Buat Post Baru</h1>
</div>

{{-- FORM UTAMA --}}
<div class="col-lg-8">
    <form method="POST" action="/dashboard/posts" class="mb-5" enctype="multipart/form-data">
        @csrf

        {{-- 1. JUDUL POST --}}
        <div class="mb-4">
            <label for="title" class="form-label fw-medium">Judul Post</label>
            <input type="text"
                   class="form-control @error('title') is-invalid @enderror"
                   id="title"
                   name="title"
                   value="{{ old('title') }}"
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 2. SLUG (URL FRIENDLY) --}}
        <div class="mb-4">
            <label for="slug" class="form-label fw-medium">Slug</label>
            <input type="text"
                   class="form-control @error('slug') is-invalid @enderror"
                   id="slug"
                   name="slug"
                   value="{{ old('slug') }}"
                   required>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 3. PILIH KATEGORI --}}
        <div class="mb-4">
            <label for="category_id" class="form-label fw-medium">Kategori</label>
            <select class="form-select @error('category_id') is-invalid @enderror"
                    id="category_id"
                    name="category_id"
                    required>
                <option value="">Pilih Kategori...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 4. UPLOAD GAMBAR + PREVIEW --}}
        <div class="mb-4">
            <label for="image" class="form-label fw-medium">Gambar Post</label>

            {{-- Preview gambar --}}
            <img class="img-preview img-fluid mb-3 col-sm-5" style="display: none;">

            {{-- Input file --}}
            <input class="form-control @error('image') is-invalid @enderror"
                   type="file"
                   id="image"
                   name="image"
                   onchange="previewImage()"
                   accept="image/*">

            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text text-muted">Max: 5MB. Rekomendasi: 1200×630 px</div>
        </div>

        {{-- 5. ISI POST (TRIX EDITOR) --}}
        <div class="mb-4">
            <label for="body" class="form-label fw-medium">Isi Post</label>
            @error('body')
                <div class="text-danger mb-2">{{ $message }}</div>
            @enderror
            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
            <trix-editor input="body" class="trix-content"></trix-editor>
        </div>

        {{-- 6. BUTTON SIMPAN/BATAL --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="/dashboard/posts" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary px-4">Simpan Post</button>
        </div>
    </form>
</div>

{{-- JAVASCRIPT --}}
<script>
    // 1. AUTO GENERATE SLUG dari judul
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function () {
        fetch('/dashboard/posts/checkSlug?title=' + encodeURIComponent(title.value))
            .then(response => response.json())
            .then(data => slug.value = data.slug);
    });

    // 2. NONAKTIFKAN upload gambar di Trix Editor
    document.addEventListener('trix-file-accept', function (e) {
        e.preventDefault();
    });

    // 3. PREVIEW GAMBAR saat pilih file
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        };
    }
</script>

{{-- CSS CUSTOM TRIX --}}
<style>
    .trix-button-row {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .trix-content {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 300px;
    }
</style>
@endsection
