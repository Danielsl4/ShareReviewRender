<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	
	class Content extends Model {
		use HasFactory;
		
		protected $fillable = [
			'external_id',
			'title',
			'type',
			'author',
			'description',
			'cover',
			'release_date',
		];
		
		public function reviews(): HasMany {
			return $this->hasMany(Review::class);
		}
		
		protected function casts(): array {
			return [
				'release_date' => 'date',
			];
		}
	}
