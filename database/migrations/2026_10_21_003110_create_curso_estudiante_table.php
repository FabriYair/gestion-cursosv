
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curso_estudiante', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla cursos
            $table->foreignId('curso_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relación con la tabla estudiantes
            $table->foreignId('estudiante_id')
                ->constrained()
                ->cascadeOnDelete();

            // Nota del estudiante
            $table->decimal('nota', 4, 2)->nullable();

            $table->timestamps();

            // Evitar matricular dos veces al mismo estudiante
            $table->unique(['curso_id', 'estudiante_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curso_estudiante');
    }
};
