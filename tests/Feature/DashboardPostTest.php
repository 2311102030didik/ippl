<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DashboardPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_access_dashboard_posts()
    {
        $response = $this->get('/dashboard/posts');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_view_own_posts_in_dashboard()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard/posts');
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /** @test */
    public function user_can_only_see_own_posts()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create();
        
        $post1 = Post::factory()->create([
            'user_id' => $user1->id,
            'category_id' => $category->id,
        ]);
        $post2 = Post::factory()->create([
            'user_id' => $user2->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user1)->get('/dashboard/posts');
        $response->assertStatus(200);
        $response->assertSee($post1->title);
        $response->assertDontSee($post2->title);
    }

    /** @test */
    public function user_can_view_create_post_page()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/posts/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/posts', [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'category_id' => $category->id,
            'body' => 'This is a test post body',
        ]);

        $response->assertRedirect('/dashboard/posts');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function creating_post_requires_all_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/posts', []);
        $response->assertSessionHasErrors(['title', 'slug', 'category_id', 'body']);
    }

    /** @test */
    public function creating_post_requires_unique_slug()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $existingPost = Post::factory()->create(['slug' => 'existing-slug']);

        $response = $this->actingAs($user)->post('/dashboard/posts', [
            'title' => 'Test Post',
            'slug' => 'existing-slug',
            'category_id' => $category->id,
            'body' => 'This is a test post body',
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    /** @test */
    public function user_can_upload_image_when_creating_post()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $file = UploadedFile::fake()->image('post-image.jpg');

        $response = $this->actingAs($user)->post('/dashboard/posts', [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'category_id' => $category->id,
            'body' => 'This is a test post body',
            'image' => $file,
        ]);

        $response->assertRedirect('/dashboard/posts');
        Storage::disk('public')->assertExists('post-images/' . $file->hashName());
    }

    /** @test */
    public function user_can_view_own_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get("/dashboard/posts/{$post->slug}");
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /** @test */
    public function user_can_view_edit_post_page()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get("/dashboard/posts/{$post->slug}/edit");
        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /** @test */
    public function user_can_update_own_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original Title',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->put("/dashboard/posts/{$post->slug}", [
            'title' => 'Updated Title',
            'slug' => $post->slug,
            'category_id' => $category->id,
            'body' => 'Updated body content',
        ]);

        $response->assertRedirect('/dashboard/posts');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function user_can_update_post_with_new_slug()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'slug' => 'old-slug',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->put("/dashboard/posts/{$post->slug}", [
            'title' => 'Updated Title',
            'slug' => 'new-slug',
            'category_id' => $category->id,
            'body' => 'Updated body content',
        ]);

        $response->assertRedirect('/dashboard/posts');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'slug' => 'new-slug',
        ]);
    }

    /** @test */
    public function updating_post_requires_unique_slug_if_changed()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'slug' => 'old-slug',
            'category_id' => $category->id,
        ]);
        $existingPost = Post::factory()->create([
            'slug' => 'existing-slug',
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->put("/dashboard/posts/{$post->slug}", [
            'title' => 'Updated Title',
            'slug' => 'existing-slug',
            'category_id' => $category->id,
            'body' => 'Updated body content',
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    /** @test */
    public function user_can_delete_own_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->delete("/dashboard/posts/{$post->slug}");

        $response->assertRedirect('/dashboard/posts');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function guest_cannot_check_slug()
    {
        $response = $this->get('/dashboard/posts/checkSlug?title=Test Title');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_check_slug()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/posts/checkSlug?title=Test Title');
        $response->assertStatus(200);
        $response->assertJsonStructure(['slug']);
    }
}

