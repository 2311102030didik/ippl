<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        // Pilih kategori acak
        $categories = ['homestay', 'wisata', 'personal'];
        $category = $this->faker->randomElement($categories);

        
        $imageKeyword = $this->faker->randomElement(['homestay', 'wisata', 'nature', 'mountain', 'hotel']);
        $image = "https://picsum.photos/seed/" . rand(1, 9999) . "/640/480";

        return [
            'title' => $this->faker->sentence(mt_rand(2, 8)),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(),
            'body' => collect($this->faker->paragraphs(mt_rand(5, 10)))
                ->map(fn($p) => "<p>$p</p>")
                ->implode(''),
            'user_id' => mt_rand(1, 3),
            'category_id' => mt_rand(1, 3),
            'image' => $image,
        ];

    }
}
