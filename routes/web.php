<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';
