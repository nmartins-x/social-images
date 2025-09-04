<?php

namespace Tests\Feature;

use Tests\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_go_to_routes_with_unauthorized_user_then_redirect_to_login(): void
    {
        $storeResponse = $this->post('/posts/1234/likes');
        $storeResponse->assertRedirectToRoute('login');
        
        $deleteResponse = $this->delete('/posts/1234/likes');
        $deleteResponse->assertRedirectToRoute('login');
    }
    
    public function test_store_like_then_store_and_redirect_back(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()
                ->withUserId($user->id)
                ->create();
        
        $response = $this
            ->authUser($user)
            ->post("/posts/$post->id" . "/likes");
        
        $this->assertDatabaseHas('likes', [
            'post_id' => $post->id,
            'user_id' => $user->id
         ]);
        
        $response->assertRedirectBack();
    }
    
    public function test_delete_like_then_deleted_and_redirect_back(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()
                ->withUserId($user->id)
                ->create();
        $like = Like::factory()
                ->withPostIdAndUserId($post->id, $user->id)
                ->create();
     
        $this->assertDatabaseHas('likes', [
            'post_id' => $post->id,
            'user_id' => $user->id
         ]);
        
        $response = $this
            ->authUser($user)
            ->delete("/posts/$post->id" . "/likes");
        
        $this->assertDatabaseMissing('likes', [
            'post_id' => $post->id,
            'user_id' => $user->id
         ]);
        
        $response->assertRedirectBack();
    }
}
