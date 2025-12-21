<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'latestPosts' => Post::latest()->take(3)->get()
        ]);
    }
}
