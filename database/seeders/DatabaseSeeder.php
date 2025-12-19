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
        // Use updateOrCreate so seeding can be run multiple times without duplicate errors
        $user = User::updateOrCreate(
            ['email' => 'embuh@gmail.com'],
            [
                'name' => 'embuh',
                'username' => 'embuh',
                'password' => bcrypt('12345')
            ]
        );

        // Categories used on the site (Indonesian)
        // idempotent category creation — won't insert duplicates on repeated seeds
        Category::updateOrCreate(
            ['slug' => 'tanaman-hias'],
            ['name' => 'Tanaman Hias', 'image' => 'assets/img/category/icon1.png']
        );

        Category::updateOrCreate(
            ['slug' => 'hidroponik'],
            ['name' => 'Hidroponik', 'image' => 'assets/img/category/icon2.png']
        );

        Category::updateOrCreate(
            ['slug' => 'pupuk-kompos'],
            ['name' => 'Pupuk & Kompos', 'image' => 'assets/img/category/icon3.png']
        );


          Post::factory(20)->create([
            'user_id' => $user->id // semua post ditulis oleh user "embuh"
        ]);

      
        
    }
}
