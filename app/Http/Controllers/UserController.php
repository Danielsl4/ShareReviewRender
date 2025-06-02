<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Activity;
	use Illuminate\Http\Request;
	use App\Models\User;
	use Illuminate\Support\Facades\Storage;
	
	class UserController extends Controller {
		
		public function show($id) {
			$user = User::findOrFail($id);
			
			$reviews = $user->reviews()->latest()->paginate(9);
			$totalReviews = $user->reviews()->count();
			$averageRating = $user->reviews()->avg('rating');
			
			return view('user.show', [
				'user' => $user,
				'reviews' => $reviews,
				'totalReviews' => $totalReviews,
				'averageRating' => $averageRating,
			]);
		}
		
		//Form para editar usuario
		public function edit($id) {
			$user = User::findOrFail($id);
			
			// Solo puede ser el mismo usuario o q tenga admin true
			if (auth()->id() != $user->id && !auth()->user()->admin) {
				abort(403, 'No puede editar este usuario.');
			}
			
			return view('user.edit', ['user' => $user]);
		}
		
		public function update(Request $request, $id) {
			$user = User::findOrFail($id);
			
			if (auth()->id() != $user->id && !auth()->user()->admin) {
				abort(403);
			}
			
			$request->validate([
				'name' => 'required|string|max:255',
				'email' => 'required|email|unique:users,email,' . $user->id,
				'biography' => 'nullable|string',
				'profile_photo' => 'nullable|image|max:2048',
			]);
			
			$user->name = $request->name;
			$user->email = $request->email;
			$user->biography = $request->biography;
			
			if ($request->hasFile('profile_photo')) {
				// Borrar imagen anterior a menos q sea la por defecto
				if ($user->profile_photo && $user->profile_photo != 'img/foto_perfil_por_defecto.png' && Storage::disk('public')->exists($user->profile_photo)) {
					Storage::disk('public')->delete($user->profile_photo);
				}
				
				$path = $request->file('profile_photo')->store('profile_pictures/' . $user->id, 'public');
				$user->profile_photo = $path;
			}
			
			$user->save();
			
			return redirect()->route('settings.edit', $user->id)
				->with('success', 'Perfil actualizado correctamente.');
		}
		
		public function destroy(User $user) {
			$user->delete();
			
			return redirect('/')->with('success', 'Cuenta eliminada correctamente.');
		}
		
		public function followers($id) {
			$user = User::findOrFail($id);
			$followers = $user->followers()->get();
			return view('user.followers', ['user' => $user, 'followers' => $followers]);
		}
		
		public function following($id) {
			$user = User::findOrFail($id);
			$following = $user->following()->get();
			return view('user.following', ['user' => $user, 'following' => $following]);
		}
		
		public function activity() {
			$userId = auth()->id();
			
			$activities = Activity::where('user_id', $userId)
				->orWhere('target_user_id', $userId)
				->with(['user', 'targetUser', 'review', 'content'])
				->latest()
				->paginate(10);
			
			return view('activity', ['activities' => $activities]);
		}
		
		public function follow($id) {
			$userToFollow = User::findOrFail($id);
			$user = auth()->user();
			
			// Evitar seguirse a sí mismo o duplicar follow
			if ($user->id == $userToFollow->id || $user->following()->where('followed_id', $id)->exists()) {
				return back()->with('error', 'No puedes seguir a este usuario.');
			}
			
			// Crear relación en tabla follows
			$user->following()->attach($userToFollow->id);
			
			// Registrar actividad
			Activity::create([
				'user_id' => $user->id,
				'target_user_id' => $userToFollow->id,
				'action_type' => 'siguió a',
			]);
			
			return back()->with('success', 'Has seguido a ' . $userToFollow->name);
		}
		
		public function unfollow($id) {
			$userToUnfollow = User::findOrFail($id);
			$user = auth()->user();
			
			// Verifica que realmente lo sigues
			if (!$user->following()->where('followed_id', $id)->exists()) {
				return back()->with('error', 'No sigues a este usuario.');
			}
			
			// Elimina la relación de seguimiento
			$user->following()->detach($id);
			
			// Registrar actividad de dejar de seguir
			Activity::create([
				'user_id' => $user->id,
				'target_user_id' => $userToUnfollow->id,
				'action_type' => 'dejó de seguir',
			]);
			
			return back()->with('success', 'Has dejado de seguir a ' . $userToUnfollow->name);
		}
		
		
	}
