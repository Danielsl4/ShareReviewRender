<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Share Review</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ asset('favicon.png') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9873526213939864"
     crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
	<div class="container d-flex justify-content-between align-items-center">
		<a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
			<img src="{{ asset('img/logo.png') }}" alt="Logo" width="120" height="40">
		</a>
		
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
		        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<x-nav-link href="{{ route('home') }}">Inicio</x-nav-link>
				</li>
				<li class="nav-item">
					<x-nav-link href="{{ route('explorer') }}">Explorar</x-nav-link>
				</li>
				<li class="nav-item">
					<x-nav-link href="{{ route('activity') }}">Mi actividad</x-nav-link>
				</li>
				<li class="nav-item">
					<x-nav-link href="{{ route('following') }}">Siguiendo</x-nav-link>
				</li>
			</ul>
			
			<ul class="navbar-nav">
				@auth
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"
						   aria-expanded="false">
							<img
									src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('img/foto_perfil_por_defecto.png') }}"
									alt=""
									class="rounded-circle me-2"
									style="width: 30px; height: 30px; object-fit: cover;">
							{{ Auth::user()->name }}
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a href="{{ route('users.show', auth()->id()) }}" class="dropdown-item">Ver mi Perfil</a></li>
							<li><a href="{{ route('settings.edit', auth()->id()) }}" class="dropdown-item">Configurar Perfil</a></li>
							<li><a href="{{ route('problems.create') }}" class="dropdown-item">Reportar problema</a></li>
							@if (auth()->user()->admin)
								<li><a href="{{ route('problems.admin') }}" class="dropdown-item">Ir a ver problemas</a></li>
							@endif
							<li>
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									@method('DELETE')
									<button class="dropdown-item">Cerrar Sesión</button>
								</form>
							</li>
						</ul>
					</li>
				@else
					<li class="nav-item">
						<x-nav-link href="{{ route('login') }}">Iniciar Sesión</x-nav-link>
					</li>
					<li class="nav-item">
						<x-nav-link href="{{ route('register') }}">Registrarse</x-nav-link>
					</li>
				@endauth
			</ul>
		</div>
	</div>
</nav>

<header class="py-3 mb-4 border-bottom">
	<div class="container">
		<form class="col-12" role="search" action="{{ route('explorer') }}" method="GET">
			<input type="search" name="q" class="form-control" placeholder="Buscar contenido..." aria-label="Buscar">
		</form>
	</div>
</header>


<main class="container flex-grow-1">
	{{ $slot }}
</main>

<footer class="bg-dark text-center text-muted py-4 border-top mt-5">
	<div class="container">
		<p class="text-white mb-2">© 2025 ShareReview — Todos los derechos reservados</p>
		<div class="d-flex justify-content-center flex-wrap gap-3 small">
			<a href="{{ route('home') }}" class="text-white text-decoration-none">Inicio</a>
			<a href="{{ route('explorer') }}" class="text-white text-decoration-none">Explorar</a>
			<a href="#" class="text-white text-decoration-none">Términos</a>
			<a href="#" class="text-white text-decoration-none">Privacidad</a>
			<a href="#" class="text-white text-decoration-none">Contacto</a>
		</div>
	</div>
</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
