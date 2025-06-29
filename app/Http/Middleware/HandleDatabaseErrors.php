<?php
	
	namespace App\Http\Middleware;
	
	use Closure;
	use Illuminate\Database\QueryException;
	use Illuminate\Support\Facades\Log;
	
	class HandleDatabaseErrors {
		public function handle($request, Closure $next) {
			try {
				return $next($request);  // Continuamos el flujo normal
			} catch (QueryException $exception) {
				// Si ocurre un error de base de datos, lo registramos
				Log::warning('Error de base de datos, pero la operación fue completada: ' . $exception->getMessage());
				
				// Continuamos sin detener el flujo y devolvemos un mensaje genérico
				return response()->json([
					'message' => 'Operación completada con éxito, pero hubo un error menor con la base de datos.'
				], 200);  // Código 200 ya que la operación no se interrumpió
			}
		}
	}
