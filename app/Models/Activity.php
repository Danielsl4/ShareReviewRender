<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	
	class Activity extends Model {
		
		protected $fillable = [
			'user_id',
			'target_user_id',
			'action_type',
			'content_id',
			'review_id',
			'created_at',
			'updated_at',
		];
		
		public function user(): BelongsTo {
			return $this->belongsTo(User::class);
		}
		
		public function targetUser(): BelongsTo {
			return $this->belongsTo(User::class, 'target_user_id');
		}
		
		public function content(): BelongsTo {
			return $this->belongsTo(Content::class);
		}
		
		public function review(): BelongsTo {
			return $this->belongsTo(Review::class);
		}
	}
