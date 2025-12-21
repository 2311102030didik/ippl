<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Tampilkan daftar post dengan filter pencarian
     * Bisa filter: search, kategori, author
     */
    public function index(Request $request)
    {
        $title = '';
        $category = null;

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $category = Category::firstWhere('slug', $request->category);
            if ($category) {
                $title = ' di Kategori ' . $category->name;
            }
        }

        // Filter berdasarkan author (
        if ($request->filled('author')) {
            $author = User::firstWhere('username', $request->author);
            if ($author) {
                $title = ' oleh ' . $author->name;
            }
        }

        return view('posts', [
            'title'    => 'Semua Post' . $title,
            'active'   => 'posts',
            'posts'    => Post::latest()
                ->filter($request->only(['search', 'category', 'author']))
                ->paginate(7)
                ->withQueryString(),
            'category' => $category,
        ]);
    }

    /**
     * Tampilkan detail 1 post
     */
    public function show(Post $post)
    {
        if (!session()->has("viewed_post_{$post->id}")) {

        session()->put("viewed_post_{$post->id}", true);
    }
        return view('post', [
            'title'  => $post->title,
            'active' => 'posts',
            'post'   => $post,
        ]);
    }
}
