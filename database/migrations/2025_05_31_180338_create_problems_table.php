<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up(): void {
			Schema::create('problems', function (Blueprint $table) {
				$table->id();
				$table->foreignId('user_id')->constrained()->onDelete('cascade');
				$table->enum('type',['usuario','reseña','otro']);
				$table->unsignedBigInteger('report_id')->nullable();
				$table->text('body');
				$table->timestamps();
			});
		}
		
		public function down(): void {
			Schema::dropIfExists('problems');
		}
	};
