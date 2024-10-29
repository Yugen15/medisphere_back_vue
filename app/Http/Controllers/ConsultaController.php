<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ConsultaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class ConsultaController extends Controller
{

    public function select(Request $request)
    {
        try {
            $consultas = Consulta::select(
                'consultas.id AS consulta_id',
                'consultas.diagnostico',
                'consultas.fecha',
                'consultas.estado',
                'citas.title AS cita_title',
                'pacientes.nombre AS paciente_nombre',
                'pacientes.dui AS paciente_dui',
                'medicos.nombre AS doctor_nombre'
            )
                ->join('citas', 'citas.id', '=', 'consultas.id_cita')
                ->join('pacientes', 'pacientes.id', '=', 'citas.paciente_id')
                ->join('medicos', 'medicos.id', '=', 'citas.doctor_id')
                ->whereNull('consultas.deleted_at'); // Solo obtener consultas que no están eliminadas

            // Filtrar por estado de la consulta
            $estado = $request->query('estado');
            if ($estado) {
                $consultas->where('consultas.estado', $estado);
            }

            // Filtrar por fecha de la consulta
            $fecha = $request->query('fecha');
            if ($fecha) {
                $consultas->whereDate('consultas.fecha', $fecha);
            }

            $consultas = $consultas->get();

            return response()->json($consultas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las consultas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $consultas = Consulta::paginate();

        return view('consulta.index', compact('consultas'))
            ->with('i', ($request->input('page', 1) - 1) * $consultas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $consulta = new Consulta();

        return view('consulta.create', compact('consulta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultaRequest $request): RedirectResponse
    {
        Consulta::create($request->validated());

        return Redirect::route('consultas.index')
            ->with('success', 'Consulta created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $consulta = Consulta::find($id);

        return view('consulta.show', compact('consulta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $consulta = Consulta::find($id);

        return view('consulta.edit', compact('consulta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        $consulta = Consulta::findOrFail($id);
        $consulta->diagnostico = $request->input('diagnostico');
        $consulta->estado = $request->input('estado');
        $consulta->save();

        return response()->json([
            'message' => 'Consulta actualizada exitosamente',
            'consulta' => $consulta
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar la consulta',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($id): RedirectResponse
    {
        Consulta::find($id)->delete();

        return Redirect::route('consultas.index')
            ->with('success', 'Consulta deleted successfully');
    }
}
