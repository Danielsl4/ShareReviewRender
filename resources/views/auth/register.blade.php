<x-layout title="Register">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-6 col-lg-5">
				<div class="card shadow p-4">
					<h2 class="text-center mb-4 fw-bold">Crear cuenta</h2>
					
					<form method="POST" action="{{ route('register') }}">
						@csrf
						
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input
									type="text"
									id="name"
									name="name"
									class="form-control @error('name') is-invalid @enderror"
									required
							>
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="mb-3">
							<label for="email" class="form-label">Correo electrónico</label>
							<input
									type="email"
									id="email"
									name="email"
									class="form-control @error('email') is-invalid @enderror"
									required
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
						
						<div class="mb-4">
							<label for="password_confirmation" class="form-label">Confirmar contraseña</label>
							<input
									type="password"
									id="password_confirmation"
									name="password_confirmation"
									class="form-control @error('password_confirmation') is-invalid @enderror"
									required
							>
							@error('password_confirmation')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="d-flex justify-content-center justify-content-sm-end">
							<button type="submit" class="btn btn-dark px-4">
								Crear cuenta
							</button>
						</div>
					</form>
					
					<div class="text-center mt-4">
						<span class="text-muted">¿Ya tienes cuenta?</span>
						<a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
							Inicia sesión
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layout>
