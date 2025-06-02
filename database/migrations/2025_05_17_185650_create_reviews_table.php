<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up(): void {
			Schema::create('reviews', function (Blueprint $table) {
				$table->id();
				$table->text('body');
				$table->unsignedTinyInteger('rating');
				$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
				$table->foreignId('content_id')->constrained('contents')->onDelete('cascade');
				$table->timestamps();
			});
		}
		
		public function down(): void {
			Schema::dropIfExists('reviews');
		}
	};
