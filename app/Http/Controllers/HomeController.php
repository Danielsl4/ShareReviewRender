<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Review;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	
	class HomeController extends Controller {
		public function index(Request $request) {
			$order = $request->input('order');
			
			$reviews = Review::with(['content', 'user']);
			
			//cuando ordena por rating
			if ($order === 'rating') {
				$reviews->orderByDesc('rating');
				//por likes
			} elseif ($order === 'likes') {
				$reviews->withCount([
					'valorations as net_votes' => function ($query) {
						//calcula el total entre los +1 y -1
						$query->select(DB::raw("COALESCE(SUM(value), 0)"));
					}
				])->orderByDesc('net_votes');
			} else {
				$reviews->latest(); // recientes por defecto
			}
			
			return view('home', [
				'reviews' => $reviews->paginate(18),
			]);
		}
		
	}
