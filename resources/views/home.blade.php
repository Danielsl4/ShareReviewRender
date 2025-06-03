<x-layout>
	<div class="container py-4">
		@if (session('success'))
			<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
				{{ session('success') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
			</div>
		@endif
		
		@if (session('error'))
			<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
				{{ session('error') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
			</div>
		@endif
		@if (count($reviews) == 0)
			<p>No hay reseñas disponibles.</p>
		@else
			<div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
				<a href="{{ route('home') }}"
				   class="btn btn-outline-secondary px-4 py-2 {{ request('order') === null ? 'active' : '' }}">
					🆕 Recientes
				</a>
				<a href="{{ route('home', ['order' => 'rating']) }}"
				   class="btn btn-outline-primary px-4 py-2 {{ request('order') === 'rating' ? 'active' : '' }}">
					⭐ Mejor valoradas
				</a>
				<a href="{{ route('home', ['order' => 'likes']) }}"
				   class="btn btn-outline-primary px-4 py-2 {{ request('order') === 'likes' ? 'active' : '' }}">
					👍 Mejor votadas
				</a>
			</div>
			
			<div class="row">
				@foreach ($reviews as $review)
					<div class="col-12 mb-4">
						<div class="card p-3 h-100">
							<div class="d-flex">
								<!-- Imagen a la izquierda -->
								<div style="width: 33%;" class="pe-3 d-flex align-items-center justify-content-center">
									<div style="width: 90px; aspect-ratio: 2 / 3; overflow: hidden; border-radius: 0.5rem;">
										@if ($review->content?->cover)
											<img src="{{ $review->content->cover }}"
											     alt="{{ $review->content->title }}"
											     style="width: 100%; height: 100%; object-fit: cover;">
										@endif
									</div>
								</div>
								
								<div style="width: 66%;" class="d-flex flex-column justify-content-between">
									<h5 class="fw-bold mb-1">
										<a href="{{ route('explorer.show', ['type' => $review->content->type, 'id' => $review->content->external_id]) }}"
										   class="text-decoration-underline text-dark">
											{{ Str::limit($review->content->title ?? 'Contenido no disponible', 30) }}
										</a>
									</h5>
									@php
										$score = $review->rating;
										$estrellaCompleta = floor($score / 2);
										$estrellaMitad = ($score % 2) >= 1;
										$estrellaVacia = 5 - $estrellaCompleta - ($estrellaMitad ? 1 : 0);
									@endphp
									
									<div class="mb-1 d-flex align-items-center text-warning" style="font-size: 1rem;">
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
									
									<p class="mb-2">
										{{ Str::limit($review->body, 50) }}
										@if (Str::length($review->body) > 50)
											<a href="{{ route('review.show', $review) }}"
											   class="text-decoration-none text-primary fw-semibold">
												Ver más
											</a>
										@endif
									</p>
									<small>
										<form action="{{ route('reviews.valoration', $review->id) }}" method="POST" class="d-inline">
											@csrf
											<button name="value" value="1"
											        class="btn p-1 {{ auth()->check() && auth()->user()->valorationFor($review) === 1 ? 'text-success' : 'text-muted' }}">
												👍
											</button>
										</form>
										<form action="{{ route('reviews.valoration', $review->id) }}" method="POST" class="d-inline">
											@csrf
											<button name="value" value="-1"
											        class="btn p-1 {{ auth()->check() && auth()->user()->valorationFor($review) === -1 ? 'text-danger' : 'text-muted' }}">
												👎
											</button>
										</form>
										@php
											$valReseña = $review->netValorations();
											$claseValReseña = $valReseña > 0 ? 'bg-success' : ($valReseña < 0 ? 'bg-danger' : 'bg-secondary');
										@endphp
										
										<span class="badge {{ $claseValReseña }}">
											{{ $valReseña > 0 ? '+' . $valReseña : $valReseña }}
										</span>
									</small>
									<small class="text-muted">
										Por <a href="{{ route('users.show', ['id' => $review->user->id]) }}" class="text-decoration-none">
											{{ $review->user->name }}
										</a> el {{ $review->created_at->format('d/m/Y') }}
									</small>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="d-flex justify-content-center mt-4">
				{{ $reviews->appends(request()->query())->links('pagination::bootstrap-4') }}
			</div>
		@endif
	</div>
</x-layout>
