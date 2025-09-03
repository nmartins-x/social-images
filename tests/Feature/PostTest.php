<?php

namespace Tests\Feature;

use \Tests\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Post;

/**
 * Tests access to Posts routes
 */
class PostTest extends TestCase
{
    use RefreshDatabase;
    private String $postsRoute = "/posts";
    
    public function test_go_to_routes_with_unauthorized_user_then_redirect_to_login(): void
    {
        $indexResponse = $this->get($this->postsRoute);
        $indexResponse->assertRedirectToRoute('login');
        
        $createResponse = $this->get($this->postsRoute . '/create');
        $createResponse->assertRedirectToRoute('login');
        
        $showResponse = $this->get($this->postsRoute . '/1234');
        $showResponse->assertRedirectToRoute('login');
        
        $editResponse = $this->get($this->postsRoute . '/1234/edit');
        $editResponse->assertRedirectToRoute('login');
    }
    
    public function test_go_to_posts_index_then_show_index_view(): void
    {
        $response = $this->authUser()->get($this->postsRoute);
        
        $response->assertViewIs('posts.index');
    }
    
    public function test_go_to_posts_create_then_show_create_view(): void
    {
        $response = $this->authUser()->get($this->postsRoute . '/create');
        
        $response->assertViewIs('posts.create');
    }
    
    public function test_store_post_then_store_and_redirect_to_profile(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('dog.jpg');
        
        // REST POST Request to store an image post
        $response = $this
                ->authUser()
                ->post($this->postsRoute, [
            'caption' => 'foo',
            'image' => $file
        ]);

        $response->assertRedirectToRoute('profile.show', Auth::id());
        
        $filePath = 'uploads/' . $file->hashName();
        Storage::disk('public')->assertExists($filePath);
        
        $this->assertDatabaseHas('posts', [
            'caption' => 'foo',
            'image_path' => $filePath,
            'user_id' => Auth::id()
         ]);
    }
    
    public function test_go_to_post_update_then_update_and_show_post_view(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()
                ->withUserId($user->id)
                ->create();

        $response = $this
                ->authUser($user)
                ->patch($this->postsRoute . "/$post->id", ["caption" => "dsds"]);
        var_dump($response->getContent());

        $response->assertRedirectToRoute('posts.show', $post);
    }
}
