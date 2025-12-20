<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard user
     * Munculin: jumlah post, jumlah kategori, waktu login terakhir
     */
    public function index()
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Hitung jumlah post milik user ini
        $totalPosts = Post::where('user_id', $user->id)->count();

        // Hitung SEMUA kategori (bukan cuma punya user)
        $totalCategories = Category::count();

        // Cek kapan user login terakhir
        // Prioritas: last_login_at → updated_at → kosong
        $lastLogin = $user->last_login_at ?? $user->updated_at ?? null;

        return view('dashboard.index', compact(
            'user',
            'totalPosts',
            'totalCategories',
            'lastLogin'
        ));
    }
}
