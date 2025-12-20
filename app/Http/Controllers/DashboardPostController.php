<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardPostController extends Controller
{
    /**
     * Tampilkan daftar post milik user yang login
     */
    public function index()
    {
        // Ambil post HANYA milik user ini
        return view('dashboard.posts.index', [
            'posts' => Post::where('user_id', auth()->id())->get(),
        ]);
    }

    /**
     * Tampilkan form BUAT post baru
     */
    public function create()
    {
        // Kirim semua kategori ke form
        return view('dashboard.posts.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * SIMPAN post baru ke database
     */
    public function store(Request $request)
    {
        // Validasi data form
        $validatedData = $request->validate([
            'title'       => 'required|max:255',     // Judul wajib, max 255 huruf
            'slug'        => 'required|unique:posts', // Slug unik
            'category_id' => 'required',             // Kategori wajib
            'image'       => 'image|file|max:5000',  // Gambar max 5MB
            'body'        => 'required',             // Isi wajib
        ]);

        // Upload gambar kalau ada
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')
                ->store('post-images', 'public');
        }

        // Tambah data user dan ringkasan otomatis
        $validatedData['user_id'] = auth()->id();
        $validatedData['excerpt'] = Str::limit(
            strip_tags($request->body),
            200
        );

        // Simpan ke database
        Post::create($validatedData);

        return redirect('/dashboard/posts')
            ->with('success', 'Post baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan DETAIL 1 post
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Tampilkan form EDIT post
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post'       => $post,
            'categories' => Category::all(),
        ]);
    }

    /**
     * UPDATE post yang sudah ada
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title'       => 'required|max:255',
            'category_id' => 'required',
            'body'        => 'required',
            'image'       => 'image|file|max:5000',
        ];

        // Kalau slug berubah, harus unik lagi
        if ($request->slug !== $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        // Ganti gambar kalau upload yang baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Upload gambar baru
            $validatedData['image'] = $request->file('image')
                ->store('post-images', 'public');
        }

        // Update excerpt dan user_id
        $validatedData['user_id'] = auth()->id();
        $validatedData['excerpt'] = Str::limit(
            strip_tags($request->body),
            200
        );

        // Simpan perubahan
        $post->update($validatedData);

        return redirect('/dashboard/posts')
            ->with('success', 'Post berhasil diupdate!');
    }

    /**
     * HAPUS post beserta gambarnya
     */
    public function destroy(Post $post)
    {
        // Hapus gambar kalau ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Hapus post dari database
        $post->delete();

        return redirect('/dashboard/posts')
            ->with('success', 'Post berhasil dihapus!');
    }

    /**
     * Cek slug real-time saat user ketik judul
     */
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(
            Post::class,
            'slug',
            $request->title
        );

        return response()->json(['slug' => $slug]);
    }
}
