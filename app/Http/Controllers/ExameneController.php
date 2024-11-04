<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExameneController extends Controller
{
    public function index($consultaId)
    {
        try {
            $examenes = Examen::where('id_consulta', $consultaId)->get();
            return response()->json(['data' => $examenes], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los exámenes'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo' => 'required|string|max:255',
                'resultado' => 'nullable|string',
                'id_consulta' => 'required|exists:consultas,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $examen = Examen::create($request->all());
            return response()->json(['data' => $examen, 'message' => 'Examen creado exitosamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el examen'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo' => 'required|string|max:255',
                'resultado' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $examen = Examen::findOrFail($id);
            $examen->update($request->all());

            return response()->json(['data' => $examen, 'message' => 'Examen actualizado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el examen'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $examen = Examen::findOrFail($id);
            $examen->delete();
            return response()->json(['message' => 'Examen eliminado exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el examen'], 500);
        }
    }
}
