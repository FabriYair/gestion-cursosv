
<?php

use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\PedidoController;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// ==========================================
// LABORATORIO 12 - LOGIN CON LARAVEL SANCTUM
// ==========================================

Route::post('/login', function (Request $request) {

    $datos = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $usuario = User::where('email', $datos['email'])->first();

    // Registrar los intentos fallidos de inicio de sesión
    if (!$usuario || !Hash::check($datos['password'], $usuario->password)) {

        Log::warning('Login fallido', [
            'email' => $datos['email'],
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'message' => 'Credenciales incorrectas.'
        ], 401);
    }

    // Generar token de autenticación
    $token = $usuario->createToken('thunder-client')->plainTextToken;

    return response()->json([
        'message' => 'Inicio de sesión correcto.',
        'token' => $token,
        'token_type' => 'Bearer'
    ], 200);

})->middleware('throttle:5,1')->name('api.login');


// ==========================================
// CURSOS PÚBLICOS PARA VUE Y CAPACITOR
// ==========================================

Route::get('/cursos-publicos', function () {

    return Curso::query()
        ->select('id', 'docente_id', 'nombre', 'creditos')
        ->with('docente:id,nombre')
        ->orderBy('id', 'desc')
        ->get();

})->name('api.cursos.publicos');


// ==========================================
// API DE CURSOS PROTEGIDA CON SANCTUM
// ==========================================

Route::apiResource('cursos', CursoController::class)
    ->middleware('auth:sanctum')
    ->names('api.cursos');


// ==========================================
// PEDIDOS DEL LABORATORIO 12
// ==========================================

Route::middleware('auth:sanctum')->group(function () {

    // Mostrar únicamente los pedidos del usuario autenticado
    Route::get('/pedidos', [PedidoController::class, 'index'])
        ->name('api.pedidos.index');

    // Consultar un pedido verificando su propietario
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])
        ->name('api.pedidos.show');

    // Crear un pedido con validación de datos
    Route::post('/pedidos', [PedidoController::class, 'store'])
        ->name('api.pedidos.store');

    // ==========================================
    // LABORATORIO 12 - CIERRE DE SESIÓN SEGURO
    // ==========================================

    Route::post('/logout', function (Request $request) {

        // Revocar el token actual en Laravel Sanctum
        $request->user()->currentAccessToken()->delete();

        // Responder 204 No Content
        return response()->noContent();

    })->name('api.logout');

});
