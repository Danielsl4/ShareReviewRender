<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
	public function create() {
		return view('auth.login');
	}
	
	public function store(Request $request) {
		$campos = request()->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);
		
		if (!Auth::attempt($campos)) {
			throw ValidationException::withMessages([
				'email' => ['Sorry, those credentials do not match.'],
			]);
		}
		
		request()->session()->regenerate();
		
		return redirect()->route('home');
	}
	
	public function destroy() {
		
		Auth::logout();
		
		return redirect()->route('home');
	}
}
