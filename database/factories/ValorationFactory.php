<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Valoration>
 */
class ValorationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
	public function definition(): array
	{
		return [
			'user_id' => User::inRandomOrder()->first()?->id,
			'review_id' => Review::inRandomOrder()->first()?->id,
			'value' => fake()->randomElement([1, -1]),
		];
	}
}
