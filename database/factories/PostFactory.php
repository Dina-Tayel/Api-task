<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->word(),
            'body'=>$this->faker->text(100),
            'cover_image'=>$this->faker->imageUrl(640,480,'posts'),
            'pinned'=>$this->faker->randomElement([0,1]),
            'user_id'=>$this->faker->randomElement(User::pluck('id')->toArray()),
        ];
    }
}
