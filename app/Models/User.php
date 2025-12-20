<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi otomatis dari form
     * Semua field BISA diisi KECUALI 'id'
     */
    protected $guarded = ['id'];

    /**
     * Field yang disembunyikan saat di-convert ke JSON/Array
     * Password & token ga keliatan di API/response
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ubah format data otomatis
     * Tanggal jadi format datetime yang mudah dibaca
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
    ];

    /**
     * Relasi: 1 User punya banyak Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
