<x-layout>
	<h2 class="fw-bold text-xl text-gray-800 leading-tight">
		Editar Perfil de {{ $user->name }}
	</h2>
	
	<div class="py-4">
		<div class="container">
			
			@if(session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			
			<form method="POST" action="{{ route('settings.update', $user->id) }}" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				
				<div class="mb-4 text-center">
					<img
							src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('img/foto_perfil_por_defecto.png') }}"
							alt=""
							class="rounded-circle"
							style="width: 150px; height: 150px; object-fit: cover;">
					
					<div class="mt-2">
						<label for="profile_photo" class="btn btn-outline-secondary" style="cursor: pointer;">
							Cambiar imagen
						</label>
						<input type="file" name="profile_photo" id="profile_photo" class="d-none" accept="image/*">
					</div>
				</div>
				
				<div class="mb-3">
					<label for="name" class="form-label">Nombre</label>
					<input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
					       class="form-control @error('name') is-invalid @enderror" required>
					@error('name')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				
				<div class="mb-3">
					<label for="email" class="form-label">Correo electrónico</label>
					<input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
					       class="form-control @error('email') is-invalid @enderror" required>
					@error('email')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				
				<div class="mb-3">
					<label for="biography" class="form-label">Biografía</label>
					<input id="biography" name="biography" type="text" value="{{ old('biography', $user->biography) }}"
					       class="form-control @error('biography') is-invalid @enderror">
					@error('biography')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				
				<div class="d-flex justify-content-between mt-4 align-items-center">
					<button type="submit" class="btn btn-primary">
						Actualizar
					</button>
					
					<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
						Eliminar cuenta
					</button>
				</div>
			</form>
			
			<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
			     aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="confirmDeleteLabel">Confirmar eliminación</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
						</div>
						<div class="modal-body">
							¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
							
							<form method="POST" action="{{ route('settings.destroy', $user->id) }}">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger">
									Sí, estoy seguro
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-layout>
