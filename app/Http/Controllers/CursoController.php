<?php

namespace App\Http\Controllers;
use App\Mail\MatriculaConfirmada;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreCursoRequest;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CursoController extends Controller
{
    // Listar cursos con sus docentes y cantidad de matriculados
    public function index()
    {
        $cursos = Curso::with('docente')
            ->withCount('estudiantes')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('cursos.index', compact('cursos'));
    }

    // Mostrar formulario para crear curso
    public function create()
    {
        $docentes = Docente::orderBy('nombre')->get();

        return view('cursos.create', compact('docentes'));
    }

    // Guardar curso usando Form Request
    public function store(StoreCursoRequest $request)
    {
        $datos = $request->validated();

        Curso::create($datos);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso registrado correctamente.');
    }

    // Mostrar curso, matriculados y estudiantes disponibles
    public function show(Curso $curso)
    {
        $curso->load(['docente', 'estudiantes']);

        $estudiantesDisponibles = Estudiante::whereDoesntHave(
            'cursos',
            function ($consulta) use ($curso) {
                $consulta->where('cursos.id', $curso->id);
            }
        )
        ->orderBy('nombre')
        ->get();

        return view('cursos.show', compact(
            'curso',
            'estudiantesDisponibles'
        ));
    }

    // Formulario para editar curso
    public function edit(Curso $curso)
    {
        $docentes = Docente::orderBy('nombre')->get();

        return view('cursos.edit', compact('curso', 'docentes'));
    }

    // Actualizar curso
    public function update(Request $request, Curso $curso)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'creditos' => 'required|integer|min:1|max:10',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        $curso->update($datos);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    // Eliminar curso
    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }

    // Matricular un estudiante en un curso
    public function matricular(Request $request, Curso $curso)
    {
        $datos = $request->validate([
            'estudiante_id' => [
                'required',
                'integer',
                'exists:estudiantes,id',
                Rule::unique('curso_estudiante', 'estudiante_id')
                    ->where('curso_id', $curso->id),
            ],
            'nota' => [
                'nullable',
                'numeric',
                'between:0,20',
            ],
        ], [
            'estudiante_id.required' =>
                'Debes seleccionar un estudiante.',

            'estudiante_id.exists' =>
                'El estudiante seleccionado no existe.',

            'estudiante_id.unique' =>
                'Este estudiante ya está matriculado en este curso.',

            'nota.numeric' =>
                'La nota debe ser numérica.',

            'nota.between' =>
                'La nota debe estar entre 0 y 20.',
        ]);

        // Guardar matrícula y nota en la tabla pivote
        
$curso->estudiantes()->attach(
    $datos['estudiante_id'],
    ['nota' => $datos['nota'] ?? null]
);

// Obtener el estudiante recién matriculado
$estudiante = Estudiante::findOrFail($datos['estudiante_id']);

// Cargar el docente para incluirlo en el correo
$curso->load('docente');

// Colocar el correo de confirmación en la cola
Mail::to($estudiante->email)->queue(
    new MatriculaConfirmada($curso, $estudiante)
);

return redirect()
    ->route('cursos.show', $curso)
    ->with('success', 'Estudiante matriculado');
    }
}
