<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up(): void {
			Schema::create('activities', function (Blueprint $table) {
				$table->id();
				$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
				$table->foreignId('target_user_id')->nullable()->constrained('users')->onDelete('cascade');
				$table->enum('action_type',['publicó una reseña','valoró una reseña','siguió a','dejó de seguir']);
				$table->foreignId('content_id')->nullable()->constrained('contents')->onDelete('cascade');
				$table->foreignId('review_id')->nullable()->constrained('reviews')->onDelete('cascade');
				$table->timestamps();
			});
		}
		
		public function down(): void {
			Schema::dropIfExists('activities');
		}
	};
