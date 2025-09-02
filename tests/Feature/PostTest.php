<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Tests access to Posts routes
 */
class PostTest extends TestCase
{
    private String $postsRoute = "/posts";
    
    public function test_go_to_posts_index_with_unauthorized_user_then_redirects_to_login(): void
    {
        $response = $this->get($this->postsRoute);
        
        $response->assertRedirectToRoute('login');
    }
    
    public function test_go_to_posts_index_then_shows_index_view(): void
    {
        $response = $this->authUser()->get($this->postsRoute);
        
        $response->assertViewIs('posts.index');
    }
}
