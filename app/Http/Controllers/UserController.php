<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->latest()
            ->paginate(10); 
        return view('users.index', compact('users'));
    }
    public function destroy(Request $request, User $user)
    {
        $request->validate([
            'confirm_email' => ['required', 'email'],
        ]);
        if ($request->confirm_email !== $user->email) {
            return redirect()->back()->withErrors([
                'confirm_email' => 'El correo ingresado no coincide con el del usuario.'
            ])->with('error_user_id', $user->id);
        }
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Usuario eliminado correctamente.');
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['Instructor', 'Coordinador Académico', 'Coordinador Administrativo'])],
            'current_email_confirm' => ['required', 'email'],
        ]);
        if ($request->current_email_confirm !== $user->email) {
            return redirect()->back()->withErrors([
                'current_email_confirm' => 'El correo de confirmación no coincide con el correo actual del usuario.'
            ]);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);
        return redirect()->route('users.index')->with('status', 'Usuario actualizado correctamente.');
    }
}
