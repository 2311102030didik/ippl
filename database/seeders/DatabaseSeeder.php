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
            'name' => 'a',
            'slug' => 'a',
            'image' => 'assets/img/category/kimberly-farmer-lUaaKCUANVI-unsplash.jpg',
        ]);

        Category::create([
            'name' => 'b',
            'slug' => 'b',
            'image' => 'assets/img/category/kimberly-farmer-lUaaKCUANVI-unsplash.jpg'
        ]);

        Category::create([
            'name' => 'c',
            'slug' => 'c',
            'image' => 'assets/img/category/kimberly-farmer-lUaaKCUANVI-unsplash.jpg'
        ]);


          Post::factory(20)->create([
            'user_id' => $user->id // semua post ditulis oleh user "embuh"
        ]);

      
        
    }
}
