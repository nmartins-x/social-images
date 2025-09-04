<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Like;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;
    
   /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create()->id,
            'post_id' => \App\Models\Post::factory()->create()->id,
            'updated_at' => fake()->dateTime,
            'created_at' => fake()->dateTime,
        ];
    }
    
    public function withPostIdAndUserId(String $postId, String $userId)
    {
        return $this->state([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
    }
}
