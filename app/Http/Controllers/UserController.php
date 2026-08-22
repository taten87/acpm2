<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Este metodo lo que haces es obtener todos los usuarios de la base de datos 
    // y los pasa a la vista users.index para que se muestren en una tabla.
    public function index()
    {
        // Obtener todos los usuarios ordenados por id descendente
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->latest()
            ->paginate(10); // Pagina de 10 en 10

        return view('users.index', compact('users'));
    }


    // ESTE MÉTODO ES PARA ELIMINAR UN USUARIO, PERO ANTES DE ELIMINARLO, 
    // SE PIDE QUE EL COORDINADOR CONFIRME EL CORREO DEL USUARIO A ELIMINAR. 
    // SI EL CORREO NO COINCIDE, SE MUESTRA UN MENSAJE DE ERROR. 
    // TAMBIÉN SE EVITA QUE UN COORDINADOR SE ELIMINE A SÍ MISMO.
    public function destroy(Request $request, User $user)
    {
        // Validar que se haya enviado el correo de confirmación
        $request->validate([
            'confirm_email' => ['required', 'email'],
        ]);

        // Verificar que el correo coincida exactamente con el del usuario a eliminar
        if ($request->confirm_email !== $user->email) {
            return redirect()->back()->withErrors([
                'confirm_email' => 'El correo ingresado no coincide con el del usuario.'
            ])->with('error_user_id', $user->id);
        }

        // Evitar que un coordinador se elimine a sí mismo
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Usuario eliminado correctamente.');
    }
}
