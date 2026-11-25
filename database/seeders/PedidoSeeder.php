<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios ficticios para las pruebas del laboratorio
        $ana = User::firstOrCreate(
            ['email' => 'ana.auditoria@example.test'],
            [
                'name' => 'Ana',
                'password' => Hash::make('AnaLab11-2026!'),
            ]
        );

        $beto = User::firstOrCreate(
            ['email' => 'beto.auditoria@example.test'],
            [
                'name' => 'Beto',
                'password' => Hash::make('BetoLab11-2026!'),
            ]
        );

        // Un pedido para cada usuario
        Pedido::firstOrCreate(
            [
                'user_id' => $ana->id,
                'descripcion' => 'Pedido de prueba de Ana',
            ],
            ['total' => 120.50]
        );

        Pedido::firstOrCreate(
            [
                'user_id' => $beto->id,
                'descripcion' => 'Pedido de prueba de Beto',
            ],
            ['total' => 85.00]
        );
    }
}
