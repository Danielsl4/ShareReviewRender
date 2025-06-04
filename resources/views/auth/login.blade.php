<x-layout title="Login">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-5">
				<div class="card shadow p-4">
					<h2 class="text-center mb-4 fw-bold">Iniciar sesión</h2>
					
					<form method="POST" action="{{ route('login') }}">
						@csrf
						
						<div class="mb-3">
							<label for="email" class="form-label">Correo electrónico</label>
							<input
									type="email"
									id="email"
									name="email"
									class="form-control @error('email') is-invalid @enderror"
									required
									autofocus
							>
							@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="mb-3">
							<label for="password" class="form-label">Contraseña</label>
							<input
									type="password"
									id="password"
									name="password"
									class="form-control @error('password') is-invalid @enderror"
									required
							>
							@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="d-flex justify-content-center justify-content-sm-end">
							<button type="submit" class="btn btn-dark px-4">
								Iniciar sesión
							</button>
						</div>
					</form>
					
					<div class="text-center mt-4">
						<span class="text-muted">¿No tienes cuenta?</span>
						<a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
							Vamos a crearla
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layout>
