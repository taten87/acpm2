<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules; // Preguntar por esto
use Illuminate\Validation\Rule; // Preguntar por esto - Este es el que se agregó
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validar los datos del formulario, incluyendo el rol
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', Rule::in(['Instructor', 'Coordinador Académico', 'Coordinador Administrativo'])],
        ]);

        // 2. Crear el usuario guardando el rol seleccionado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Guardar el rol seleccionado
        ]);

        event(new Registered($user));

        // Se comenta esta línea para evitar que el Coordinador pierda la sessión
        /* Auth::login($user); */

        // Redirigir al coordinador de vuelta con un mensaje de éxito
        return redirect()->back()->with('status', 'Usuario con rol ('.$user->role.') creado exitosamente.');

        // 3. Redirigir al panel correspondiente según el rol con el que se registró

        // TO DO ESTO SE COMENTA POR QUE NO SE QUIERE QUE EL COORDINADOR PIERDA LA SESIÓN AL CREAR UN USUARIO NUEVO
        
        /* return match ($user->role) {
            'Instructor' => redirect()->intended('/instructor/panel'),
            'Coordinador Académico' => redirect()->intended('/academico/panel'),
            'Coordinador Administrativo' => redirect()->intended('/administrativo/panel'),
            default => redirect()->intended('/dashboard'),
        }; */
    }
}
