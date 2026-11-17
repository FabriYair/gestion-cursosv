
<?php

use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::view('/', 'welcome')->name('home');

// Panel principal
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

// Rutas de configuración de usuario
require __DIR__.'/settings.php';

// Ruta para matricular estudiantes en un curso
Route::post('/cursos/{curso}/matricular', [CursoController::class, 'matricular'])
    ->middleware('auth')
    ->name('cursos.matricular');

// Rutas para listar, crear, ver, editar y eliminar cursos
Route::resource('cursos', CursoController::class)
    ->middleware('auth');

Route::get('/preview-correo', function () {

    $curso = \App\Models\Curso::with(['docente', 'estudiantes'])
        ->whereHas('estudiantes')
        ->firstOrFail();

    $estudiante = $curso->estudiantes->first();

    return new \App\Mail\MatriculaConfirmada(
        $curso,
        $estudiante
    );

})->middleware('auth')->name('preview.correo');
