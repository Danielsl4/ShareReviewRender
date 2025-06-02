<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	
	class Valoration extends Model
	{
		protected $fillable = [
			'user_id',
			'review_id',
			'value',
		];
		
		public function user(): BelongsTo {
			return $this->belongsTo(User::class);
		}
		
		public function review(): BelongsTo {
			return $this->belongsTo(Review::class);
		}
	}
