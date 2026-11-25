
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // Usuario propietario del pedido
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Información del pedido
            $table->string('descripcion', 150);
            $table->decimal('total', 10, 2);

            // Fechas de creación y actualización
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
