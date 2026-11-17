<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba para iniciar sesión
        User::factory()->create([
            'name' => 'Docente Demo',
            'email' => 'demo@continental.edu.pe',
            'password' => bcrypt('password'),
        ]);

        // Crear 3 docentes
        $docentes = Docente::factory(3)->create();

        // Crear 6 cursos asociados a los docentes
        $cursos = Curso::factory(6)
            ->recycle($docentes)
            ->create();

        // Crear 20 estudiantes
        Estudiante::factory(20)->create()
            ->each(function (Estudiante $estudiante) use ($cursos) {

                // Matricular cada estudiante en 2 cursos
                foreach ($cursos->random(2) as $curso) {
                    $estudiante->cursos()->attach(
                        $curso->id,
                        ['nota' => fake()->numberBetween(8, 20)]
                    );
                }
            });
    }
}
