<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	return new class extends Migration {
		public function up(): void {
			Schema::create('contents', function (Blueprint $table) {
				$table->id();
				$table->string('external_id')->unique()->nullable();
				$table->string('title');
				$table->enum('type',['movie', 'tv', 'game', 'book']);
				$table->string('author')->nullable();
				$table->text('description')->nullable();
				$table->string('cover')->nullable();
				$table->date('release_date')->nullable();
				$table->timestamps();
			});
		}
		
		public function down(): void {
			Schema::dropIfExists('contents');
		}
	};
