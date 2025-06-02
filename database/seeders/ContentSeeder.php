<?php
	
	namespace Database\Seeders;
	
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\Http;
	use App\Models\Content;
	
	class ContentSeeder extends Seeder {
		public function run(): void {
			$this->seedMoviesFromTMDB();
			$this->seedGamesFromRAWG();
			$this->seedBooksFromGoogle();
		}
		
		private function seedMoviesFromTMDB() {
			$tmdbKey = env('TMDB_API_KEY');
			$response = Http::get("https://api.themoviedb.org/3/movie/popular", [
				'api_key' => $tmdbKey,
				'language' => 'es-ES',
			]);
			
			foreach ($response->json('results') ?? [] as $movie) {
				Content::create([
					'external_id' => $movie['id'],
					'title' => $movie['title'] ?? 'Sin título',
					'type' => 'movie',
					'author' => 'TMDB',
					'description' => $movie['overview'] ?? 'Sin descripción.',
					'cover' => $movie['poster_path']
						? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
						: null,
					'release_date' => $movie['release_date'] ?? null,
				]);
			}
		}
		
		private function seedGamesFromRAWG() {
			$rawgKey = env('RAWG_API_KEY');
			$response = Http::get("https://api.rawg.io/api/games", [
				'key' => $rawgKey,
			]);
			
			foreach ($response->json('results') ?? [] as $game) {
				Content::create([
					'external_id' => $game['id'],
					'title' => $game['name'] ?? 'Sin título',
					'type' => 'game',
					'author' => 'RAWG',
					'description' => 'Descripción no disponible.',
					'cover' => $game['background_image'] ?? null,
					'release_date' => $game['released'] ?? null,
				]);
			}
		}
		
		private function seedBooksFromGoogle() {
			$response = Http::get("https://www.googleapis.com/books/v1/volumes", [
				'q' => 'subject:fiction',
				'maxResults' => 10,
				'langRestrict' => 'es',
			]);
			
			foreach ($response->json('items') ?? [] as $item) {
				$info = $item['volumeInfo'] ?? [];
				
				Content::create([
					'external_id' => $item['id'],
					'title' => $info['title'] ?? 'Sin título',
					'type' => 'book',
					'author' => $info['authors'][0] ?? 'Desconocido',
					'description' => $info['description'] ?? 'Sin descripción.',
					'cover' => $info['imageLinks']['thumbnail'] ?? null,
					'release_date' => $info['publishedDate'] ?? null,
				]);
			}
		}
	}
