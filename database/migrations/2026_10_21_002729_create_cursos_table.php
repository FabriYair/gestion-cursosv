
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla docentes
            $table->foreignId('docente_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->unsignedTinyInteger('creditos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
