<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\ResultadoAprendizajeController;
use App\Http\Controllers\ProgramacionMensualController;
use App\Http\Controllers\ProgramacionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Exportar a Excel
Route::get('/programaciones/{id}/exportar', [ProgramacionController::class, 'exportarExcel'])->name('programaciones.exportar');
// Rutas mejoradas Usuarios / Programaciones / Ficha / Programa / Competencias / Resultados
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('programaciones', ProgramacionController::class)
        ->only(['index', 'store', 'show', 'destroy']);
    Route::prefix('programaciones')->name('programaciones.detalles.')->group(function () {
        Route::post('{programacion}/detalles', [ProgramacionController::class, 'storeDetalle'])->name('store');
        Route::put('detalles/{detalle}', [ProgramacionController::class, 'updateDetalle'])->name('update');
        Route::delete('detalles/{detalle}', [ProgramacionController::class, 'destroyDetalle'])->name('destroy');
    });
    Route::resource('programaciones-mensuales', ProgramacionMensualController::class)
        ->names('programaciones-mensuales')
        ->only(['index', 'store', 'update', 'destroy']);
});
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::resource('fichas', FichaController::class)->only(['index', 'store', 'update', 'destroy']);
});
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::resource('programas', ProgramaController::class)->only(['index', 'store', 'update', 'destroy']);
});
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::resource('competencias', CompetenciaController::class)->only(['index', 'store', 'update', 'destroy']);
});
Route::middleware(['auth', 'can.create.users'])->group(function () {
    Route::resource('resultados', ResultadoAprendizajeController::class)->only(['index', 'store', 'update', 'destroy']);
});
// Instructor
Route::middleware(['auth', 'role:Instructor'])->group(function () {
    Route::get('/instructor/panel', function () {
        return view('dashboard');
    });
});
// Administrativo
Route::middleware(['auth', 'role:Coordinador Administrativo'])->group(function () {
    Route::get('/administrativo/panel', function () {
        return view('dashboard');
    });
});
// Académico
Route::middleware(['auth', 'role:Coordinador Académico'])->group(function () {
    Route::get('/academico/panel', function () {
        return view('dashboard');
    });
});
// Perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
