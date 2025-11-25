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
        // Create a realistic site admin user
        $user = User::create([
            'name' => 'Admin Kebun Kita',
            'username' => 'admin',
            'email' => 'admin@kebunkita.local',
            'password' => bcrypt('password')
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
