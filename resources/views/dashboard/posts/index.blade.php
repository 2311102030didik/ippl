@extends('dashboard.layouts.main')

@section('container')
{{-- HEADER + TOMBBOL TAMBAH --}}
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 fw-bold text-primary">Post Saya</h1>
    <a href="/dashboard/posts/create" class="btn btn-primary shadow-sm rounded-3 px-3">
        <i class="bi bi-plus-circle me-1"></i> Buat Post Baru
    </a>
</div>

{{-- ALERT SUKSES (muncul setelah create/edit/delete) --}}
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show col-lg-8 shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- TABEL DAFTAR POST --}}
<div class="card col-lg-10 shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0 fw-medium">Daftar Post Kamu</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                {{-- HEADER TABEL --}}
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%;">#</th>
                        <th scope="col" style="width: 55%;">Judul</th>
                        <th scope="col" style="width: 25%;">Kategori</th>
                        <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- LOOP POST --}}
                    @forelse ($posts as $post)
                        <tr>
                            {{-- NOMOR URUT --}}
                            <td class="text-center text-muted fw-light">{{ $loop->iteration }}</td>

                            {{-- JUDUL POST --}}
                            <td class="fw-semibold text-truncate" style="max-width: 300px;">
                                {{ $post->title }}
                            </td>

                            {{-- KATEGORI (BADGE) --}}
                            <td>
                                <span class="badge bg-secondary rounded-pill px-2 py-1">
                                    {{ $post->category->name }}
                                </span>
                            </td>

                            {{-- TOMBOl AKI (VIEW, EDIT, DELETE) --}}
                            <td class="text-center">
                                {{-- LIHAT DETAIL --}}
                                <a href="/dashboard/posts/{{ $post->slug }}"
                                   class="btn btn-sm btn-outline-info me-1"
                                   title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="/dashboard/posts/{{ $post->slug }}/edit"
                                   class="btn btn-sm btn-outline-warning me-1"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- HAPUS (FORM DELETE) --}}
                                <form action="/dashboard/posts/{{ $post->slug }}"
                                      method="POST"
                                      class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin hapus post \"{{ $post->title }}\"?')"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- KALAU BELUM ADA POST --}}
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-file-earmark-text fs-2 opacity-50 mb-2 d-block"></i>
                                <p class="mb-0">Belum ada post. <a href="/dashboard/posts/create">Buat sekarang!</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
