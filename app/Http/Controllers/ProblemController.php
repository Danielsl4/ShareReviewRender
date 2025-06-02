<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Problem;
	use App\Models\Review;
	use App\Models\User;
	use Illuminate\Http\Request;
	
	class ProblemController extends Controller {
		public function create(Request $request) {
			return view('problem.create', [
				'type' => $request->input('type'),
				'report_id' => $request->input('report_id')
			]);
		}
		
		
		public function store(Request $request) {
			$request->validate([
				'type' => 'required|in:usuario,reseña,otro',
				'report_id' => $request->type == 'otro' ? 'nullable' : 'required|integer',
				'body' => 'required|string|max:1000'
			], ['report_id.required' => 'El campo ID relacionado es obligatorio si el tipo es "Usuario" o "Reseña".',
				'report_id.integer' => 'El ID debe ser un número válido.',
				'body.required' => 'Debes escribir una descripción del problema.',
				'body.min' => 'La descripción es de máximo 1000 caracteres.',
			]);
			
			if ($request->type == 'usuario' && !User::find($request->report_id)) {
				return back()->withErrors(['report_id' => 'No existe ningún usuario con ese ID.'])->withInput();
			}
			
			if ($request->type == 'reseña' && !Review::find($request->report_id)) {
				return back()->withErrors(['report_id' => 'No existe ninguna reseña con ese ID.'])->withInput();
			}
			
			Problem::create([
				'user_id' => auth()->id(),
				'type' => $request->type,
				'report_id' => $request->report_id,
				'body' => $request->body,
			]);
			
			return redirect()->route('home')->with('success', 'Problema reportado correctamente.');
		}
		
		public function adminIndex() {
			if (!auth()->user()->admin) {
				abort(403); // o redirigir con mensaje si prefieres
			}
			
			$problems = Problem::with('user')->latest()->paginate(10);
			
			return view('problem.admin', ['problems' => $problems]);
		}
		
	}
