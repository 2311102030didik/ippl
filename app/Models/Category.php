<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Field yang boleh diisi otomatis dari form
     * Semua field BISA diisi KECUALI 'id'
     */
    protected $guarded = ['id'];

    /**
     * Relasi: 1 Kategori punya banyak Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
