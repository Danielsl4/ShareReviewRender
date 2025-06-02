<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	
	class Review extends Model {
		protected $fillable = [
			'body',
			'rating',
			'user_id',
			'content_id',
		];
		
		public function user(): BelongsTo {
			return $this->belongsTo(User::class);
		}
		
		public function content(): BelongsTo {
			return $this->belongsTo(Content::class);
		}
		
		public function valorations(): HasMany {
			return $this->hasMany(Valoration::class);
		}
		
		// Cuenta las valoraciones
		public function totalValorations(): int {
			return $this->valorations()->count();
		}
		
		// Valoración valor final
		public function netValorations(): int {
			return $this->valorations()->sum('value');
		}
	}
