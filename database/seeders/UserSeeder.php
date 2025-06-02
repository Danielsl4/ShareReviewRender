<?php
	
	namespace Database\Seeders;
	
	use App\Models\User;
	use Illuminate\Database\Console\Seeds\WithoutModelEvents;
	use Illuminate\Database\Seeder;
	
	class UserSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 */
		public function run(): void {
			// Crear 50 usuarios normales
			$users = User::factory()->count(50)->create();
			
			// Simular relaciones de seguimiento entre usuarios
			foreach ($users as $user) {
				$toFollow = $users->where('id', '!=', $user->id)->random(rand(5, 15))->pluck('id');
				$user->following()->attach($toFollow);
			}
			
			// Crear un usuario de prueba
			User::factory()->create([
				'name' => 'Admin',
				'email' => 'admin@admin.com',
				'password' => bcrypt('sdfsdf'),
				'admin' => true,
				'biography' => 'Este es el usuario de administrador.',
			]);
			
			User::factory()->create([
				'name' => 'Prueba',
				'email' => 'sdf@sdf.com',
				'password' => bcrypt('sdfsdf'),
				'admin' => false,
				'biography' => 'Este es el usuario de de prueba.',
			]);
		}
	}
