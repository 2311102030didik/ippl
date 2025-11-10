<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // User manual
        $user = User::create([
            'name' => 'embuh',
            'username' => 'embuh',
            'email' => 'embuh@gmail.com',
            'password' => bcrypt('12345')
        ]);

        // Kategori manual
        Category::create([
            'name' => 'homestay',
            'slug' => 'homestay'
        ]);

        Category::create([
            'name' => 'wisata',
            'slug' => 'tempat-wisata'
        ]);

        Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        // Post pakai kategori random dari yang sudah ada
        Post::factory(20)->create([
            'user_id' => $user->id // semua post ditulis oleh user "embuh"
        ]);
    }
}
