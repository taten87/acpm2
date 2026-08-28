<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FichaController extends Controller
{
    // Muestra la vista con el formulario y la lista de fichas registradas
    public function index()
    {
        // Aca se coloca que se orden por numFicha para que no saque error
        $fichas = Ficha::orderBy('numFicha', 'desc')->paginate(10);
        return view('fichas.index', compact('fichas'));
    }


    // Procesa el guardado de una nueva ficha
    public function store(Request $request) // Request y $request: esto es un objeto de laravel el cual permite capturar los datos que vienen de formularios 
    {
        // Mensajes personalizados en español
        $request->validate(['numFicha' => ['required', 'numeric', 'integer', 'unique:ficha,numFicha'],], [
            'numFicha.required' => 'El número de ficha es obligatorio.',
            'numFicha.numeric' => 'El número de ficha debe ser numérico.',
            'numFicha.unique' => 'Esta ficha ya se encuentra registrada en el sistema.',
        ]);

        // Esto es lo que permite guardar en la base de datos
        Ficha::create([
            'numFicha' => $request->numFicha,
        ]);

        // Redirige de nuevo a la vista del listado de las fichas
        return redirect()->route('fichas.index')->with('status', 'Ficha guardada exitosamente.');
    }

    // Este método se encarga de eliminar una ficha, pero antes de eliminarla, 
    // solicita al usuario que confirme el número de ficha que desea eliminar. 
    // Esto es para evitar eliminaciones accidentales.
    public function destroy(Request $request, Ficha $ficha)
    {
        // Validar que se haya enviado el número de ficha para la confirmación
        $request->validate([
            'confirm_numFicha' => ['required', 'numeric'],
        ]);

        // Verificar que el número ingresado coincida exactamente con la ficha
        if ((int) $request->confirm_numFicha !== (int) $ficha->numFicha) {
            return redirect()->back()->withErrors([
                'confirm_numFicha' => 'El número ingresado no coincide con el número de ficha.'
            ]);
        }

        $ficha->delete();

        return redirect()->route('fichas.index')->with('status', 'Ficha eliminada correctamente.');
    }


    // Este método es para que se puedan editar las fichas 
    public function update(Request $request, Ficha $ficha)
    {
        // Validar el nuevo número de ficha y la confirmación
        $request->validate([
            'numFicha' => [
                'required',
                'numeric',
                'integer',
                Rule::unique('ficha', 'numFicha')->ignore($ficha->numFicha, 'numFicha')
            ],
            'current_numFicha_confirm' => ['required', 'numeric'],
        ], [
            'numFicha.required' => 'El número de ficha es obligatorio.',
            'numFicha.unique' => 'Este número de ficha ya se encuentra registrado.',
        ]);

        // Verificar que el número de confirmación sea igual al número ACTUAL de la ficha
        if ((int) $request->current_numFicha_confirm !== (int) $ficha->numFicha) {
            return redirect()->back()->withErrors([
                'current_numFicha_confirm' => 'El número de confirmación no coincide con el número actual de la ficha.'
            ]);
        }

        // Actualizar el número de la ficha
        $ficha->update([
            'numFicha' => $request->numFicha,
        ]);

        return redirect()->route('fichas.index')->with('status', 'Ficha actualizada correctamente.');
    }
}
