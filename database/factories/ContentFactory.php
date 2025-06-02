<?php
	
	namespace Database\Factories;
	
	use Illuminate\Database\Eloquent\Factories\Factory;
	
	/**
	 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
	 */
	class ContentFactory extends Factory {
		/**
		 * Define the model's default state.
		 *
		 * @return array<string, mixed>
		 */
		public function definition(): array {
			return [
				'title' => fake()->sentence(3),
				'type' => fake()->randomElement(['movie', 'book', 'game']),
				'author' => fake()->name(),
				'description' => fake()->paragraph(),
				'cover' => 'https://via.placeholder.com/300x450.png?text=Portada',
				'release_date' => fake()->date(),
				'external_id' => null,
			];
		}
	}
