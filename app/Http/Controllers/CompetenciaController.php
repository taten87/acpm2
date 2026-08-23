<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    public function index()
    {
        $competencias = Competencia::orderBy('idCompetencia', 'desc')->paginate(10);
        return view('competencias.index', compact('competencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'numHoras' => ['required', 'integer', 'min:1'],
        ], [
            'nombre.required' => 'El nombre de la competencia es obligatorio.',
            'nombre.max' => 'El nombre no debe superar los 200 caracteres.',
            'numHoras.required' => 'El número de horas es obligatorio.',
            'numHoras.integer' => 'El número de horas debe ser un valor entero.',
            'numHoras.min' => 'El número de horas debe ser mayor a 0.',
        ]);

        Competencia::create([
            'nombre' => $request->nombre,
            'numHoras' => $request->numHoras,
        ]);

        return redirect()->route('competencias.index')->with('status', 'Competencia registrada correctamente.');
    }

    public function update(Request $request, Competencia $competencia)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'numHoras' => ['required', 'integer', 'min:1'],
        ], [
            'nombre.required' => 'El nombre de la competencia es obligatorio.',
            'numHoras.required' => 'El número de horas es obligatorio.',
        ]);

        $competencia->update([
            'nombre' => $request->nombre,
            'numHoras' => $request->numHoras,
        ]);

        return redirect()->route('competencias.index')->with('status', 'Competencia actualizada correctamente.');
    }

    public function destroy(Competencia $competencia)
    {
        $competencia->delete();

        return redirect()->route('competencias.index')->with('status', 'Competencia eliminada correctamente.');
    }
}
