<x-layout>
	<div class="container py-4">
		<div class="card mb-4">
			<div class="row g-0">
				<div class="col-md-4">
					<img src="{{ $content['cover'] }}" class="img-fluid rounded-start" alt="{{ $content['title'] }}">
				</div>
				
				<div class="col-md-8 d-flex flex-column justify-content-between">
					<div class="card-body">
						<h3 class="card-title">{{ $content['title'] }}</h3>
						<p><strong>Tipo:</strong> {{ ucfirst($content['type']) }}</p>
						<p><strong>Autor:</strong> {{ $content['author'] }}</p>
						<p><strong>Fecha de estreno:</strong> {{ $content['release_date'] }}</p>
						<p>{{ $content['description'] }}</p>
					</div>
					
					@php
						$localContent = \App\Models\Content::where('external_id', $content['id'])
							->where('type', $content['type'])
							->first();
						$avg = $localContent && $localContent->reviews()->count() > 0
							? $localContent->reviews()->avg('rating')
							: null;
						$count = $localContent?->reviews()->count() ?? 0;
					@endphp
					
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
						<a href="{{ route('publish.create', $content) }}" class="btn btn-primary">
							Escribir reseña
						</a>
						@if (!is_null($avg))
							@php
								$rating = $avg;
								$bgColor = match(true) {
									$rating >= 7 => 'bg-success text-white',
									$rating >= 5 => 'bg-warning text-dark',
									default => 'bg-danger text-white',
								};
							@endphp
							
							<span class="rounded px-2 py-1 {{ $bgColor }}"
							      style="min-width: 60px; text-align: center; font-weight: bold;">
								{{ number_format($rating, 1) }}
							</span>
						@endif
					</div>
				</div>
			</div>
		</div>
		
		@if ($localContent && $localContent->reviews->count() > 0)
			<h2>Total de reseñas: {{ $count }}</h2>
			@foreach ($localContent->reviews as $review)
				<div class="mb-3 p-3 border rounded">
					<div class="d-flex justify-content-between">
						<a href="{{ route('users.show', ['id' => $review->user->id]) }}"
						   class="fw-bold text-decoration-none text-dark">
							{{ $review->user->name }}
						</a>
						<span class="text-muted">{{ $review->created_at->format('d/m/Y') }}</span>
					</div>
					
					<div class="mt-2 d-inline-flex align-items-center gap-2">
						@php
							$score = $review->rating;
							$estrellaCompleta = floor($score / 2);
							$estrellaMitad = ($score % 2) >= 1;
							$estrellaVacia = 5 - $estrellaCompleta - ($estrellaMitad ? 1 : 0);
						@endphp
						<span class="d-inline-flex align-items-center text-warning" style="font-size: 1rem;">
							@for ($i = 0; $i < $estrellaCompleta; $i++)
								<x-estrellas tipo="llena"/>
							@endfor
							@if ($estrellaMitad)
								<x-estrellas tipo="media"/>
							@endif
							@for ($i = 0; $i < $estrellaVacia; $i++)
								<x-estrellas tipo="vacia"/>
							@endfor
						</span>
						<small class="d-inline-flex align-items-center gap-1">
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
					</div>
					<p class="mb-1">
						<a href="{{ route('review.show', $review->id) }}" class="text-decoration-none text-dark">
							{{ Str::limit($review->body, 200) }}
						</a>
					</p>
				</div>
			@endforeach
		@else
			<p class="text-muted">Este contenido aún no tiene reseñas.</p>
		@endif
	</div>
</x-layout>
