<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_has_many_posts()
    {
        $category = Category::factory()->create();
        $otherCategory = Category::factory()->create();
        $user = \App\Models\User::factory()->create();
        
        $post1 = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        $post2 = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        $otherPost = Post::factory()->create([
            'category_id' => $otherCategory->id,
            'user_id' => $user->id,
        ]);

        $this->assertCount(2, $category->posts);
        $this->assertTrue($category->posts->contains($post1));
        $this->assertTrue($category->posts->contains($post2));
        $this->assertFalse($category->posts->contains($otherPost));
    }

    /** @test */
    public function category_has_unique_slug()
    {
        Category::factory()->create(['slug' => 'test-slug']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Category::factory()->create(['slug' => 'test-slug']);
    }

    /** @test */
    public function category_has_unique_name()
    {
        Category::factory()->create(['name' => 'Test Category']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Category::factory()->create(['name' => 'Test Category']);
    }
}

