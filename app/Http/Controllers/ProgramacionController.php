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
        $programaciones = Programacion::with('user')
            ->withSum('detalles as total_horas', 'horas')
            ->where('idUsuario', auth()->id())
            ->orderBy('mes_anio', 'desc')
            ->get();

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

        // Buscar o crear pasando AMBOS campos obligatorios
        $programacion = Programacion::firstOrCreate(
            [
                'idUsuario' => auth()->id(),
                'mes_anio' => $request->mes_anio,
            ]
        );

        return redirect()->route('programaciones.show', $programacion)
            ->with('success', 'Programación procesada correctamente.');
    }

    /**
     * Muestra la plantilla/ficha detallada de una programación en específico.
     */
    public function show(Programacion $programacion)
    {
        if ((int) $programacion->idUsuario !== (int) auth()->id()) {
            abort(403, 'Acceso no autorizado a esta programación.');
        }

        // Cargamos relaciones desde detalles
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
        // Buscamos manualmente la programación en la BD usando su ID
        $programacion = Programacion::find($id);

        if (!$programacion) {
            return response()->json([
                'success' => false,
                'message' => 'La programación no existe.'
            ], 404);
        }

        // Validación de seguridad limpia
        if ((int) $programacion->idUsuario !== (int) auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar esta programación.'
            ], 403);
        }

        try {
            // Borrar los detalles vinculados
            $programacion->detalles()->delete();

            // Borrar la cabecera
            $programacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Programación eliminada con éxito.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }
}