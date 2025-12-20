<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Sluggable;

    /**
     * Batasan field yang boleh diisi otomatis dari form
     * Artinya: semua field BISA diisi KECUALI 'id'
     */
    protected $guarded = ['id'];

    /**
     * Relasi yang otomatis dimuat setiap kali ambil data Post
     * Jadi post->category dan post->author selalu ada
     */
    protected $with = ['category', 'author'];

    /**
     * Fungsi untuk filter post (search, kategori, author)
     */
    public function scopeFilter($query, array $filters)
    {
        // Filter pencarian di judul atau isi
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        });

        // Filter berdasarkan kategori
        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        // Filter berdasarkan penulis
        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) => $query->whereHas(
                'author',
                fn ($query) => $query->where('username', $author)
            )
        );



        return $query;
    }

        /**
     * Scope: Post terpopuler (berdasarkan jumlah views)
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }
    /**
     * Relasi: 1 Post punya 1 Kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: 1 Post punya 1 Author (User)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Pakai slug (bukan id) di URL
     * Contoh: /post/judul-post-bukan-id
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Atur slug dibuat otomatis dari judul
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ],
        ];
    }
}
