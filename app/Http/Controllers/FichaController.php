<?php
namespace App\Http\Controllers;
use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class FichaController extends Controller
{
    public function index()
    {
        $fichas = Ficha::orderBy('numFicha', 'desc')->paginate(10);
        return view('fichas.index', compact('fichas'));
    }
    public function store(Request $request)
    {
        $request->validate(['numFicha' => ['required', 'numeric', 'integer', 'unique:ficha,numFicha', 'digits:7'],], [
            'numFicha.required' => 'El número de ficha es obligatorio.',
            'numFicha.numeric' => 'El número de ficha debe ser numérico.',
            'numFicha.unique' => 'Esta ficha ya se encuentra registrada en el sistema.',
            'numFicha.digits' => 'El número de ficha debe ser de exactamente de 7 (Siete) dígitos',
        ]);
        Ficha::create([
            'numFicha' => $request->numFicha,
        ]);
        return redirect()->route('fichas.index')->with('status', 'Ficha guardada exitosamente.');
    }
    public function update(Request $request, Ficha $ficha)
    {
        $request->validate(
            [
                'numFicha' => [
                    'required',
                    'numeric',
                    'integer',
                    Rule::unique('ficha', 'numFicha')->ignore($ficha->numFicha, 'numFicha'),
                    'digits:7'
                ],
                'current_numFicha_confirm' => ['required', 'numeric'],
            ],
            [
                'numFicha.required' => 'El número de ficha es obligatorio.',
                'numFicha.unique' => 'Este número de ficha ya se encuentra registrado.',
                'numFicha.digits' => 'El número de ficha debe ser de exactamente de 7 (Siete) dígitos',
            ]
        );
        if ((int) $request->current_numFicha_confirm !== (int) $ficha->numFicha) {
            return redirect()->back()->withErrors([
                'current_numFicha_confirm' => 'El número de confirmación no coincide con el número actual de la ficha.'
            ]);
        }
        $ficha->update(['numFicha' => $request->numFicha]);
        return redirect()->route('fichas.index')->with('status', 'Ficha actualizada correctamente.');
    }
    public function destroy(Request $request, Ficha $ficha)
    {
        $request->validate([
            'confirm_numFicha' => ['required', 'numeric'],
        ]);
        if ((int) $request->confirm_numFicha !== (int) $ficha->numFicha) {
            return redirect()->back()->withErrors([
                'confirm_numFicha' => 'El número ingresado no coincide con el número de ficha.'
            ]);
        }
        $ficha->delete();
        return redirect()->route('fichas.index')->with('status', 'Ficha eliminada correctamente.');
    }
}
