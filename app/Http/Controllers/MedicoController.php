<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicoController extends Controller
{
    public function select()
    {
        try {
            $medicos = Medico::select(
                'medicos.id',
                'medicos.nombre',
                'medicos.apellido',
                'especialidades.name as id_especialidad'
            )
                ->join('especialidades', 'medicos.id_especialidad', '=', 'especialidades.id')
                ->get();
            if ($medicos->count() > 0) {
                return response()->json([
                    'code' => 200,
                    'data' => $medicos

                ], 200);
            } else {
                return response()->json([
                    'code' => 200,
                    'data' => 'No hay especialidades'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'nombre' => 'required',
                'apellido' => 'required',
                'id_especialidad' => 'required'
            ]);
            if ($validacion->fails()) {
                // Si no se cumple la validación se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validación se inserta el cliente
                $cliente = Medico::create($request->all());
                return response()->json([
                    'code' => 200,
                    'data' => 'Medico insertado'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'nombre' => 'required',
                'apellido' => 'required',
                'id_especialidad' => 'required'
            ]);
            if ($validacion->fails()) {
                // Si no se cumple la validación se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validación se busca el cliente
                $cliente = Medico::find($id);
                if ($cliente) {
                    // Si el cliente existe se actualiza
                    $cliente->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Médico actualizado'
                    ], 200);
                } else {
                    // Si el cliente no existe se devuelve un mensaje
                    return response()->json([
                        'code' => 404,
                        'data' => 'Médico no encontrado'
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    public function delete($id)
    {
        try {
            // Se busca el cliente
            $cliente = Medico::find($id);
            if ($cliente) {
                // Si el cliente existe se elimina
                $cliente->delete($id);
                return response()->json([
                    'code' => 200,
                    'data' => 'Médico eliminado'
                ], 200);
            } else {
                // Si el cliente no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Médico no encontrado'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    public function find($id)
    {
        try {
            // Se busca el cliente
            $cliente = Medico::find($id);
            if ($cliente) {
                // Si el cliente existe se retornan sus datos
                $datos = Medico::select(
                    'medicos.id',
                    'medicos.nombre',
                    'medicos.apellido',
                    'medicos.id_especialidad',
                    'especialidades.name as especialidad'
                )
                    ->join('especialidades', 'especialidades.id', '=', 'medicos.id_especialidad')
                    ->where('medicos.id', '=', $id)
                    ->get();
                return response()->json([
                    'code' => 200,
                    'data' => $datos[0]
                ], 200);
            } else {
                // Si el cliente no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Médico no encontrado'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
