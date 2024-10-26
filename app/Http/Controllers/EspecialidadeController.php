<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{

    //Endpoint
    public function select()
    {
        try {
            $especialidad = Especialidade::all();
            if ($especialidad->count() > 0) {
                return response()->json([
                    'code'=>200,
                    'data' => $especialidad
                ], 200);
            } else {
                return response()->json([
                    'code' => 404,
                    'data' => 'No hay especialidades'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }


    // Lista todas las especialidades
    public function index()
    {
        $especialidades = Especialidade::all();
        return response()->json($especialidades, 200);
    }

    // Muestra una especialidad en particular
    public function show($id)
    {
        $especialidade = Especialidade::find($id);

        if (!$especialidade) {
            return response()->json(['message' => 'Especialidad no encontrada'], 404);
        }

        return response()->json($especialidade, 200);
    }

    // Crea una nueva especialidad
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $especialidade = Especialidade::create($validated);

        return response()->json($especialidade, 201); // 201: Recurso creado
    }

    // Actualiza una especialidad existente
    public function update(Request $request, $id)
    {
        $especialidade = Especialidade::find($id);

        if (!$especialidade) {
            return response()->json(['message' => 'Especialidad no encontrada'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $especialidade->update($validated);

        return response()->json($especialidade, 200);
    }

    // Elimina una especialidad
    public function destroy($id)
    {
        $especialidade = Especialidade::find($id);

        if (!$especialidade) {
            return response()->json(['message' => 'Especialidad no encontrada'], 404);
        }

        $especialidade->delete();

        return response()->json(['message' => 'Especialidad eliminada con éxito'], 200);
    }
}
