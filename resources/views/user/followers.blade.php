<x-layout>
	<div class="container py-4">
		<h2 class="mb-4">Seguidores de {{ $user->name }}</h2>
		
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
			@forelse ($followers as $follower)
				<div class="col">
					<div class="p-3 border rounded bg-white d-flex flex-column align-items-start gap-2 h-100">
						<div class="d-flex gap-3 align-items-start w-100">
							<img
									src="{{ $follower->profile_photo && $follower->profile_photo !== 'foto_perfil_por_defecto.png'
									? asset('storage/' . $follower->profile_photo)
									: asset('img/foto_perfil_por_defecto.png') }}"
									alt="Foto de perfil de {{ $follower->name }}"
									class="rounded-circle"
									style="width: 60px; height: 60px; object-fit: cover;">
							
							<div class="flex-grow-1">
								<a href="{{ route('users.show', $follower->id) }}" class="fw-bold text-dark text-decoration-none">
									{{ $follower->name }}
								</a>
								<p class="mb-0 text-muted">
									{{ $follower->biography ?? 'Sin biografía' }}
								</p>
							</div>
						</div>
						
						@auth
							@if (auth()->id() !== $follower->id)
								<form action="{{ auth()->user()->isFollowing($follower)
			? route('users.unfollow', $follower->id)
			: route('users.follow', $follower->id) }}"
								      method="POST"
								      class="w-100 text-end mt-auto">
									@csrf
									@if (auth()->user()->isFollowing($follower))
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
			@empty
				<p>No tiene seguidores.</p>
			@endforelse
		</div>
	</div>
</x-layout>
