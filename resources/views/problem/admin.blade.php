<x-layout>
	<div class="container py-4">
		<h2 class="h5 fw-bold mb-4">Lista de reportes</h2>
		
		@forelse ($problems as $problem)
			<div class="border rounded p-3 mb-3">
				
				<p><strong>Usuario que reporta:</strong>
					<a href="{{ route('users.show', $problem->user->id) }}" class="text-decoration-none">
						{{ $problem->user->name }}
					</a>
				</p>
				
				<p><strong>Tipo de problema:</strong> {{ ucfirst($problem->type) }}</p>
				
				@if ($problem->type == 'usuario' && $problem->report_id)
					<p><strong>Usuario reportado:</strong>
						<a href="{{ route('users.show', $problem->report_id) }}" class="text-decoration-none">
							Usuario #{{ $problem->report_id }}
						</a>
					</p>
				@elseif ($problem->type == 'reseña' && $problem->report_id)
					<p><strong>Reseña reportada:</strong>
						<a href="{{ route('review.show', ['review' => $problem->report_id]) }}" class="text-decoration-none">
							Reseña #{{ $problem->report_id }}
						</a>
					</p>
				@endif
				
				<p><strong>Descripción:</strong> {{ $problem->body }}</p>
				
				<p class="text-muted"><small>{{ $problem->created_at->format('d/m/Y H:i') }}</small></p>
			</div>
		@empty
			<p>No se han reportado problemas.</p>
		@endforelse
		
		<div class="d-flex justify-content-center mt-4">
			{{ $problems->links('pagination::bootstrap-4') }}
		</div>
	</div>
</x-layout>
