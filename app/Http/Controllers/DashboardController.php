<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // counts
        $totalPosts = Post::where('user_id', $user->id)->count();
        $totalCategories = Category::count();

        // last login: prefer stored last_login_at if present, otherwise fallback to updated_at
        $lastLogin = $user->last_login_at ?? $user->updated_at ?? null;

        return view('dashboard.index', compact('user', 'totalPosts', 'totalCategories', 'lastLogin'));
    }
}