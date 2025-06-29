<?php
	
	use App\Http\Controllers\ExplorerController;
	use App\Http\Controllers\FollowController;
	use App\Http\Controllers\LoginController;
	use App\Http\Controllers\ProblemController;
	use App\Http\Controllers\RegisterController;
	use App\Http\Controllers\ReviewController;
	use App\Http\Controllers\UserController;
	use App\Http\Controllers\ValorationController;
	use App\Http\Controllers\HomeController;
	use App\Http\Middleware\HandleDatabaseErrors;
	use Illuminate\Support\Facades\Route;

// Página principal
	Route::get('/', [HomeController::class, 'index'])->name('home');

// Explorador de contenido
	Route::get('/explorer', [ExplorerController::class, 'index'])->name('explorer');
	Route::get('/explorer/{type}/{id}', [ExplorerController::class, 'show'])->name('explorer.show');

// Acciones disponibles solo para usuarios autenticados
	Route::middleware('auth')->group(function () {
		
		// Página de actividad personal
		Route::get('/activity', [UserController::class, 'activity'])->name('activity');
		
		// Página con actividad de usuarios seguidos
		Route::get('/following', [FollowController::class, 'index'])->name('following');
		
		// Publicar reseña
		Route::middleware([HandleDatabaseErrors::class])->group(function () {
			Route::get('/publish/create', [ReviewController::class, 'create'])->name('publish.create');
			Route::post('/publish', [ReviewController::class, 'store'])->name('publish.store');
			Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
		});
		
		// Votar una reseña
		Route::post('/reviews/{id}/valoration', [ValorationController::class, 'vote'])->name('reviews.valoration');
		
		// Ajustes de perfil
		Route::get('/settings/{id}', [UserController::class, 'edit'])->name('settings.edit');
		Route::put('/settings/{id}', [UserController::class, 'update'])->name('settings.update');
		Route::delete('/settings/{user}', [UserController::class, 'destroy'])->name('settings.destroy');
		
		// Seguir y dejar de seguir usuarios
		Route::post('/users/{id}/follow', [UserController::class, 'follow'])->name('users.follow');
		Route::delete('/users/{id}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');
		
		// Reportar problemas (formulario y envío)
		Route::get('/problems/create', [ProblemController::class, 'create'])->name('problems.create');
		Route::post('/problems', [ProblemController::class, 'store'])->name('problems.store');
		
		// Vista solo para admins: gestión de problemas reportados
		Route::get('/problems/admin', [ProblemController::class, 'adminIndex'])->name('problems.admin');
	});

// Acciones solo disponibles para invitados (no autenticados)
	Route::middleware('guest')->group(function () {
		// Registrar una cuenta
		Route::get('/register', [RegisterController::class, 'create'])->name('register');
		Route::post('/register', [RegisterController::class, 'store']);
		
		// Iniciar sesión
		Route::get('/login', [LoginController::class, 'create'])->name('login');
		Route::post('/login', [LoginController::class, 'store']);
	});

// Cerrar sesión
	Route::delete('/logout', [LoginController::class, 'destroy'])->name('logout');

// Mostrar perfiles y relaciones sociales
	Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
	Route::get('/users/{id}/followers', [UserController::class, 'followers'])->name('users.followers');
	Route::get('/users/{id}/following', [UserController::class, 'following'])->name('users.following');

// Ver reseña individual
	Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('review.show');
