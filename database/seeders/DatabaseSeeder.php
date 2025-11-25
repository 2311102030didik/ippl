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
        // User manual (keep original 'embuh' account as requested)
        $user = User::create([
            'name' => 'embuh',
            'username' => 'embuh',
            'email' => 'embuh@gmail.com',
            'password' => bcrypt('12345')
        ]);

        // Categories used on the site (Indonesian)
        Category::create([
            'name' => 'Tanaman Hias',
            'slug' => 'tanaman-hias',
            'image' => 'assets/img/category/icon1.png',
        ]);

        Category::create([
            'name' => 'Hidroponik',
            'slug' => 'hidroponik',
            'image' => 'assets/img/category/icon2.png'
        ]);

        Category::create([
            'name' => 'Pupuk & Kompos',
            'slug' => 'pupuk-kompos',
            'image' => 'assets/img/category/icon3.png'
        ]);


          Post::factory(20)->create([
            'user_id' => $user->id // semua post ditulis oleh user "embuh"
        ]);

      
        
    }
}
