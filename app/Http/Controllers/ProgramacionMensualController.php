<?php

namespace App\Http\Controllers;

use App\Models\ProgramacionMensual;
use App\Models\User;
use App\Models\Ficha;
use App\Models\Programa;
use App\Models\Competencia;
use App\Models\ResultadoAprendizaje;
use App\Models\ActividadProyecto;
use Illuminate\Http\Request;

class ProgramacionMensualController extends Controller
{
    public function index()
    {
        $programaciones = ProgramacionMensual::with([
            'usuario',
            'ficha',
            'programa',
            'competencia',
            'resultadoAprendizaje',
            'actividadProyecto'
        ])->orderBy('idProgramacionMensual', 'desc')->paginate(10);

        // Listas desplegables para el formulario
        $usuarios = User::orderBy('name')->get();
        $fichas = Ficha::all();
        $programas = Programa::all();
        $competencias = Competencia::all();
        $resultados = ResultadoAprendizaje::all();
        $actividades = ActividadProyecto::all();

        return view('programaciones.index', compact(
            'programaciones',
            'usuarios',
            'fichas',
            'programas',
            'competencias',
            'resultados',
            'actividades'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idUsuario' => ['required', 'exists:users,id'],
            'numFicha' => ['required', 'exists:ficha,numFicha'],
            'codPrograma' => ['required', 'exists:programa,codPrograma'],
            'idCompetencia' => ['required', 'exists:competencia,idCompetencia'],
            'idResultadoAprendizaje' => ['required', 'exists:resultadoaprendizaje,idResultadoAprendizaje'],
            'idActividadProyecto' => ['required', 'exists:actividadproyecto,idActividadProyecto'],
            'horas' => ['required', 'integer', 'min:1'],
            'fechaInicio' => ['required', 'date'],
            'fechaFin' => ['required', 'date', 'after_or_equal:fechaInicio'],
        ]);

        ProgramacionMensual::create($request->all());

        return redirect()->route('programaciones.index')->with('status', 'Programación mensual registrada correctamente.');
    }

    public function update(Request $request, ProgramacionMensual $programacion)
    {
        $request->validate([
            'idUsuario' => ['required', 'exists:users,id'],
            'numFicha' => ['required', 'exists:ficha,numFicha'],
            'codPrograma' => ['required', 'exists:programa,codPrograma'],
            'idCompetencia' => ['required', 'exists:competencia,idCompetencia'],
            'idResultadoAprendizaje' => ['required', 'exists:resultadoaprendizaje,idResultadoAprendizaje'],
            'idActividadProyecto' => ['required', 'exists:actividadproyecto,idActividadProyecto'],
            'horas' => ['required', 'integer', 'min:1'],
            'fechaInicio' => ['required', 'date'],
            'fechaFin' => ['required', 'date', 'after_or_equal:fechaInicio'],
        ]);

        $programacion->update($request->all());

        return redirect()->route('programaciones.index')->with('status', 'Programación mensual actualizada correctamente.');
    }

    public function destroy(ProgramacionMensual $programacion)
    {
        $programacion->delete();

        return redirect()->route('programaciones.index')->with('status', 'Programación mensual eliminada correctamente.');
    }
}
