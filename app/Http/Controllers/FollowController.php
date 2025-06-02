<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Activity;
	use App\Models\User;
	use Illuminate\Support\Facades\Auth;
	
	class FollowController extends Controller {
		
		public function index() {
			$user = Auth::user();
			
			// Obtener IDs de usuarios seguidos
			$followedUserIds = $user->follows()->pluck('followed_id');
			
			// Obtener actividades de esos usuarios, ordenadas y paginadas
			$activities = Activity::whereIn('user_id', $followedUserIds)
				->orderByDesc('created_at')
				->with('user') // para acceder a la foto y nombre
				->paginate(10);
			
			return view('following', [
				'activities' => $activities,
			]);
		}
		
		public function followOrUnfollow($id) {
			$userToFollow = User::findOrFail($id);
			$currentUser = auth()->user();
			
			if ($currentUser->id == $userToFollow->id) {
				return back()->with('error', 'No puedes seguirte a ti mismo.');
			}
			
			if ($currentUser->isFollowing($userToFollow)) {
				$currentUser->following()->detach($userToFollow->id);
			} else {
				$currentUser->following()->attach($userToFollow->id);
			}
			
			return back();
		}
	}
