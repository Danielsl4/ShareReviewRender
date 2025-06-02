<?php
	
	namespace Database\Seeders;
	
	use App\Models\Activity;
	use App\Models\Content;
	use App\Models\Review;
	use App\Models\User;
	use Illuminate\Database\Console\Seeds\WithoutModelEvents;
	use Illuminate\Database\Seeder;
	use Faker\Factory as Faker;
	
	class ReviewSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 */
		public function run(): void {
			$faker = Faker::create('es_ES');
			$users = User::all();
			$contents = Content::all();
			
			if ($contents->isEmpty()) {
				echo "No hay contenidos disponibles. No se generan reseñas.\n";
				return;
			}
			
			foreach ($users as $user) {
				$contentsToReview = $contents->random(rand(3, 10));
				
				foreach ($contentsToReview as $content) {
					$review = Review::create([
						'user_id' => $user->id,
						'content_id' => $content->id,
						'body' => "Me gustó mucho {$content->title}. " . $faker->sentence(rand(6, 12)),
						'rating' => rand(1, 10),
						'created_at' => now()->subDays(rand(0, 730)),
						'updated_at' => now(),
					]);
					
					Activity::create([
						'user_id' => $user->id,
						'action_type' => 'publicó una reseña',
						'content_id' => $content->id,
						'review_id' => $review->id,
						'created_at' => $review->created_at,
						'updated_at' => $review->updated_at,
					]);
				}
			}
		}
	}
