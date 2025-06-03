<x-layout>
	<div class="container py-4">
		<h1 class="h4 mb-4">Actividad de usuarios que sigues</h1>
		
		@if ($activities->isEmpty())
			<p>No hay actividad reciente.</p>
		@else
			@foreach ($activities as $activity)
				<div class="d-flex mb-3 p-3 border rounded align-items-center">
					<img
							src="{{ $activity->user->profile_photo && $activity->user->profile_photo !== 'foto_perfil_por_defecto.png'
							? asset('storage/' . $activity->user->profile_photo)
							: asset('img/foto_perfil_por_defecto.png') }}"
							alt="Foto de perfil de {{ $activity->user->name }}"
							class="rounded-circle me-3"
							style="width: 50px; height: 50px; object-fit: cover;">
					
					<div>
						<p class="mb-1">
							<a href="{{ route('users.show', $activity->user->id) }}" class="fw-semibold text-decoration-none text-dark">
								{{ $activity->user->name }}
							</a>
							
							{{ $activity->action_type }}
							
							@if ($activity->content)
								sobre
								<a href="{{ route('explorer.show', ['type' => $activity->content->type, 'id' => $activity->content->external_id]) }}"
								   class="text-decoration-none">
									{{ $activity->content->title ?? 'Contenido no disponible' }}
								</a>
							@endif
							
							@if ($activity->action_type === 'publicó una reseña' && $activity->review)
								–
								<a href="{{ route('review.show', $activity->review->id) }}" class="text-decoration-none text-primary">
									ver reseña
								</a>
							@endif
							
							@if ($activity->target_user_id)
								@php $target = \App\Models\User::find($activity->target_user_id); @endphp
								@if ($target)
									→
									<a href="{{ route('users.show', ['id' => $target->id]) }}" class="text-decoration-none">
										{{ $target->name }}
									</a>
								@endif
							@endif
						</p>
						
						
						<div class="text-muted small">
							{{ $activity->created_at->diffForHumans() }}
						</div>
					</div>
				</div>
			@endforeach
			
			<div class="d-flex justify-content-center mt-4">
				{{ $activities->links('pagination::bootstrap-4') }}
			</div>
		@endif
	</div>
</x-layout>