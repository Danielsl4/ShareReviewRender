<?php
	
	namespace Database\Seeders;
	
	use App\Models\Review;
	use App\Models\User;
	use App\Models\Valoration;
	use Illuminate\Database\Seeder;
	
	class ValorationSeeder extends Seeder {
		public function run(): void {
			$users = User::all();
			$reviews = Review::all();
			
			foreach ($users as $user) {
				// El usuario valora entre 5 y 15 reseñas aleatorias
				$reviewsToValore = $reviews->random(rand(5, 15));
				
				foreach ($reviewsToValore as $review) {
					// Evitar duplicados si ya existe
					Valoration::updateOrCreate(
						['user_id' => $user->id, 'review_id' => $review->id],
						['value' => fake()->randomElement([1, -1])]
					);
				}
			}
		}
	}
