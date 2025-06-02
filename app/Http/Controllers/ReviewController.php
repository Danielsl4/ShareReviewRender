<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Activity;
	use App\Models\Content;
	use App\Models\Review;
	use Illuminate\Http\Request;
	
	class ReviewController extends Controller {
		public function create(Request $request) {
			$content = new Content([
				'external_id' => $request->input('id'),
				'title' => $request->input('title'),
				'type' => $request->input('type'),
				'author' => $request->input('author'),
				'description' => $request->input('description'),
				'cover' => $request->input('cover'),
				'release_date' => $request->input('release_date'),
			]);
			
			return view('review.create', ['content' => $content]);
		}
		
		public function store(Request $request) {
			$request->validate([
				'external_id' => 'required|string|max:255',
				'title' => 'required|string|max:255',
				'type' => 'required|in:movie,tv,game,book',
				'author' => 'nullable|string|max:255',
				'description' => 'nullable|string',
				'cover' => 'nullable|string',
				'release_date' => 'nullable|date',
				'body' => 'required|string|min:5',
				'rating' => 'required|integer|between:0,10',
			]);
			
			$content = Content::firstOrCreate(
				[
					'external_id' => $request->input('external_id'),
					'type' => $request->input('type'),
				],
				[
					'title' => $request->input('title'),
					'author' => $request->input('author'),
					'description' => $request->input('description'),
					'cover' => $request->input('cover'),
					'release_date' => $request->input('release_date'),
				]
			);
			
			$review = Review::create([
				'content_id' => $content->id,
				'user_id' => auth()->id(),
				'body' => $request->input('body'),
				'rating' => $request->input('rating'),
			]);
			
			Activity::create([
				'user_id' => auth()->id(),
				'action_type' => 'publicó una reseña',
				'content_id' => $content->id,
				'review_id' => $review->id,
			]);
			
			return redirect()->route('home')->with('success', 'Reseña publicada con éxito.');
		}
		
		public function show(Review $review) {
			$review->load('user', 'content');
			
			return view('review.show', ['review' => $review]);
		}
		
		public function destroy(Review $review) {
			if (auth()->id() != $review->user_id && !auth()->user()->admin) {
				abort(403, 'No tienes permiso para eliminar esta reseña.');
			}
			
			$review->delete();
			
			return redirect()->route('home')->with('success', 'Reseña eliminada correctamente.');
		}
		
		
	}
