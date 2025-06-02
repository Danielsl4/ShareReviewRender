<?php
	
	namespace Database\Seeders;
	
	use Illuminate\Database\Seeder;
	
	class DatabaseSeeder extends Seeder {
		/**
		 * Seed the application's database.
		 */
		public function run(): void {
			$this->call([
				UserSeeder::class,
				ContentSeeder::class,
				ReviewSeeder::class,
				ValorationSeeder::class,
				FollowSeeder::class,
				UnfollowSeeder::class,
				ProblemSeeder::class,
			]);
		}
	}
