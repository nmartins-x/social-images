<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create()->id,
            'caption' => fake()->name,
            'image_path' => fake()->imageUrl,
            'updated_at' => fake()->dateTime,
            'created_at' => fake()->dateTime,
        ];
    }
    
    public function withUserId(String $userId)
    {
        return $this->state([
            'user_id' => $userId,
        ]);
    }
}
