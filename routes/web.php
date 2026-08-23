<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FichaController;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// -------- ACESOS PARA LOS ROLES --------

// Rutas protegidas solo para coordinadores, esto es para que solo los coordinadores 
// editar las fichas.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::get('/fichas', [FichaController::class, 'index'])->name('fichas.index');
    Route::post('/fichas', [FichaController::class, 'store'])->name('fichas.store');
    Route::put('/fichas/{ficha}', [FichaController::class, 'update'])->name('fichas.update');
    Route::delete('/fichas/{ficha}', [FichaController::class, 'destroy'])->name('fichas.destroy');
});

// Esto es para que solo los coordinadores puedan ver la lista de fichas y eliminar fichas.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::get('/fichas', [FichaController::class, 'index'])->name('fichas.index');
    Route::post('/fichas', [FichaController::class, 'store'])->name('fichas.store');
    Route::delete('/fichas/{ficha}', [FichaController::class, 'destroy'])->name('fichas.destroy');
});

// Esto es para que solo los coordinadores puedan ver la lista de fichas y registrar nuevas fichas.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::get('/fichas', [FichaController::class, 'index'])->name('fichas.index');
    Route::post('/fichas', [FichaController::class, 'store'])->name('fichas.store');
});

// Rutas protegidas solo para coordinadores, esto es para que solo los coordinadores puedan 
// ver la lista de usuarios. Y también para que solo los coordinadores puedan editar usuarios.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Rutas protegidas solo para coordinadores, esto es para que solo los coordinadores puedan ver la lista de usuarios.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
});

// Rutas protegidas solo para coordinadores, esto es para que solo los coordinadores puedan eliminar usuarios.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Rutas exclusivas para Instructores
Route::middleware(['auth', 'role:Instructor'])->group(function () {
    Route::get('/instructor/panel', function () {
        return view('dashboard');
    });
});

// Rutas exclusivas para Coordinadores Administrativos
Route::middleware(['auth', 'role:Coordinador Administrativo'])->group(function () {
    Route::get('/administrativo/panel', function () {
        return view('dashboard');
    });
});


// Rutas exclusivas para Coordinadores Académicos
Route::middleware(['auth', 'role:Coordinador Académico'])->group(function () {
    Route::get('/academico/panel', function () {
        return view('dashboard');
    });
});

// FIN -------- ACESOS PARA LOS ROLES --------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
