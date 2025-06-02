<?php
	
	namespace Database\Seeders;
	
	use App\Models\User;
	use App\Models\Activity;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class FollowSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 */
		public function run(): void {
			$users = User::all();
			
			foreach ($users as $user) {
				// Elegir entre 2 y 6 usuarios aleatorios distintos a sí mismo
				$toFollow = $users->where('id', '!=', $user->id)->random(rand(2, 6));
				
				foreach ($toFollow as $followed) {
					// Evitar duplicados
					if ($user->follows()->where('followed_id', $followed->id)->exists()) {
						continue;
					}
					
					$timestamp = Carbon::now()
						->subDays(rand(0, 730))
						->setTime(rand(0, 23), rand(0, 59), rand(0, 59));
					
					$user->follows()->attach($followed->id, [
						'created_at' => $timestamp,
						'updated_at' => $timestamp,
					]);
					
					Activity::create([
						'user_id' => $user->id,
						'target_user_id' => $followed->id,
						'action_type' => 'siguió a',
						'created_at' => $timestamp,
						'updated_at' => $timestamp,
					]);
					
				}
			}
		}
	}
