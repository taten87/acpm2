<?php

namespace App\Http\Controllers;

use App\Models\ResultadoAprendizaje;
use Illuminate\Http\Request;

class ResultadoAprendizajeController extends Controller
{
    public function index()
    {
        $resultados = ResultadoAprendizaje::orderBy('idResultadoAprendizaje', 'desc')->paginate(10);
        return view('resultados.index', compact('resultados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
        ], [
            'nombre.required' => 'El nombre del resultado de aprendizaje es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 200 caracteres.',
        ]);

        ResultadoAprendizaje::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('resultados.index')->with('status', 'Resultado de aprendizaje guardado exitosamente.');
    }

    public function update(Request $request, ResultadoAprendizaje $resultado)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
        ], [
            'nombre.required' => 'El nombre del resultado de aprendizaje es obligatorio.',
        ]);

        $resultado->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('resultados.index')->with('status', 'Resultado de aprendizaje actualizado correctamente.');
    }

    public function destroy(ResultadoAprendizaje $resultado)
    {
        $resultado->delete();

        return redirect()->route('resultados.index')->with('status', 'Resultado de aprendizaje eliminado correctamente.');
    }
}
