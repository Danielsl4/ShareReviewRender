<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	
	class Problem extends Model {
		protected $fillable = [
			'user_id',
			'type',
			'report_id',
			'body',
		];
		
		public function user(): BelongsTo {
			return $this->belongsTo(User::class);
		}
	}

