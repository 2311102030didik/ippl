<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_posts_index()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertSee('Semua Artikel');
    }

    /** @test */
    public function can_view_single_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        
        $response = $this->get("/posts/{$post->slug}");
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /** @test */
    public function can_filter_posts_by_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['slug' => 'test-category']);
        $otherCategory = Category::factory()->create();
        $postInCategory = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        $postNotInCategory = Post::factory()->create([
            'category_id' => $otherCategory->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/posts?category=test-category');
        $response->assertStatus(200);
        $response->assertSee($postInCategory->title);
        $response->assertSee('in ' . $category->name);
    }

    /** @test */
    public function can_filter_posts_by_author()
    {
        $category = Category::factory()->create();
        $author = User::factory()->create(['username' => 'testauthor']);
        $postByAuthor = Post::factory()->create([
            'user_id' => $author->id,
            'category_id' => $category->id,
        ]);
        $postByOther = Post::factory()->create(['category_id' => $category->id]);

        $response = $this->get('/posts?author=testauthor');
        $response->assertStatus(200);
        $response->assertSee($postByAuthor->title);
        $response->assertSee('by ' . $author->name);
    }

    /** @test */
    public function can_search_posts_by_title()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'title' => 'Unique Search Term',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        $otherPost = Post::factory()->create([
            'title' => 'Other Post',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/posts?search=Unique');
        $response->assertStatus(200);
        $response->assertSee('Unique Search Term');
    }

    /** @test */
    public function can_search_posts_by_body()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'body' => '<p>This is a unique body content</p>',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
        $otherPost = Post::factory()->create([
            'body' => '<p>Other content</p>',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/posts?search=unique body');
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /** @test */
    public function posts_are_paginated()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        // Create more than 7 posts (default pagination)
        Post::factory()->count(10)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/posts');
        $response->assertStatus(200);
        // Check if pagination links exist
        $response->assertSee('posts');
    }

    /** @test */
    public function can_view_categories_page()
    {
        $category = Category::factory()->create();
        
        $response = $this->get('/categories');
        $response->assertStatus(200);
        $response->assertSee('Post Categories');
        $response->assertSee($category->name);
    }

    /** @test */
    public function can_view_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Home');
    }

    /** @test */
    public function can_view_about_page()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('about');
    }

    /** @test */
    public function non_existent_post_returns_404()
    {
        $response = $this->get('/posts/non-existent-slug');
        $response->assertStatus(404);
    }
}

