<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;




class RecetaController extends Controller
{
    /**
     * Obtener todas las recetas de una consulta específica
     */
    public function getByConsulta($consultaId): JsonResponse
    {
        try {
            $recetas = Receta::where('id_consulta', $consultaId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'message' => 'Recetas obtenidas exitosamente',
                'data' => $recetas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las recetas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Almacenar una nueva receta
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Registrar los datos recibidos
            Log::info('Datos de receta recibidos:', $request->all());

            // Validación
            $validated = $request->validate([
                'medicamento' => 'required|string|max:255',
                'dosis' => 'required|string',
                'id_consulta' => 'required|exists:consultas,id'
            ]);

            Log::info('Datos validados:', $validated);

            // Intentar crear la receta
            $receta = new Receta();
            $receta->medicamento = $validated['medicamento'];
            $receta->dosis = $validated['dosis'];
            $receta->id_consulta = $validated['id_consulta'];
            $receta->save();

            Log::info('Receta creada:', $receta->toArray());

            return response()->json([
                'message' => 'Receta creada exitosamente',
                'data' => $receta
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creando receta:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al crear la receta',
                'error' => $e->getMessage(),
                'details' => [
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }

    /**
     * Actualizar una receta existente
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $receta = Receta::findOrFail($id);

            $validated = $request->validate([
                'medicamento' => 'required|string|max:255',
                'dosis' => 'required|string',
                'id_consulta' => 'sometimes|exists:consultas,id'
            ]);

            $receta->update($validated);

            DB::commit();

            return response()->json([
                'message' => 'Receta actualizada exitosamente',
                'data' => $receta
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Receta no encontrada'
            ], 404);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar la receta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una receta
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $receta = Receta::findOrFail($id);
            $receta->delete();

            DB::commit();

            return response()->json([
                'message' => 'Receta eliminada exitosamente'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Receta no encontrada'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar la receta',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function generateReport($id)
    {
        try {
            // Obtener recetas, detalles del paciente y médico
            $recetas = DB::table('pacientes AS p')
                ->join('citas AS c', 'p.id', '=', 'c.paciente_id')
                ->join('consultas AS consulta', 'consulta.id_cita', '=', 'c.id')
                ->join('recetas AS receta', 'receta.id_consulta', '=', 'consulta.id')
                ->join('medicos AS medico', 'medico.id', '=', 'c.doctor_id')
                ->select(
                    'p.nombre AS nombre_paciente',
                    'p.apellido AS apellido_paciente',
                    'medico.nombre AS nombre_medico',
                    'medico.apellido AS apellido_medico',
                    'consulta.fecha AS fecha_consulta',
                    'receta.medicamento',
                    'receta.dosis'
                )
                ->where('p.id', $id)
                ->orderBy('consulta.fecha', 'DESC')
                ->get();

            if ($recetas->isEmpty()) {
                return response()->json(['message' => 'No se encontraron recetas para este paciente'], 404);
            }

            // Generar el PDF
            $pdf = PDF::loadView('recetas_por_paciente', compact('recetas'));

            // Configurar headers específicos para la descarga del PDF
            return $pdf->stream('recetas_paciente_' . $id . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="recetas_paciente_' . $id . '.pdf"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            Log::error('Error generando reporte de recetas:', [
                'patient_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
