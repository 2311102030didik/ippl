<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function post_belongs_to_category()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
        $this->assertEquals($category->name, $post->category->name);
    }

    /** @test */
    public function post_belongs_to_author()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $post->author);
        $this->assertEquals($user->id, $post->author->id);
        $this->assertEquals($user->name, $post->author->name);
    }

    /** @test */
    public function post_filter_by_search_in_title()
    {
        Post::factory()->create(['title' => 'Laravel Tutorial']);
        Post::factory()->create(['title' => 'PHP Basics']);
        Post::factory()->create(['title' => 'Laravel Advanced']);

        $results = Post::filter(['search' => 'Laravel'])->get();

        $this->assertCount(2, $results);
        $this->assertTrue($results->every(fn($post) => str_contains($post->title, 'Laravel')));
    }

    /** @test */
    public function post_filter_by_search_in_body()
    {
        Post::factory()->create(['body' => '<p>This is about Laravel framework</p>']);
        Post::factory()->create(['body' => '<p>This is about PHP language</p>']);

        $results = Post::filter(['search' => 'Laravel'])->get();

        $this->assertCount(1, $results);
        $this->assertStringContainsString('Laravel', $results->first()->body);
    }

    /** @test */
    public function post_filter_by_category()
    {
        $category1 = Category::factory()->create(['slug' => 'category-1']);
        $category2 = Category::factory()->create(['slug' => 'category-2']);
        
        $post1 = Post::factory()->create(['category_id' => $category1->id]);
        $post2 = Post::factory()->create(['category_id' => $category2->id]);
        $post3 = Post::factory()->create(['category_id' => $category1->id]);

        $results = Post::filter(['category' => 'category-1'])->get();

        $this->assertCount(2, $results);
        $this->assertTrue($results->every(fn($post) => $post->category_id === $category1->id));
    }

    /** @test */
    public function post_filter_by_author()
    {
        $author1 = User::factory()->create(['username' => 'author1']);
        $author2 = User::factory()->create(['username' => 'author2']);
        
        $post1 = Post::factory()->create(['user_id' => $author1->id]);
        $post2 = Post::factory()->create(['user_id' => $author2->id]);
        $post3 = Post::factory()->create(['user_id' => $author1->id]);

        $results = Post::filter(['author' => 'author1'])->get();

        $this->assertCount(2, $results);
        $this->assertTrue($results->every(fn($post) => $post->user_id === $author1->id));
    }

    /** @test */
    public function post_filter_combines_category_and_author()
    {
        $category = Category::factory()->create(['slug' => 'test-category']);
        $otherCategory = Category::factory()->create(['slug' => 'other-category']);
        $author = User::factory()->create(['username' => 'testauthor']);
        $otherAuthor = User::factory()->create(['username' => 'otherauthor']);
        
        $matchingPost = Post::factory()->create([
            'title' => 'Test Post',
            'category_id' => $category->id,
            'user_id' => $author->id,
        ]);
        
        // Post dengan category yang sama tapi author berbeda
        Post::factory()->create([
            'title' => 'Other Post',
            'category_id' => $category->id,
            'user_id' => $otherAuthor->id,
        ]);
        
        // Post dengan author yang sama tapi category berbeda
        Post::factory()->create([
            'title' => 'Another Post',
            'category_id' => $otherCategory->id,
            'user_id' => $author->id,
        ]);

        $results = Post::filter([
            'category' => 'test-category',
            'author' => 'testauthor',
        ])->get();

        $this->assertCount(1, $results);
        $this->assertEquals($matchingPost->id, $results->first()->id);
    }

    /** @test */
    public function post_uses_slug_as_route_key()
    {
        $post = Post::factory()->create(['slug' => 'test-slug']);
        
        $this->assertEquals('slug', $post->getRouteKeyName());
        $this->assertEquals('test-slug', $post->getRouteKey());
    }

    /** @test */
    public function post_has_excerpt_generated()
    {
        $post = Post::factory()->create([
            'body' => '<p>This is a very long body content that should be truncated when excerpt is generated.</p>'
        ]);

        $this->assertNotNull($post->excerpt);
        $this->assertLessThanOrEqual(200, strlen($post->excerpt));
    }

    /** @test */
    public function posts_are_ordered_by_latest()
    {
        $oldPost = Post::factory()->create(['created_at' => now()->subDays(2)]);
        $newPost = Post::factory()->create(['created_at' => now()]);

        $posts = Post::latest()->get();

        $this->assertEquals($newPost->id, $posts->first()->id);
        $this->assertEquals($oldPost->id, $posts->last()->id);
    }
}

