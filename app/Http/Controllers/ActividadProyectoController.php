<?php

namespace App\Http\Controllers;

use App\Models\ActividadProyecto;
use Illuminate\Http\Request;

class ActividadProyectoController extends Controller
{
    public function index()
    {
        $actividades = ActividadProyecto::orderBy('idActividadProyecto', 'desc')->paginate(10);
        return view('actividades.index', compact('actividades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => ['required', 'string', 'max:500'],
        ], [
            'descripcion.required' => 'La descripción de la actividad es obligatoria.',
            'descripcion.max' => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        ActividadProyecto::create([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('actividades.index')->with('status', 'Actividad de proyecto registrada correctamente.');
    }

    public function update(Request $request, ActividadProyecto $actividad)
    {
        $request->validate([
            'descripcion' => ['required', 'string', 'max:500'],
        ], [
            'descripcion.required' => 'La descripción de la actividad es obligatoria.',
            'descripcion.max' => 'La descripción no debe exceder los 500 caracteres.',
        ]);

        $actividad->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('actividades.index')->with('status', 'Actividad de proyecto actualizada correctamente.');
    }

    public function destroy(ActividadProyecto $actividad)
    {
        $actividad->delete();

        return redirect()->route('actividades.index')->with('status', 'Actividad de proyecto eliminada correctamente.');
    }
}
