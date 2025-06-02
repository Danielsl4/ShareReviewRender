<x-layout>
	<div class="container py-4">
		<div class="card p-4">
			@if ($review->content?->cover)
				<img src="{{ $review->content->cover }}"
				     alt=""
				     class="mb-3 rounded object-cover"
				     style="width: 250px; height: 250px;">
			@endif
			
			<h2 class="h4 fw-bold mb-2">
				<a href="{{ route('explorer.show', ['type' => $review->content->type, 'id' => $review->content->external_id]) }}"
				   class="text-decoration-underline text-dark">
					{{ $review->content->title ?? 'Contenido no disponible' }}
				</a>
			</h2>
			
			<p class="mb-2">
				<strong>Autor de la reseña:</strong>
				<a href="{{ route('users.show', ['id' => $review->user->id]) }}"
				   class="text-decoration-none text-dark fw-semibold hover:text-primary">
					{{ $review->user->name }}
				</a>
				<br>
				<strong>Publicado el:</strong> {{ $review->created_at->format('d/m/Y') }}
			</p>
			
			@php
				$score = $review->rating;
				$estrellaCompleta = floor($score / 2);
				$estrellaMitad = ($score % 2) >= 1;
				$estrellaVacia = 5 - $estrellaCompleta - ($estrellaMitad ? 1 : 0);
			@endphp
			
			<div class="mb-3 d-flex align-items-center text-warning" style="font-size: 1rem;">
				@for ($i = 0; $i < $estrellaCompleta; $i++)
					<x-estrellas tipo="llena"></x-estrellas>
				@endfor
				
				@if ($estrellaMitad)
					<x-estrellas tipo="media"></x-estrellas>
				@endif
				
				@for ($i = 0; $i < $estrellaVacia; $i++)
					<x-estrellas tipo="vacia"></x-estrellas>
				@endfor
			</div>
			<hr>
			<p>{{ $review->body }}</p>
			<a href="{{ route('explorer.show', ['type' => $review->content->type, 'id' => $review->content->external_id]) }}"
			   class="btn btn-outline-secondary mt-3">
				Ver contenido
			</a>
			<div class="d-flex flex-column gap-2 mt-2">
				<a href="{{ route('problems.create', ['type' => 'reseña', 'report_id' => $review->id]) }}"
				   class="btn btn-outline-danger btn-sm">
					⚠️ Reportar reseña
				</a>
				@auth
					@if (auth()->id() === $review->user_id || auth()->user()->admin)
						<button type="button"
						        class="btn btn-outline-danger btn-sm w-100"
						        data-bs-toggle="modal"
						        data-bs-target="#confirmDeleteReviewModal">
							🗑️ Eliminar reseña
						</button>
					@endif
				@endauth
			
			</div>
		</div>
	</div>
	<div class="modal fade" id="confirmDeleteReviewModal" tabindex="-1" aria-labelledby="confirmDeleteReviewLabel"
	     aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="confirmDeleteReviewLabel">Confirmar eliminación</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
				</div>
				<div class="modal-body">
					¿Estás seguro de que quieres eliminar esta reseña? Esta acción no se puede deshacer.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger">
							Sí, eliminar reseña
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-layout>
