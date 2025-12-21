<?php

use App\Models\Category;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/categories', function () {
    return view('categories', [
        'title' => "Post Categories",
        'categories' => Category::all()
    ]);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('posts/{post:slug}', [PostController::class, 'show']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

// Coverage Report Route (only in local/testing environment)
if (app()->environment(['local', 'testing']) || env('APP_DEBUG', false)) {
    // Root route untuk coverage-report
    Route::get('/coverage-report', function () {
        $coveragePath = base_path('coverage-report/index.html');

        if (!file_exists($coveragePath)) {
            return response('Coverage report not found. Please run: <code>php artisan test --coverage-html coverage-report</code>', 404)
                ->header('Content-Type', 'text/html');
        }

        return response()->file($coveragePath, ['Content-Type' => 'text/html']);
    });

    // Route untuk file-file di dalam coverage-report (CSS, JS, images, dll)
    Route::get('/coverage-report/{path}', function ($path) {
        $coveragePath = base_path('coverage-report/' . $path);

        // Security: prevent directory traversal
        $coveragePath = realpath($coveragePath);
        $basePath = realpath(base_path('coverage-report'));

        if (!$coveragePath || strpos($coveragePath, $basePath) !== 0) {
            abort(404);
        }

        if (!file_exists($coveragePath)) {
            abort(404);
        }

        // Determine content type
        $extension = strtolower(pathinfo($coveragePath, PATHINFO_EXTENSION));
        $contentTypes = [
            'html' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'json' => 'application/json',
        ];

        $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

        return response()->file($coveragePath, ['Content-Type' => $contentType]);
    })->where('path', '.*');
}
