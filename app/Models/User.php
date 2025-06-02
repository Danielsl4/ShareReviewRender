<?php
	
	namespace App\Models;
	
	// use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Database\Factories\UserFactory;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	
	class User extends Authenticatable {
		/** @use HasFactory<UserFactory> */
		use HasFactory, Notifiable;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var list<string>
		 */
		protected $fillable = [
			'name',
			'email',
			'password',
			'biography',
			'profile_photo',
			'admin',
		];
		
		/**
		 * The attributes that should be hidden for serialization.
		 *
		 * @var list<string>
		 */
		protected $hidden = [
			'password',
			'remember_token',
		];
		
		/**
		 * Get the attributes that should be cast.
		 *
		 * @return array<string, string>
		 */
		protected function casts(): array {
			return [
				'email_verified_at' => 'datetime',
				'password' => 'hashed',
			];
		}
		
		public function reviews(): HasMany {
			return $this->hasMany(Review::class);
		}
		
		public function follows() {
			return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')
				->withTimestamps();
		}
		
		public function followers() {
			return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
		}
		
		public function following() {
			return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
		}
		
		public function isFollowing(User $user) {
			return $this->following()->where('followed_id', $user->id)->exists();
		}
		
		public function valoratedReviews() {
			return $this->belongsToMany(Review::class, 'valorations')
				->withPivot('value')
				->withTimestamps();
		}
		
		public function valorationFor(Review $review): ?int {
			return $this->valoratedReviews()
				->where('review_id', $review->id)
				->first()?->pivot->value;
		}
		
		
	}
