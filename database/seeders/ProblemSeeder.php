<?php
	
	namespace Database\Seeders;
	
	use App\Models\Problem;
	use App\Models\User;
	use App\Models\Review;
	use Illuminate\Database\Seeder;
	use Faker\Factory as Faker;
	
	class ProblemSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 */
		public function run(): void {
			$faker = Faker::create('es_ES');
			$users = User::all();
			$reviews = Review::all();
			
			if ($users->isEmpty() || $reviews->isEmpty()) {
				echo "No hay datos suficientes para generar problemas.\n";
				return;
			}
			
			for ($i = 0; $i < 10; $i++) {
				$type = $faker->randomElement(['usuario', 'reseña', 'otro']);
				
				Problem::create([
					'user_id' => $users->random()->id,
					'type' => $type,
					'report_id' => $type === 'usuario'
						? $users->random()->id
						: ($type === 'reseña' ? $reviews->random()->id : null),
					'body' => $faker->paragraph(),
				]);
			}
		}
	}
