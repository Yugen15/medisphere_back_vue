<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function select()
    {
        try {
            $citas = Cita::with(['paciente', 'doctor', 'consulta'])
                ->whereHas('consulta', function ($query) {
                    $query->where('estado', 'Completada');
                })
                ->get()
                ->map(function ($cita) {
                    return [
                        'id' => $cita->id,
                        'paciente' => [
                            'nombre' => $cita->paciente->nombre . ' ' . $cita->paciente->apellido,
                            'dui' => $cita->paciente->dui
                        ],
                        'doctor' => [
                            'nombre' => $cita->doctor->nombre . ' ' . $cita->doctor->apellido,
                            'especialidad' => $cita->doctor->especialidad
                        ],
                        'fecha' => $cita->date,
                        'estado' => $cita->estado
                    ];
                });

            if ($citas->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'message' => 'No hay citas disponibles'
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'data' => $citas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Error al cargar las citas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $citas = Cita::with(['medico', 'paciente'])->get();
            return response()->json($citas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener citas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:medicos,id',
                'paciente_id' => 'required|exists:pacientes,id',
                'title' => 'required|string',
                'date' => 'required|date',
                'estado' => 'required|string',
            ]);

            $cita = Cita::create($validatedData);

            // Puedes agregar la creación de una consulta aquí si es necesario
            // $consulta = Consulta::create([...]);

            $consulta = Consulta::create([
                'id_cita' => $cita->id,
                'fecha' => $cita->date,
                'estado' => $cita->estado,
                'diagnostico' => null, // Este se puede establecer más tarde
                // No establecemos 'deleted_at' ya que se maneja automáticamente
            ]);

            return response()->json([
                'code' => 201,
                'message' => 'Cita y consulta creadas exitosamente',
                'data' => [
                    'cita' => $cita,
                    'consulta' => $consulta
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Error al crear la cita y la consulta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cita = Cita::with(['medico', 'paciente'])->find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json([
            'code' => 200,
            'data' => $cita
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:medicos,id',
                'paciente_id' => 'required|exists:pacientes,id',
                'title' => 'required|string',
                'date' => 'required|date',
                'estado' => 'required|string',
            ]);

            $cita = Cita::find($id);

            if (!$cita) {
                return response()->json(['message' => 'Cita no encontrada'], 404);
            }

            $cita->update($validatedData);

            return response()->json([
                'code' => 200,
                'message' => 'Cita actualizada exitosamente',
                'data' => $cita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Error al actualizar la cita',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['message' => 'Cita eliminada exitosamente'], 204);
    }


    public function find($id)
    {
        try {
            // Se busca la cita
            $cita = Cita::find($id);
            if ($cita) {
                // Si la cita existe se retornan sus datos
                $datos = Cita::select(
                    'citas.id',
                    'citas.title',
                    'citas.date',
                    'citas.estado',
                    'pacientes.nombre as paciente_nombre',
                    'pacientes.apellido as paciente_apellido',
                    'medicos.nombre as doctor_nombre',
                    'medicos.apellido as doctor_apellido'
                )
                    ->join('pacientes', 'pacientes.id', '=', 'citas.paciente_id')
                    ->join('medicos', 'medicos.id', '=', 'citas.doctor_id')
                    ->where('citas.id', '=', $id)
                    ->get();

                return response()->json([
                    'code' => 200,
                    'data' => $datos[0]
                ], 200);
            } else {
                // Si la cita no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Cita no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
