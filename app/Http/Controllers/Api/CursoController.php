<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    // GET /api/cursos
    // Listar todos los cursos
    public function index()
    {
        $cursos = Curso::with('docente')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($cursos, 200);
    }

    // POST /api/cursos
    // Registrar un curso
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'creditos' => 'required|integer|min:1|max:10',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        $curso = Curso::create($datos);

        return response()->json([
            'mensaje' => 'Curso creado correctamente',
            'curso' => $curso,
        ], 201);
    }

    // GET /api/cursos/{curso}
    // Mostrar los detalles del curso
    public function show(Curso $curso)
    {
        $curso->load('docente', 'estudiantes');

        return response()->json($curso, 200);
    }

    // PUT /api/cursos/{curso}
    // Actualizar un curso
    public function update(Request $request, Curso $curso)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'creditos' => 'required|integer|min:1|max:10',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        $curso->update($datos);

        return response()->json([
            'mensaje' => 'Curso actualizado correctamente',
            'curso' => $curso->fresh(),
        ], 200);
    }

    // DELETE /api/cursos/{curso}
    // Eliminar un curso
    public function destroy(Curso $curso)
    {
        $curso->delete();

        return response()->json([
            'mensaje' => 'Curso eliminado correctamente',
        ], 200);
    }
}
