<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PacienteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class PacienteController extends Controller
{
    public function select()
    {
        try {
            $medicos = Paciente::select(
                'pacientes.id',
                'pacientes.nombre',
                'pacientes.apellido',
                'pacientes.dui',
                'pacientes.fecha_nacimiento',
                
            )
                ->get();
            if ($medicos->count() > 0) {
                return response()->json([
                    'code' => 200,
                    'data' => $medicos

                ], 200);
            } else {
                return response()->json([
                    'code' => 200,
                    'data' => 'No hay pacientes'
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pacientes = Paciente::paginate();

        return view('paciente.index', compact('pacientes'))
            ->with('i', ($request->input('page', 1) - 1) * $pacientes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $paciente = new Paciente();

        return view('paciente.create', compact('paciente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'nombre' => 'required',
                'apellido' => 'required',
                'dui' => 'required|max:9',
                'fecha_nacimiento' => 'required'
            ]);
            if ($validacion->fails()) {
                // Si no se cumple la validación se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validación se inserta el cliente
                $cliente = Paciente::create($request->all());
                return response()->json([
                    'code' => 200,
                    'data' => 'Paciente insertado'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $paciente = Paciente::find($id);

        return view('paciente.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'nombre' => 'required',
                'apellido' => 'required',
                'dui' => 'required',
                'fecha_nacimiento' => 'required'
            ]);
            if ($validacion->fails()) {
                // Si no se cumple la validación se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validación se busca el cliente
                $cliente = Paciente::find($id);
                if ($cliente) {
                    // Si el cliente existe se actualiza
                    $cliente->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Paciente actualizado'
                    ], 200);
                } else {
                    // Si el cliente no existe se devuelve un mensaje
                    return response()->json([
                        'code' => 404,
                        'data' => 'Paciente no encontrado'
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
            $cliente = Paciente::find($id);
            if ($cliente) {
                // Si el cliente existe se elimina
                $cliente->delete($id);
                return response()->json([
                    'code' => 200,
                    'data' => 'Paciente eliminado'
                ], 200);
            } else {
                // Si el cliente no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Paciente no encontrado'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
    public function generateReport($id)
    {
        // Realizar la consulta con joins para obtener los datos del expediente del paciente
        $expediente = DB::table('pacientes as p')
            ->leftJoin('citas as c', 'p.id', '=', 'c.paciente_id')
            ->leftJoin('consultas as consulta', 'consulta.id_cita', '=', 'c.id')
            ->leftJoin('recetas as receta', 'receta.id_consulta', '=', 'consulta.id')
            ->leftJoin('examenes as examen', 'examen.id_consulta', '=', 'consulta.id')
            ->select(
                'p.nombre as nombre_paciente',
                'p.apellido as apellido_paciente',
                'p.dui as dui_paciente',
                'c.title as titulo_cita',
                'c.date as fecha_cita',
                'consulta.estado',
                'consulta.diagnostico as diagnostico_consulta',
                'receta.medicamento as medicamento',
                'examen.tipo as tipo_examen',
                'examen.resultado as resultado_examen'
            )
            ->where('p.id', '=', $id)
            ->orderBy('c.date', 'DESC')
            ->orderBy('consulta.created_at', 'DESC')
            ->get();

        // Generar el PDF usando la vista creada para el reporte
        $pdf = PDF::loadView('paciente.reporte', ['expediente' => $expediente]);

        // Descargar el PDF con un nombre específico
        return $pdf->download('expediente_paciente.pdf');
    }
}
