<?php

use App\Http\Controllers\Api\CursoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\Curso;

// Iniciar sesión y obtener un token de Sanctum
Route::post('/login', function (Request $request) {

    $datos = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $usuario = User::where('email', $datos['email'])->first();

    if (!$usuario || !Hash::check($datos['password'], $usuario->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas.'
        ], 401);
    }

    $token = $usuario->createToken('thunder-client')->plainTextToken;

    return response()->json([
        'message' => 'Inicio de sesión correcto.',
        'token' => $token,
        'token_type' => 'Bearer'
    ], 200);

})->middleware('throttle:5,1')->name('api.login');

// Obtener el usuario autenticado
Route::get('/cursos-publicos', function () {
    return Curso::query()
        ->select('id', 'docente_id', 'nombre', 'creditos')
        ->with('docente:id,nombre')
        ->orderBy('id', 'desc')
        ->get();
})->name('api.cursos.publicos');

// API de cursos protegida mediante Sanctum
Route::apiResource('cursos', CursoController::class)
    ->middleware('auth:sanctum')
    ->names('api.cursos');
