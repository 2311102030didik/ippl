<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_has_many_posts()
    {
        $user = User::factory()->create();
        $post1 = Post::factory()->create(['user_id' => $user->id]);
        $post2 = Post::factory()->create(['user_id' => $user->id]);
        $otherPost = Post::factory()->create(); // different user

        $this->assertCount(2, $user->posts);
        $this->assertTrue($user->posts->contains($post1));
        $this->assertTrue($user->posts->contains($post2));
        $this->assertFalse($user->posts->contains($otherPost));
    }

    /** @test */
    public function user_password_is_hashed()
    {
        $user = User::factory()->create([
            'password' => \Hash::make('plainpassword')
        ]);

        $this->assertNotEquals('plainpassword', $user->password);
        $this->assertTrue(\Hash::check('plainpassword', $user->password));
    }

    /** @test */
    public function user_password_is_hidden_from_array()
    {
        $user = User::factory()->create();

        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    /** @test */
    public function user_can_have_last_login_at()
    {
        $user = User::factory()->create([
            'last_login_at' => null,
        ]);

        $this->assertNull($user->last_login_at);

        $user->update(['last_login_at' => now()]);
        $user->refresh();

        $this->assertNotNull($user->last_login_at);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->last_login_at);
    }
}

