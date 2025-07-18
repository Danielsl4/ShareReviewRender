<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Activity;
	use App\Models\Content;
	use App\Models\Review;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Log;
	
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
			
			DB::beginTransaction();  // Comienza la transacción
			
			try {
				// Intentar crear el contenido (Content)
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
				
				// Crear la reseña (Review)
				$review = Review::create([
					'content_id' => $content->id,
					'user_id' => auth()->id(),
					'body' => $request->input('body'),
					'rating' => $request->input('rating'),
				]);
				
				// Registrar la actividad (Activity)
				Activity::create([
					'user_id' => auth()->id(),
					'action_type' => 'publicó una reseña',
					'content_id' => $content->id,
					'review_id' => $review->id,
				]);
				
				DB::commit();  // Si todo ha ido bien, se confirma la transacción
				
				return redirect()->route('home')->with('success', 'Reseña publicada con éxito.');
			} catch (\Exception $e) {
				DB::rollBack();  // Si algo sale mal, revertir todo lo realizado en la transacción
				Log::error('Error al guardar la reseña: ' . $e->getMessage());  // Registra el error
				
				return redirect()->back()->withErrors(['error' => 'Hubo un error al guardar la reseña. Por favor, inténtalo de nuevo.']);
			}
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
