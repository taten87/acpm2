<?php
namespace App\Http\Controllers;
use App\Models\Programa;
use Illuminate\Http\Request;
class ProgramaController extends Controller
{
    public function index()
    {
        $programas = Programa::orderBy('codPrograma', 'desc')->paginate(10);
        return view('programas.index', compact('programas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'version' => ['required', 'string', 'max:10'],
        ], [
            'nombre.required' => 'El nombre del programa es obligatorio.',
            'version.required' => 'La versión del programa es obligatoria.',
        ]);
        Programa::create([
            'nombre' => $request->nombre,
            'version' => $request->version,
        ]);
        return redirect()->route('programas.index')->with('status', 'Programa guardado exitosamente.');
    }
    public function update(Request $request, Programa $programa)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'version' => ['required', 'string', 'max:10'],
            'confirm_nombre' => ['required', 'string'],
        ]);
        if (trim($request->confirm_nombre) !== trim($programa->nombre)) {
            return redirect()->back()->withErrors([
                'confirm_nombre' => 'El nombre ingresado para confirmar no coincide con el nombre actual del programa.'
            ]);
        }
        $programa->update([
            'nombre' => $request->nombre,
            'version' => $request->version,
        ]);
        return redirect()->route('programas.index')->with('status', 'Programa actualizado correctamente.');
    }
    public function destroy(Request $request, Programa $programa)
    {
        $request->validate([
            'confirm_nombre' => ['required', 'string'],
        ]);
        if (trim($request->confirm_nombre) !== trim($programa->nombre)) {
            return redirect()->back()->withErrors([
                'confirm_nombre' => 'El nombre ingresado para confirmar no coincide con el nombre del programa.'
            ]);
        }
        $programa->delete();
        return redirect()->route('programas.index')->with('status', 'Programa eliminado correctamente.');
    }
}