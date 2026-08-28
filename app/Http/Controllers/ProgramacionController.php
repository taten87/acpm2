<?php
namespace App\Http\Controllers;
use App\Models\Programacion;
use App\Models\DetalleProgramacion;
use App\Models\Programa;
use App\Models\Competencia;
use App\Models\ResultadoAprendizaje;
use App\Models\Ficha;
use Illuminate\Http\Request;
use App\Exports\ProgramacionExport;
use Maatwebsite\Excel\Facades\Excel;
class ProgramacionController extends Controller
{
    public function exportarExcel($id)
    {
        return Excel::download(new ProgramacionExport($id), 'programacion_' . $id . '.xlsx');
    }
    public function index()
    {
        $user = auth()->user();
        $esCoordinador = in_array($user->role, ['Coordinador Académico', 'Coordinador Administrativo']);

        if ($esCoordinador) {
            $programaciones = Programacion::with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $programaciones = Programacion::where('idUsuario', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('programaciones.index', compact('programaciones'));
    }
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
        return redirect()->route('programaciones.show', $programacion->id)
            ->with('success', 'Programación procesada correctamente.');
    }
    public function show($id)
    {
        $programacion = Programacion::findOrFail($id);
        $user = auth()->user();
        $esCoordinador = in_array($user->role, ['Coordinador Académico', 'Coordinador Administrativo']);
        if (!$esCoordinador && (int) $programacion->idUsuario !== (int) $user->id) {
            abort(403, 'Acceso no autorizado a esta programación.');
        }
        $programacion->load([
            'detalles.programa',
            'detalles.competencia',
            'detalles.resultadoAprendizaje',
        ]);
        $fichas = Ficha::all();
        $programas = Programa::all();
        $competencias = Competencia::all();
        $resultados = ResultadoAprendizaje::all();
        return view('programaciones.show', compact(
            'programacion',
            'fichas',
            'programas',
            'competencias',
            'resultados'
        ));
    }
    public function storeDetalle(Request $request, Programacion $programacion)
    {
        $request->validate([
            'numFicha' => 'required',
            'codPrograma' => 'required',
            'idCompetencia' => 'required',
            'idResultadoAprendizaje' => 'required',
            'actividad_aprendizaje' => 'required|string|max:700',
            'horas' => 'required|numeric|min:1',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date',
        ]);
        $programacion->detalles()->create($request->all());
        return back()->with('success', 'Registro agregado a la programación.');
    }
    public function updateDetalle(Request $request, DetalleProgramacion $detalle)
    {
        $request->validate([
            'numFicha' => 'required',
            'codPrograma' => 'required',
            'idCompetencia' => 'required',
            'idResultadoAprendizaje' => 'required',
            'actividad_aprendizaje' => 'required|string|max:700',
            'horas' => 'required|numeric|min:1',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date',
        ]);
        $detalle->update($request->all());
        return back()->with('success', 'Registro actualizado correctamente.');
    }
    public function destroyDetalle(DetalleProgramacion $detalle)
    {
        $detalle->delete();
        return back()->with('success', 'Registro eliminado de la programación.');
    }
    public function destroy($id)
    {
        $programacion = Programacion::find($id);
        if (!$programacion) {
            return response()->json(['success' => false, 'message' => 'La programación no existe.'], 404);
        }
        $user = auth()->user();
        $esCoordinador = in_array($user->role, ['Coordinador Académico', 'Coordinador Administrativo']);
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