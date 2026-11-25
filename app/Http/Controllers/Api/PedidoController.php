<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Listar únicamente los pedidos del usuario autenticado
    public function index(Request $request): JsonResponse
    {
        $pedidos = Pedido::where('user_id', $request->user()->id)
            ->get();

        return response()->json($pedidos);
    }

    // Consultar un pedido verificando que pertenezca al usuario
    public function show(Request $request, Pedido $pedido): JsonResponse
    {
        // Impedir el acceso a pedidos de otros usuarios
        if ($pedido->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para consultar este pedido.'
            ], 403);
        }

        return response()->json($pedido);
    }

    // Crear un pedido asociado al usuario autenticado
    public function store(Request $request): JsonResponse
    {
        // Validar únicamente los datos permitidos
        $datos = $request->validate([
            'descripcion' => ['required', 'string', 'max:150'],
            'total' => ['required', 'numeric', 'min:0'],
        ]);

        // Obtener el usuario directamente del token de Sanctum.
        // No confiar en un user_id enviado por el cliente.
        $datos['user_id'] = $request->user()->id;

        // Crear el pedido con el usuario autenticado
        $pedido = Pedido::create($datos);

        return response()->json($pedido, 201);
    }
}
