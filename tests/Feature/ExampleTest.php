<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that homepage is accessible.
     *
     * @return void
     */
    public function test_homepage_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Home');
    }

    /**
     * Test that about page is accessible.
     *
     * @return void
     */
    public function test_about_page_is_accessible()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('about');
    }
}
