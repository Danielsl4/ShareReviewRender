<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Content;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Http;
	
	class ExplorerController extends Controller {
		public function index(Request $request) {
			$query = $request->input('q');
			$contents = [];
			
			// TMDB
			$tmdbKey = env('TMDB_API_KEY');
			if ($query) {
				// Búsqueda personalizada
				$tmdbMovies = Http::get("https://api.themoviedb.org/3/search/movie", [
					'api_key' => $tmdbKey,
					'language' => 'es-ES',
					'query' => $query
				])->json()['results'] ?? [];
				
				$tmdbSeries = Http::get("https://api.themoviedb.org/3/search/tv", [
					'api_key' => $tmdbKey,
					'language' => 'es-ES',
					'query' => $query
				])->json()['results'] ?? [];
			} else {
				// Populares por defecto
				$tmdbMovies = Http::get("https://api.themoviedb.org/3/movie/popular", [
					'api_key' => $tmdbKey,
					'language' => 'es-ES'
				])->json()['results'] ?? [];
				
				$tmdbSeries = Http::get("https://api.themoviedb.org/3/tv/popular", [
					'api_key' => $tmdbKey,
					'language' => 'es-ES'
				])->json()['results'] ?? [];
			}
			
			foreach ($tmdbMovies as $movie) {
				$localContent = Content::where('external_id', $movie['id'])->where('type', 'movie')->first();
				$ratingAvg = $localContent && $localContent->reviews()->count() > 0
					? $localContent->reviews()->avg('rating')
					: null;
				
				$contents[] = [
					'id' => $movie['id'],
					'title' => $movie['title'],
					'type' => 'movie',
					'author' => 'TMDB',
					'description' => $movie['overview'] ?? 'Descripción no disponible',
					'cover' => 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'],
					'release_date' => $movie['release_date'] ?? '',
					'rating_avg' => $ratingAvg,
				];
			}
			
			foreach ($tmdbSeries as $serie) {
				$localContent = Content::where('external_id', $serie['id'])->where('type', 'tv')->first();
				$ratingAvg = $localContent && $localContent->reviews()->count() > 0
					? $localContent->reviews()->avg('rating')
					: null;
				
				$contents[] = [
					'id' => $serie['id'],
					'title' => $serie['name'],
					'type' => 'tv',
					'author' => 'TMDB',
					'description' => $serie['overview'] ?? 'Descripción no disponible',
					'cover' => 'https://image.tmdb.org/t/p/w500' . $serie['poster_path'],
					'release_date' => $serie['first_air_date'] ?? '',
					'rating_avg' => $ratingAvg,
				];
			}
			
			
			// RAWG
			$rawgKey = env('RAWG_API_KEY');
			$games = Http::get("https://api.rawg.io/api/games", [
				'key' => $rawgKey,
				'search' => $query
			])->json()['results'] ?? [];
			
			foreach ($games as $game) {
				$localContent = Content::where('external_id', $game['id'])->where('type', 'game')->first();
				$ratingAvg = $localContent && $localContent->reviews()->count() > 0
					? $localContent->reviews()->avg('rating')
					: null;
				
				$contents[] = [
					'id' => $game['id'],
					'title' => $game['name'],
					'type' => 'game',
					'author' => 'RAWG',
					'description' => '',
					'cover' => $game['background_image'],
					'release_date' => $game['released'] ?? '',
					'rating_avg' => $ratingAvg,
				];
			}
			
			// Google Books
			if ($query) {
				$googleBooks = Http::get("https://www.googleapis.com/books/v1/volumes", [
					'q' => $query,
					'maxResults' => 12
				])->json()['items'] ?? [];
			} else {
				$googleBooks = Http::get("https://www.googleapis.com/books/v1/volumes", [
					'q' => 'subject:fiction',
					'maxResults' => 12
				])->json()['items'] ?? [];
			}
			
			foreach ($googleBooks as $book) {
				$volume = $book['volumeInfo'];
				
				$localContent = Content::where('external_id', $book['id'])->where('type', 'book')->first();
				$ratingAvg = $localContent && $localContent->reviews()->count() > 0
					? $localContent->reviews()->avg('rating')
					: null;
				
				$contents[] = [
					'id' => $book['id'],
					'title' => $volume['title'],
					'type' => 'book',
					'author' => $volume['authors'][0] ?? 'Desconocido',
					'description' => $volume['description'] ?? '',
					'cover' => $volume['imageLinks']['thumbnail'] ?? '',
					'release_date' => $volume['publishedDate'] ?? '',
					'rating_avg' => $ratingAvg,
				];
			}
			
			shuffle($contents);
			
			//para el filtro de buscar entre las cosas
			$typeFilter = $request->input('type');
			
			if ($typeFilter) {
				$contents = array_filter($contents, function ($item) use ($typeFilter) {
					return $item['type'] === $typeFilter;
				});
			}
			
			return view('explorer', ['contents' => $contents]);
		}
		
		
		public function show($type, $id) {
			$content = null;
			
			if ($type == 'movie' || $type == 'tv') {
				$tmdbKey = env('TMDB_API_KEY');
				$endpoint = $type == 'movie' ? 'movie' : 'tv';
				$response = Http::get("https://api.themoviedb.org/3/{$endpoint}/{$id}", [
					'api_key' => $tmdbKey,
					'language' => 'es-ES',
				])->json();
				
				$content = [
					'id' => $id,
					'title' => $response['title'] ?? $response['name'],
					'type' => $type,
					'author' => 'TMDB',
					'description' => $response['overview'] ?? '',
					'cover' => 'https://image.tmdb.org/t/p/w500' . $response['poster_path'],
					'release_date' => $response['release_date'] ?? $response['first_air_date'] ?? '',
				];
			}
			
			if ($type == 'game') {
				$rawgKey = env('RAWG_API_KEY');
				$response = Http::get("https://api.rawg.io/api/games/{$id}", [
					'key' => $rawgKey,
				])->json();
				
				$content = [
					'id' => $id,
					'title' => $response['name'],
					'type' => 'game',
					'author' => 'RAWG',
					'description' => $response['description_raw'] ?? '',
					'cover' => $response['background_image'],
					'release_date' => $response['released'] ?? '',
				];
			}
			
			if ($type == 'book') {
				$response = Http::get("https://www.googleapis.com/books/v1/volumes/{$id}")->json();
				$volume = $response['volumeInfo'] ?? [];
				
				$content = [
					'id' => $id,
					'title' => $volume['title'],
					'type' => 'book',
					'author' => $volume['authors'][0] ?? 'Desconocido',
					'description' => $volume['description'] ?? '',
					'cover' => $volume['imageLinks']['thumbnail'] ?? '',
					'release_date' => $volume['publishedDate'] ?? '',
				];
			}
			
			$localContent = Content::where('external_id', $id)
				->where('type', $type)
				->with('reviews.user')
				->first();
			
			return view('explorer.show', [
				'content' => $content,
				'localContent' => $localContent
			]);
		}
		
		private function getMovies($query) {
			$tmdbKey = env('TMDB_API_KEY');
			$endpoint = $query
				? 'https://api.themoviedb.org/3/search/movie'
				: 'https://api.themoviedb.org/3/movie/popular';
			
			$response = Http::get($endpoint, [
				'api_key' => $tmdbKey,
				'query' => $query,
			])->json()['results'] ?? [];
			
			$contents = [];
			
			foreach ($response as $movie) {
				$contents[] = [
					'id' => $movie['id'],
					'title' => $movie['title'],
					'type' => 'movie',
					'author' => 'TMDB',
					'description' => $movie['overview'] ?: 'Descripción no disponible',
					'cover' => 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'],
					'release_date' => $movie['release_date'] ?? '',
					'rating_avg' => null,
				];
			}
			
			return $contents;
		}
		
		private function getSeries($query) {
			$tmdbKey = env('TMDB_API_KEY');
			$endpoint = $query
				? 'https://api.themoviedb.org/3/search/tv'
				: 'https://api.themoviedb.org/3/tv/popular';
			
			$response = Http::get($endpoint, [
				'api_key' => $tmdbKey,
				'query' => $query,
			])->json()['results'] ?? [];
			
			$contents = [];
			
			foreach ($response as $series) {
				$contents[] = [
					'id' => $series['id'],
					'title' => $series['name'],
					'type' => 'tv',
					'author' => 'TMDB',
					'description' => $series['overview'] ?: 'Descripción no disponible',
					'cover' => 'https://image.tmdb.org/t/p/w500' . $series['poster_path'],
					'release_date' => $series['first_air_date'] ?? '',
					'rating_avg' => null,
				];
			}
			
			return $contents;
		}
		
		private function getBooks($query) {
			$bookQuery = $query ?: 'libros recomendados';
			
			$response = Http::get('https://www.googleapis.com/books/v1/volumes', [
				'q' => $bookQuery,
				'maxResults' => 12,
			])->json()['items'] ?? [];
			
			$contents = [];
			
			foreach ($response as $book) {
				$info = $book['volumeInfo'] ?? [];
				
				$contents[] = [
					'id' => $book['id'],
					'title' => $info['title'] ?? 'Sin título',
					'type' => 'book',
					'author' => $info['authors'][0] ?? 'Desconocido',
					'description' => $info['description'] ?? 'Descripción no disponible',
					'cover' => $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/128x193?text=Sin+Portada',
					'release_date' => $info['publishedDate'] ?? '',
					'rating_avg' => null,
				];
			}
			
			return $contents;
		}
		
		
		private function getGames($query) {
			$rawgKey = env('RAWG_API_KEY');
			$gameQuery = $query ?: 'popular';
			
			$response = Http::get("https://api.rawg.io/api/games", [
				'key' => $rawgKey,
				'search' => $gameQuery,
				'page_size' => 12,
			])->json()['results'] ?? [];
			
			$contents = [];
			
			foreach ($response as $game) {
				$contents[] = [
					'id' => $game['id'],
					'title' => $game['name'],
					'type' => 'game',
					'author' => 'RAWG',
					'description' => $game['description_raw'] ?? 'Descripción no disponible',
					'cover' => $game['background_image'],
					'release_date' => $game['released'] ?? '',
					'rating_avg' => null,
				];
			}
			
			return $contents;
		}
		
		
		private function loadContentByType($type, $query) {
			$contents = [];
			
			switch ($type) {
				case 'movie':
					$contents = $this->getMovies($query);
					break;
				
				case 'tv':
					$contents = $this->getSeries($query);
					break;
				
				case 'book':
					$contents = $this->getBooks($query);
					break;
				
				case 'game':
					$contents = $this->getGames($query);
					break;
				
				default:
					$contents = array_merge(
						$this->getMovies($query),
						$this->getSeries($query),
						$this->getBooks($query),
						$this->getGames($query),
					);
					break;
			}
			
			return $contents;
		}
		
		
	}
