<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        // Use Indonesian locale faker so seeded posts read like real Indonesian content
        $fakerId = \Faker\Factory::create('id_ID');

        $imageKeyword = $fakerId->randomElement(['tanaman', 'kebun', 'hidroponik', 'kompos', 'hortikultura']);
        $image = "https://picsum.photos/seed/" . rand(1, 9999) . "/1200/800";

        return [
            'title' => $fakerId->sentence(mt_rand(4, 8)),
            'slug' => \Illuminate\Support\Str::slug($fakerId->unique()->sentence(mt_rand(3,6))),
            'excerpt' => $fakerId->paragraph(mt_rand(1,2)),
            'body' => collect($fakerId->paragraphs(mt_rand(5, 8)))
                ->map(fn($p) => "<p>$p</p>")
                ->implode(''),
            'user_id' => mt_rand(1, 3),
            'category_id' => mt_rand(1, 3),
            'image' => $image,
        ];

    }
}
