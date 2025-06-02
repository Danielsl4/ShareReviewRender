<x-layout>
	<div class="container py-4">
		<h2 class="h5 fw-bold mb-3">Reportar un problema</h2>
		
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul class="mb-0">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		
		<form method="POST" action="{{ route('problems.store') }}">
			@csrf
			
			<div class="mb-3">
				<label class="form-label">Tipo de problema</label>
				<select name="type" class="form-select" required>
					<option value="usuario" {{ old('type', request('type')) == 'usuario' ? 'selected' : '' }}>Usuario</option>
					<option value="reseña" {{ old('type', request('type')) == 'reseña' ? 'selected' : '' }}>Reseña</option>
					<option value="otro" {{ old('type', request('type')) == 'otro' ? 'selected' : '' }}>Otro</option>
				</select>
			</div>
			
			<div class="mb-3">
				<label class="form-label">ID relacionado (usuario o reseña)</label>
				<input type="number" name="report_id" class="form-control"
				       value="{{ old('report_id', request('report_id')) }}">
			</div>
			
			<div class="mb-3">
				<label class="form-label">Descripción del problema</label>
				<textarea name="body" rows="5" class="form-control" required>{{ old('body') }}</textarea>
			</div>
			
			<button type="submit" class="btn btn-danger">Enviar reporte</button>
		</form>
	</div>
</x-layout>
