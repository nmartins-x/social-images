<?php

namespace Tests\Feature;

use Tests\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Http\Routes;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    private String $profileRoute = "/profile";
    
    public function test_go_to_profile_index_then_show_index_view(): void
    {
        $user = User::factory()->create();
        $response = $this->authUser($user)->get($this->profileRoute . "/$user->id");
        $response->assertViewIs('profiles.index', $user);
    }
    
    public function test_go_to_profile_edit_then_show_edit_view(): void
    {
        $user = User::factory()->create();
        $response = $this->authUser($user)->get($this->profileRoute . "/$user->id/edit");
        $response->assertViewIs('profiles.edit', $user);
    }
    
    public function test_go_to_profile_update_then_update_and_show_profile_view(): void
    {
        $user = User::factory()->create();
        $newData = [
            'name' => 'User 1',
            'username' => 'user1',
            'bio' => 'Bio.',
            'profile_image' => null,
        ];

        $response = $this
                ->authUser($user)
                ->patch($this->profileRoute . "/$user->id", $newData);
        
        $this->assertDatabaseHas('users', $newData);

        $response->assertRedirectToRoute(Routes::PROFILE_SHOW, $user);
    }
}
