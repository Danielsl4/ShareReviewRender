<?php
	
	namespace Database\Seeders;
	
	use App\Models\User;
	use App\Models\Activity;
	use Carbon\Carbon;
	use Illuminate\Database\Seeder;
	
	class UnfollowSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 */
		public function run(): void {
			$users = User::all();
			
			foreach ($users as $user) {
				// Obtener a quiénes sigue actualmente
				$currentlyFollowing = $user->follows;
				
				if ($currentlyFollowing->isEmpty()) continue;
				
				// Dejar de seguir entre 1 y 2 usuarios como máximo
				$toUnfollow = $currentlyFollowing->random(min(2, $currentlyFollowing->count()));
				
				foreach ($toUnfollow as $unfollowed) {
					$user->follows()->detach($unfollowed->id);
					
					$timestamp = Carbon::now()
						->subDays(rand(0, 730))
						->setTime(rand(0, 23), rand(0, 59), rand(0, 59));
					
					$user->follows()->detach($unfollowed->id);
					
					Activity::create([
						'user_id' => $user->id,
						'target_user_id' => $unfollowed->id,
						'action_type' => 'dejó de seguir',
						'created_at' => $timestamp,
						'updated_at' => $timestamp,
					]);
					
				}
			}
		}
	}
