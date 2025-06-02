<x-layout>
	<div class="d-flex align-items-center justify-content-center gap-4 mb-4 flex-wrap text-center text-md-start">
		<img
				src="{{ $user->profile_photo && $user->profile_photo !== 'foto_perfil_por_defecto.png'
			? asset('storage/' . $user->profile_photo)
			: asset('img/foto_perfil_por_defecto.png') }}"
				alt="Foto de perfil de {{ $user->name }}"
				class="rounded-circle"
				style="width: 80px; height: 80px; object-fit: cover;">
		<div>
			<h2 class="h4 fw-bold text-uppercase mb-1">Perfil de {{ $user->name }}</h2>
			
			<div class="mb-2">
				<a href="{{ route('users.followers', $user->id) }}" class="me-3 text-reset">
					<strong>{{ $user->followers()->count() }}</strong> seguidores
				</a>
				<a href="{{ route('users.following', $user->id) }}" class="text-reset">
					<strong>{{ $user->following()->count() }}</strong> seguidos
				</a>
			</div>
			
			@auth
				@if (auth()->id() !== $user->id)
					<form action="{{ auth()->user()->isFollowing($user)
			? route('users.unfollow', $user->id)
			: route('users.follow', $user->id) }}"
					      method="POST"
					      class="text-start">
						
						@csrf
						@if (auth()->user()->isFollowing($user))
							@method('DELETE')
							<button type="submit" class="btn btn-sm btn-outline-secondary">
								Dejar de seguir
							</button>
						@else
							<button type="submit" class="btn btn-sm btn-outline-primary">
								Seguir
							</button>
						@endif
					</form>
				@endif
			@endauth
		</div>
	</div>
	<div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
		<div>
			<p class="mb-2"><strong>Biografía:</strong> {{ $user->biography ?? 'Sin biografía' }}</p>
		</div>
		
		@if (auth()->check())
			@if (auth()->id() == $user->id)
				<a href="{{ route('settings.edit', $user->id) }}"
				   class="btn btn-outline-secondary btn-sm mb-2">
					⚙️ Editar perfil
				</a>
			@elseif (auth()->user()->admin)
				<div class="d-flex gap-2 flex-wrap">
					<a href="{{ route('settings.edit', $user->id) }}"
					   class="btn btn-outline-secondary btn-sm mb-2">
						⚙️ Editar perfil
					</a>
					<a href="{{ route('problems.create', ['type' => 'usuario', 'report_id' => $user->id]) }}"
					   class="btn btn-outline-danger btn-sm mb-2">
						⚠️ Reportar usuario
					</a>
				</div>
			@else
				<a href="{{ route('problems.create', ['type' => 'usuario', 'report_id' => $user->id]) }}"
				   class="btn btn-outline-danger btn-sm mb-2">
					⚠️ Reportar usuario
				</a>
			@endif
		@endif
	</div>
	<hr class="my-6">
	
	<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
		<h3 class="text-xl font-bold mb-0">Reseñas de {{ $user->name }}</h3>
		
		<div class="text-muted small">
		<span class="me-3">
			<strong>{{ $totalReviews }}</strong> reseñas publicadas
		</span>
			@if (!is_null($averageRating))
				<span>
				Valoración media: <strong>{{ number_format($averageRating, 1) }}/10</strong>
			</span>
			@endif
		</div>
	</div>
	
	
	<div class="row">
		@forelse ($reviews as $review)
			<div class="col-md-4 mb-4">
				<div class="card p-3 h-100">
					<div class="d-flex">
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
									<a href="{{ route('review.show', $review) }}" class="text-decoration-none text-primary fw-semibold">
										Ver más
									</a>
								@endif
							</p>
							<div class="d-flex justify-content-between align-items-center mt-auto">
								<small class="text-muted">Publicado el {{ $review->created_at->format('d/m/Y') }}</small>
							</div>
						</div>
					</div>
				</div>
			</div>
		@empty
			<p>Este usuario aún no ha publicado ninguna reseña.</p>
		@endforelse
	</div>
	<div class="d-flex justify-content-center mt-4">
		{{ $reviews->links('pagination::bootstrap-4') }}
	</div>
</x-layout>
