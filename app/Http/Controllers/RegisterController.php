<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Validation\Rules\Password;
	
	class RegisterController extends Controller {
		public function create() {
			return view('auth.register');
		}
		
		public function store(Request $request) {
			
			$campos = request()->validate([
				'name' => 'required|unique:users',
				'email' => 'required|email|unique:users,email',
				'password' => [Password::min(6), 'confirmed:password_confirmation']
			]);
			
			$campos['password'] = Hash::make($request->password);
			
			$user = User::create($campos);
			
			Auth::login($user);
			Auth::user()->refresh();
			
			return redirect()->route('home');
		}
	}
