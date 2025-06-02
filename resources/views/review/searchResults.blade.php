<x-layout>
	<h2>Resultados de búsqueda</h2>
	
	@if(count($results) === 0)
		<p>No se encontraron resultados.</p>
	@else
		<ul class="space-y-4">
			@foreach($results as $item)
				<li class="border p-4 rounded bg-white shadow">
					<h3 class="text-xl font-bold">
						{{ $item['title'] ?? $item['name'] }}
					</h3>
					
					<p class="text-sm text-gray-600 italic mb-2">
						{{ $item['overview'] ?: 'Sin descripción disponible.' }}
					</p>
					
					@if($item['poster_path'])
						<img src="https://image.tmdb.org/t/p/w200{{ $item['poster_path'] }}" alt="Poster" class="mb-2">
					@endif
					
					<p><strong>Fecha de estreno:</strong>
						{{ $item['release_date'] ?? $item['first_air_date'] ?? 'Desconocida' }}
					</p>
					
					<form method="GET" action="{{ route('publish.create') }}">
						<input type="hidden" name="title" value="{{ $item['title'] ?? $item['name'] }}">
						<input type="hidden" name="type" value="{{ $type }}">
						<input type="hidden" name="description" value="{{ $item['overview'] ?? 'Sin descripción disponible.' }}">
						<input type="hidden" name="cover" value="https://image.tmdb.org/t/p/w500{{ $item['poster_path'] ?? '' }}">
						<input type="hidden" name="release_date" value="{{ $item['release_date'] ?? $item['first_air_date'] ?? null }}">
						<input type="hidden" name="author" value="">
						<button type="submit" class="mt-2 bg-blue-500 text-black px-3 py-1 rounded">
							Seleccionar
						</button>
					</form>
				
				</li>
			@endforeach
		</ul>
	@endif
</x-layout>
