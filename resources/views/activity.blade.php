<x-layout>
	<div class="container py-4">
		<h1 class="h4 mb-4">Mi actividad</h1>
		
		@if ($activities->isEmpty())
			<p>No tienes actividad registrada aún.</p>
		@else
			@foreach ($activities as $activity)
				<div class="mb-3 border-bottom pb-2">
					@switch($activity->action_type)
						
						@case('publicó una reseña')
							<div class="d-flex align-items-start gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-journal-text" viewBox="0 0 16 16">
									<path
											d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
									<path
											d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
									<path
											d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
								</svg>
								<div>
									@if ($activity->user_id == auth()->id())
										<p class="mb-1">
											Publicaste una reseña sobre
											<a href="{{ route('explorer.show', ['type' => $activity->content->type, 'id' => $activity->content->external_id]) }}">
												{{ $activity->content->title ?? 'Contenido no disponible' }}
											</a>
											–
											<a href="{{ route('review.show', $activity->review->id) }}">ver reseña</a>
										</p>
									@else
										<p class="mb-1">
											<a href="{{ route('users.show', $activity->user->id) }}">{{ $activity->user->name }}</a>
											publicó una reseña sobre
											<a href="{{ route('explorer.show', ['type' => $activity->content->type, 'id' => $activity->content->external_id]) }}">
												{{ $activity->content->title ?? 'Contenido no disponible' }}
											</a>
											–
											<a href="{{ route('review.show', $activity->review->id) }}">ver reseña</a>
										</p>
									@endif
									<small class="text-muted">{{ $activity->created_at->format('d/m/Y H:i') }}</small>
								</div>
							</div>
							@break
						
						@case('valoró una reseña')
							<div class="d-flex align-items-start gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
									<path
											d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
								</svg>
								<div>
									@if ($activity->user_id == auth()->id())
										<p class="mb-1">
											Valoraste una reseña de
											<a href="{{ route('users.show', $activity->targetUser->id) }}">
												{{ $activity->targetUser->name }}
											</a> sobre
											<a href="{{ route('explorer.show', ['type' => $activity->content->type, 'id' => $activity->content->external_id]) }}">
												{{ $activity->content->title }}
											</a> –
											<a href="{{ route('review.show', $activity->review->id) }}">ver reseña</a>
										</p>
									@elseif ($activity->target_user_id == auth()->id())
										<p class="mb-1">
											<a href="{{ route('users.show', $activity->user->id) }}">
												{{ $activity->user->name }}
											</a> valoró tu reseña sobre
											<a href="{{ route('explorer.show', ['type' => $activity->content->type, 'id' => $activity->content->external_id]) }}">
												{{ $activity->content->title }}
											</a> –
											<a href="{{ route('review.show', $activity->review->id) }}">ver reseña</a>
										</p>
									@endif
									<small class="text-muted">{{ $activity->created_at->format('d/m/Y H:i') }}</small>
								</div>
							</div>
							@break
						
						@case('siguió a')
							<div class="d-flex align-items-start gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-person-plus flex-shrink-0 mt-1" viewBox="0 0 16 16">
									<path
											d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
								</svg>
								<div>
									@if ($activity->user_id == auth()->id())
										<p class="mb-1">
											Seguiste a <a
													href="{{ route('users.show', $activity->targetUser->id) }}">{{ $activity->targetUser->name }}</a>
										</p>
									@elseif ($activity->target_user_id == auth()->id())
										<p class="mb-1">
											<a href="{{ route('users.show', $activity->user->id) }}">{{ $activity->user->name }}</a> comenzó a
											seguirte
										</p>
									@endif
									<small class="text-muted">{{ $activity->created_at->format('d/m/Y H:i') }}</small>
								</div>
							</div>
							@break
						
						
						@case('dejó de seguir')
							<div class="d-flex align-items-start gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								     class="bi bi-person-dash flex-shrink-0 mt-1" viewBox="0 0 16 16">
									<path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
								</svg>
								<div>
									@if ($activity->user_id == auth()->id())
										<p class="mb-1">
											Dejaste de seguir a <a
													href="{{ route('users.show', $activity->targetUser->id) }}">{{ $activity->targetUser->name }}</a>
										</p>
									@elseif ($activity->target_user_id == auth()->id())
										<p class="mb-1">
											<a href="{{ route('users.show', $activity->user->id) }}">{{ $activity->user->name }}</a> dejó de
											seguirte
										</p>
									@endif
									<small class="text-muted">{{ $activity->created_at->format('d/m/Y H:i') }}</small>
								</div>
							</div>
							@break
					@endswitch
				</div>
			@endforeach
				<div class="d-flex justify-content-center mt-4">
					{{ $activities->links('pagination::bootstrap-4') }}
				</div>
		
		@endif
	</div>
</x-layout>