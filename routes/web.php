<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ActividadProyectoController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\ResultadoAprendizajeController;
use App\Http\Controllers\ProgramacionMensualController;
use App\Http\Controllers\ProgramacionController;

/* Route::get('/', function () {
    return view('welcome');
}); */

// Ruta para exportar la programación a Excel
Route::get('/programaciones/{id}/exportar', [ProgramacionController::class, 'exportarExcel'])->name('programaciones.exportar');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas para usuarios autenticados, instructores también
// pueden acceder a estas rutas.
Route::middleware(['auth'])->group(function () {

    // --- RUTAS DE PROGRAMACIÓN MENSUAL ---

    // 1. Rutas principales para gestionar la cabecera de las programaciones (index, store, show, destroy)
    Route::resource('programaciones', ProgramacionController::class)->only([
        'index',
        'store',
        'show',
        'destroy'
    ]);

    // 2. Rutas para gestionar los bloques/detalles dentro de una programación especifica
    Route::post('programaciones/{programacion}/detalles', [ProgramacionController::class, 'storeDetalle'])
        ->name('programaciones.detalles.store');

    Route::put('programaciones/detalles/{detalle}', [ProgramacionController::class, 'updateDetalle'])
        ->name('programaciones.detalles.update');

    Route::delete('programaciones/detalles/{detalle}', [ProgramacionController::class, 'destroyDetalle'])
        ->name('programaciones.detalles.destroy');


    // Rutas para Programación Mensual (Permitido para todos los roles)
    Route::get('/programaciones-mensuales', [ProgramacionMensualController::class, 'index'])->name('programaciones.index');
    Route::post('/programaciones-mensuales', [ProgramacionMensualController::class, 'store'])->name('programaciones.store');
    Route::put('/programaciones-mensuales/{programacion}', [ProgramacionMensualController::class, 'update'])->name('programaciones.update');
    Route::delete('/programaciones-mensuales/{programacion}', [ProgramacionMensualController::class, 'destroy'])->name('programaciones.destroy');
});

// -------- ACESOS PARA LOS ROLES --------

// Rutas protegidas solo para coordinadores, 
// esto es para que solo los coordinadores puedan crear,
Route::middleware(['auth', 'can.create.users'])->group(function () {
    // Rutas anteriores...

    // Rutas para Resultado de Aprendizaje
    Route::get('/resultados-aprendizaje', [ResultadoAprendizajeController::class, 'index'])->name('resultados.index');
    Route::post('/resultados-aprendizaje', [ResultadoAprendizajeController::class, 'store'])->name('resultados.store');
    Route::put('/resultados-aprendizaje/{resultado}', [ResultadoAprendizajeController::class, 'update'])->name('resultados.update');
    Route::delete('/resultados-aprendizaje/{resultado}', [ResultadoAprendizajeController::class, 'destroy'])->name('resultados.destroy');
});

// Rutas protegidas solo para coordinadores, 
// esto es para que solo los coordinadores puedan crear,
// editar y eliminar competencias.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    // Rutas anteriores...

    // Rutas para Competencias
    Route::get('/competencias', [CompetenciaController::class, 'index'])->name('competencias.index');
    Route::post('/competencias', [CompetenciaController::class, 'store'])->name('competencias.store');
    Route::put('/competencias/{competencia}', [CompetenciaController::class, 'update'])->name('competencias.update');
    Route::delete('/competencias/{competencia}', [CompetenciaController::class, 'destroy'])->name('competencias.destroy');
});

// Rutas protegidas solo para coordinadores, 
// esto es para que solo los coordinadores puedan crear, 
// editar y eliminar actividades de proyecto.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    // Rutas anteriores...

    // Rutas para Actividades de Proyecto
    Route::get('/actividades-proyecto', [ActividadProyectoController::class, 'index'])->name('actividades.index');
    Route::post('/actividades-proyecto', [ActividadProyectoController::class, 'store'])->name('actividades.store');
    Route::put('/actividades-proyecto/{actividad}', [ActividadProyectoController::class, 'update'])->name('actividades.update');
    Route::delete('/actividades-proyecto/{actividad}', [ActividadProyectoController::class, 'destroy'])->name('actividades.destroy');
});

// Rutas protegidas solo para coordinadores, 
// esto es para que solo los coordinadores puedan crear, 
// editar y eliminar programas.
Route::middleware(['auth', 'can.create.users'])->group(function () {
    // Rutas para Fichas...

    // Rutas para Programas
    Route::get('/programas', [ProgramaController::class, 'index'])->name('programas.index');
    Route::post('/programas', [ProgramaController::class, 'store'])->name('programas.store');
    Route::put('/programas/{programa}', [ProgramaController::class, 'update'])->name('programas.update');
    Route::delete('/programas/{programa}', [ProgramaController::class, 'destroy'])->name('programas.destroy');
});

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
