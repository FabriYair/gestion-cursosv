<?php

namespace Tests\Feature;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PedidoSeguridadTest extends TestCase
{
    use RefreshDatabase;

    // PRUEBA 1: Ana no puede consultar el pedido de Beto.
    public function test_no_puede_ver_el_pedido_de_otro_usuario(): void
    {
        $ana = User::factory()->create();
        $beto = User::factory()->create();

        $pedido = Pedido::create([
            'user_id' => $beto->id,
            'descripcion' => 'Pedido de Beto',
            'total' => 80,
        ]);

        Sanctum::actingAs($ana);

        // Nuestro controlador devuelve 403 cuando
        // el pedido pertenece a otro usuario.
        $this->getJson("/api/pedidos/{$pedido->id}")
            ->assertForbidden();
    }

    // PRUEBA 2: Un pedido sin total debe ser rechazado.
    public function test_rechaza_un_pedido_sin_total(): void
    {
        $ana = User::factory()->create();

        Sanctum::actingAs($ana);

        $this->postJson('/api/pedidos', [
            'descripcion' => 'sin total',
        ])->assertUnprocessable();
    }
}
