<x-layout>
	<div class="container py-4">
		<h2 class="h4 mb-4 fw-bold text-center">Crear reseña</h2>
		
		<div class="card mb-4 shadow-sm p-4">
			<div class="row">
				@if($content->cover)
					<div class="col-md-3 text-center mb-3 mb-md-0">
						<img src="{{ $content->cover }}" alt="Imagen" class="img-fluid rounded" style="max-height: 240px; object-fit: cover;">
					</div>
				@endif
				
				<div class="col-md-9">
					<h3 class="h5">{{ $content->title }}</h3>
					<p class="mb-1"><strong>Tipo:</strong> {{ ucfirst($content->type) }}</p>
					<p class="mb-1"><strong>Autor:</strong> {{ $content->author }}</p>
					<p class="mb-1"><strong>Descripción:</strong> {{ $content->description }}</p>
					<p class="mb-0"><strong>Fecha de estreno:</strong> {{ \Carbon\Carbon::parse($content->release_date)->format('d/m/Y') }}</p>
				</div>
			</div>
		</div>
		
		<form method="POST" action="{{ route('publish.store') }}" class="card p-4 shadow-sm">
			@csrf
			
			<input type="hidden" name="external_id" value="{{ $content->external_id }}">
			<input type="hidden" name="title" value="{{ $content->title }}">
			<input type="hidden" name="type" value="{{ $content->type }}">
			<input type="hidden" name="author" value="{{ $content->author }}">
			<input type="hidden" name="description" value="{{ $content->description }}">
			<input type="hidden" name="cover" value="{{ $content->cover }}">
			<input type="hidden" name="release_date" value="{{ $content->release_date }}">
			
			<div class="mb-3">
				<label for="body" class="form-label fw-semibold">Tu reseña</label>
				<textarea name="body" class="form-control" rows="5" required></textarea>
			</div>
			
			<div class="mb-3">
				<label for="rating" class="form-label fw-semibold">Puntuación (0 a 10)</label>
				<input type="number" name="rating" min="0" max="10" step="1" class="form-control w-25" required>
			</div>
			
			<div class="text-end">
				<button type="submit" class="btn btn-success px-4 py-2">Publicar reseña</button>
			</div>
		</form>
	</div>
</x-layout>
