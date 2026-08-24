<?php

namespace App\Http\Controllers;

use App\Models\Programacion;
use App\Models\DetalleProgramacion;
use App\Models\Programa;
use App\Models\Competencia;
use App\Models\ResultadoAprendizaje;
use App\Models\ActividadProyecto;
use App\Models\Ficha;
use Illuminate\Http\Request;

class ProgramacionController extends Controller
{
    /**
     * Muestra la lista general de todas las programaciones creadas por mes.
     */
    public function index()
    {
        $user = auth()->user();

        // Verificamos si el usuario tiene rol de coordinador
        // (Ajusta la condición si usas Spatie con $user->hasRole('Coordinador...') o similar)
        $esCoordinador = in_array($user->role, ['Coordinador Académico', 'Coordinador Administrativo']);

        if ($esCoordinador) {
            // El coordinador ve todas las programaciones junto con la información del usuario
            $programaciones = Programacion::with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // El instructor solo ve las suyas
            $programaciones = Programacion::where('idUsuario', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('programaciones.index', compact('programaciones'));
    }

    /**
     * Crea una nueva cabecera de programación mensual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mes_anio' => 'required|string',
        ]);

        $programacion = Programacion::firstOrCreate(
            [
                'idUsuario' => auth()->id(),
                'mes_anio' => $request->mes_anio,
            ]
        );

        // Pasamos el ID explícito para evitar problemas de binding
        return redirect()->route('programaciones.show', $programacion->id)
            ->with('success', 'Programación procesada correctamente.');
    }

    /**
     * Muestra la plantilla/ficha detallada de una programación en específico.
     */
    public function show($id)
    {
        $programacion = Programacion::findOrFail($id);
        $user = auth()->user();

        $esCoordinador = in_array($user->role, ['Coordinador Académico', 'Coordinador Administrativo']);

        // Si NO es coordinador Y tampoco es el dueño del registro, bloqueamos
        if (!$esCoordinador && (int) $programacion->idUsuario !== (int) $user->id) {
            abort(403, 'Acceso no autorizado a esta programación.');
        }

        $programacion->load([
            'detalles.programa',
            'detalles.competencia',
            'detalles.resultadoAprendizaje',
            'detalles.actividadProyecto'
        ]);

        $fichas = Ficha::all();
        $programas = Programa::all();
        $competencias = Competencia::all();
        $resultados = ResultadoAprendizaje::all();
        $actividades = ActividadProyecto::all();

        return view('programaciones.show', compact(
            'programacion',
            'fichas',
            'programas',
            'competencias',
            'resultados',
            'actividades'
        ));
    }

    /**
     * Agrega un nuevo bloque o actividad dentro de la programación seleccionada.
     */
    public function storeDetalle(Request $request, Programacion $programacion)
    {
        $request->validate([
            'numFicha' => 'required',
            'codPrograma' => 'required',
            'idCompetencia' => 'required',
            'idResultadoAprendizaje' => 'required',
            'idActividadProyecto' => 'required',
            'horas' => 'required|numeric|min:1',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date',
        ]);

        $programacion->detalles()->create($request->all());

        return back()->with('success', 'Registro agregado a la programación.');
    }

    /**
     * Actualiza un bloque/detalle específico.
     */
    public function updateDetalle(Request $request, DetalleProgramacion $detalle)
    {
        $request->validate([
            'numFicha' => 'required',
            'codPrograma' => 'required',
            'idCompetencia' => 'required',
            'idResultadoAprendizaje' => 'required',
            'idActividadProyecto' => 'required',
            'horas' => 'required|numeric|min:1',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date',
        ]);

        $detalle->update($request->all());

        return back()->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Elimina un bloque/detalle específico.
     */
    public function destroyDetalle(DetalleProgramacion $detalle)
    {
        $detalle->delete();

        return back()->with('success', 'Registro eliminado de la programación.');
    }

    /**
     * Elimina la programación mensual completa.
     */
    /**
     * Elimina la programación mensual completa y sus detalles vinculados.
     */

    public function destroy($id)
    {
        $programacion = Programacion::find($id);

        if (!$programacion) {
            return response()->json(['success' => false, 'message' => 'La programación no existe.'], 404);
        }

        $user = auth()->user();
        $esCoordinador = in_array($user->role, ['Coordinador Académico', 'Coordinador Administrativo']);

        // Permite eliminar si es el dueño O si es coordinador
        if (!$esCoordinador && (int) $programacion->idUsuario !== (int) $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar esta programación.'
            ], 403);
        }

        try {
            $programacion->detalles()->delete();
            $programacion->delete();

            return response()->json(['success' => true, 'message' => 'Programación eliminada con éxito.'], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar en la BD.'], 500);
        }
    }
}