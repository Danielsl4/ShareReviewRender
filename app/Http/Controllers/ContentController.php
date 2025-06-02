<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Http;
	
	class ContentController extends Controller {
		//Para buscar por la api
		public function search(Request $request) {
			$request->validate([
				'type' => 'required|in:movie,tv',
				'query' => 'required|string|min:2',
			]);
			
			$type = $request->query('type');
			$query = $request->query('query');
			
			$apiKey = env('TMDB_API_KEY');
			$url = "https://api.themoviedb.org/3/search/{$type}";
			
			$response = Http::get($url, [
				'api_key' => $apiKey,
				'query' => $query,
				'language' => 'es-ES'
			]);
			
			$results = $response->successful() ? $response->json()['results'] : [];
			
			return view('review.searchResults', [
				'type' => $type,
				'results' => $results
			]);
		}
		
	}
