<x-layout>
	<div class="container py-4">
		<h1 class="mb-4">Explorar contenidos</h1>
		
		<div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
			<a href="{{ route('explorer') }}" class="btn btn-outline-secondary px-4 py-3 {{ request('type') === null ? 'active' : '' }}">
				Todos
			</a>
			<a href="{{ route('explorer', ['type' => 'movie']) }}" class="btn btn-outline-primary px-4 py-3 {{ request('type') === 'movie' ? 'active' : '' }}">
				🎬 Películas
			</a>
			<a href="{{ route('explorer', ['type' => 'tv']) }}" class="btn btn-outline-primary px-4 py-3 {{ request('type') === 'tv' ? 'active' : '' }}">
				📺 Series
			</a>
			<a href="{{ route('explorer', ['type' => 'book']) }}" class="btn btn-outline-primary px-4 py-3 {{ request('type') === 'book' ? 'active' : '' }}">
				📚 Libros
			</a>
			<a href="{{ route('explorer', ['type' => 'game']) }}" class="btn btn-outline-primary px-4 py-3 {{ request('type') === 'game' ? 'active' : '' }}">
				🎮 Videojuegos
			</a>
		</div>
		
		<div class="row">
			@foreach ($contents as $item)
				<div class="col-md-4 mb-4">
					<div class="card p-3 h-100">
						<div class="d-flex">
							<!-- Imagen izquierda -->
							<div style="width: 33%;" class="pe-3 d-flex align-items-center justify-content-center">
								<div style="width: 90px; aspect-ratio: 2 / 3; overflow: hidden; border-radius: 0.5rem;">
									<img src="{{ $item['cover'] }}" alt="{{ $item['title'] }}"
									     style="width: 100%; height: 100%; object-fit: cover;">
								</div>
							</div>
							
							<!-- Contenido derecha -->
							<div style="width: 66%;" class="d-flex flex-column justify-content-between">
								<div>
									<h5 class="fw-bold mb-1">
										<a href="{{ route('explorer.show', ['type' => $item['type'], 'id' => $item['id']]) }}"
										   class="text-decoration-underline text-dark">
											{{ Str::limit($item['title'], 30) }}
										</a>
									</h5>
									<p class="mb-2">
										{{ Str::limit($item['description'] ?: 'Descripción disponible en ver más', 50) }}
									</p>
								</div>
								
								<div class="d-flex justify-content-between align-items-center mt-2">
									<div class="d-flex gap-2">
										<a href="{{ route('publish.create', $item) }}" class="btn btn-primary btn-sm">
											Escribir reseña
										</a>
									</div>
									
									@if (!is_null($item['rating_avg']))
										@php
											$rating = $item['rating_avg'];
											$bgColor = match(true) {
													$rating >= 7 => 'bg-success text-white',
													$rating >= 5 => 'bg-warning text-dark',
													default => 'bg-danger text-white',
											};
										@endphp
										
										<div class="rounded px-2 py-1 {{ $bgColor }}"
										     style="min-width: 60px; text-align: center; font-weight: bold;">
											{{ number_format($rating, 1) }}
										</div>
									@endif
								
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</x-layout>
