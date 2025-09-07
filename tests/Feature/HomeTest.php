<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Routes;

/**
 * Tests access to Home routes
 */
class HomeTest extends TestCase
{
    public function test_go_to_home_with_non_auth_user_then_redirect_to_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirectToRoute(Routes::LOGIN);
    }
    
    public function test_go_to_home_with_auth_user_then_success(): void
    {
        $response = $this->authUser()->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs(Routes::POSTS_INDEX);
    }
}
