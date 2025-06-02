<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Share Review</title>
	<link rel="icon" href="{{ asset('favicon.png') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<nav class="py-2 bg-body-tertiary border-bottom">
	<div class="container d-flex flex-wrap">
		<ul class="nav me-auto">
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
		<ul class="nav">
			@auth
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle link-body-emphasis px-2 d-flex align-items-center" href="#" role="button"
					   data-bs-toggle="dropdown" aria-expanded="false">
						<img
								src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('img/foto_perfil_por_defecto.png') }}"
								alt=""
								class="rounded-circle me-2"
								style="width: 30px; height: 30px; object-fit: cover;">
						
						{{ Auth::user()->name }}
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li>
							<a href="{{ route('users.show', auth()->id()) }}" class="dropdown-item d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-person me-2" viewBox="0 0 16 16">
									<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
									<path fill-rule="evenodd"
									      d="M8 9a5 5 0 0 0-4.546 2.916A.5.5 0 0 0 3.5 13h9a.5.5 0 0 0 .046-.084A5 5 0 0 0 8 9z"/>
								</svg>
								Ver mi Perfil
							</a>
						</li>
						<li>
							<a href="{{ route('settings.edit', auth()->id()) }}" class="dropdown-item d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-gear me-2" viewBox="0 0 16 16">
									<path
											d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
									<path
											d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.54 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.54l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.434-2.54-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.69 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.69l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.69l.16.292c.415.764-.42 1.6-1.185 1.184l-.292-.159a1.873 1.873 0 0 0-2.69 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.69-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.292a1.873 1.873 0 0 0-1.116-2.69l-.318-.094c-.835-.246-.835-1.428 0-1.674l.319-.094a1.873 1.873 0 0 0 1.115-2.69l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.69-1.116l.094-.318z"/>
								</svg>
								Configurar Perfil
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('problems.create') }}" class="dropdown-item d-flex align-items-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-tools me-2"
								     viewBox="0 0 16 16">
									<path
											d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
								</svg>
								Reportar problema
							</a>
						</li>
						@auth
							@if (auth()->user()->admin)
								<li class="nav-item">
									<a href="{{ route('problems.admin') }}" class="dropdown-item d-flex align-items-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
										     class="bi bi-exclamation-triangle me-2"
										     viewBox="0 0 16 16">
											<path
													d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 11.856c.055.096.08.209.072.32a.5.5 0 0 1-.5.5H1.508a.5.5 0 0 1-.5-.5.638.638 0 0 1 .072-.32L7.938 2.016zm.562 10.982a.75.75 0 1 0-1.5 0 .75.75 0 0 0 1.5 0zm-.002-2.8a.535.535 0 0 0 .53-.598l-.35-3.507a.25.25 0 0 0-.25-.223h-.357a.25.25 0 0 0-.25.223l-.35 3.507a.535.535 0 0 0 .53.598z"/>
										</svg>
										Ir a ver problemas
									</a>
								</li>
							@endif
						@endauth
						<li>
							<form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center">
								@csrf
								@method('DELETE')
								<button class="dropdown-item d-flex align-items-center">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
									     class="bi bi-box-arrow-left me-2" viewBox="0 0 16 16">
										<path fill-rule="evenodd"
										      d="M6 3a1 1 0 0 1 1-1h5.5a.5.5 0 0 1 0 1H7a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h5.5a.5.5 0 0 1 0 1H7a1 1 0 0 1-1-1V3z"/>
										<path fill-rule="evenodd"
										      d="M11.854 8.354a.5.5 0 0 0 0-.708L9.172 5.964a.5.5 0 1 0-.708.708L10.293 8l-1.829 1.828a.5.5 0 0 0 .708.708l2.682-2.682z"/>
									</svg>
									Cerrar Sesión
								</button>
							</form>
						</li>
					
					</ul>
				</li>
			@else
				<li class="nav-item">
					<x-nav-link href="{{ route('login') }}">Iniciar Sesion</x-nav-link>
				</li>
				<li class="nav-item">
					<x-nav-link href="{{ route('register') }}">Registrarse</x-nav-link>
				</li>
			@endauth
		</ul>
	</div>
</nav>

<header class="py-3 mb-4 border-bottom">
	<div class="container d-flex flex-wrap justify-content-center">
		<a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
			<svg class="bi me-2" width="40" height="32" aria-hidden="true">
				<use xlink:href="#bootstrap"></use>
			</svg>
			<img src="{{ asset('img/logo.png') }}" alt="" width="120" height="40">
		</a>
		<form class="col-12 col-lg-auto mb-3 mb-lg-0" role="search" action="{{ route('explorer') }}" method="GET">
			<input type="search" name="q" class="form-control" placeholder="Buscar contenido..." aria-label="Buscar">
		</form>
	</div>
</header>

<main class="container">
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
