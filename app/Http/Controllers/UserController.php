<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

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


    // ESTE MÉTODO ES PARA ACTUALIZAR LOS DATOS DE UN USUARIO, PERO ANTES DE ACTUALIZARLOS,
    // SE PIDE QUE EL COORDINADOR CONFIRME EL CORREO ACTUAL DEL USUARIO. SI EL CORREO NO COINCIDE, 
    // SE MUESTRA UN MENSAJE DE ERROR.
    public function update(Request $request, User $user)
    {
        // Validar los campos nuevos y el correo actual de confirmación
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['Instructor', 'Coordinador Académico', 'Coordinador Administrativo'])],
            'current_email_confirm' => ['required', 'email'],
        ]);

        // Verificar que el correo ingresado coincida con el correo ACTUAL del usuario en la BD
        if ($request->current_email_confirm !== $user->email) {
            return redirect()->back()->withErrors([
                'current_email_confirm' => 'El correo de confirmación no coincide con el correo actual del usuario.'
            ]);
        }

        // Actualizar los datos
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('status', 'Usuario actualizado correctamente.');
    }
}
