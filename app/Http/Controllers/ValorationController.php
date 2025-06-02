<?php
	
	namespace App\Http\Controllers;
	
	namespace App\Http\Controllers;
	
	use App\Models\Activity;
	use App\Models\Review;
	use App\Models\Valoration;
	use Illuminate\Http\Request;
	
	class ValorationController extends Controller {
		
		public function vote(Request $request, $reviewId) {
			$value = (int)$request->input('value');
			$user = auth()->user();
			
			if (!in_array($value, [-1, 1])) {
				return back()->with('error', 'Valor no válido');
			}
			
			$review = Review::with('content')->findOrFail($reviewId);
			
			$existing = $review->valorations()->where('user_id', $user->id)->first();
			
			if ($existing) {
				if ($existing->value == $value) {
					$existing->delete(); // Quitar voto si pulsa el mismo
				} else {
					$existing->update(['value' => $value]); // Cambiar voto
				}
			} else {
				$review->valorations()->create([
					'user_id' => $user->id,
					'value' => $value,
				]);
				
				// Solo registrar si valora reseña de otro usuario
				if ($review->user_id != $user->id) {
					Activity::create([
						'user_id' => $user->id,
						'target_user_id' => $review->user_id,
						'action_type' => 'valoró una reseña',
						'content_id' => $review->content_id,
						'review_id' => $review->id,
					]);
				}
			}
			
			return back();
		}
	}
