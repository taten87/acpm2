<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Este metodo lo que haces es obtener todos los usuarios de la base de datos y los pasa a la vista users.index para que se muestren en una tabla.
    public function index()
    {
        // Obtener todos los usuarios ordenados por id descendente
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->latest()
            ->paginate(10); // Pagina de 10 en 10

        return view('users.index', compact('users'));
    }
}
