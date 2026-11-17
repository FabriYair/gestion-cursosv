
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Curso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Detalle del Curso
        </h1>

        <!-- Mensaje de confirmación -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Datos del curso -->
        <div class="space-y-3 mb-8">
            <p>
                <strong>Nombre:</strong>
                {{ $curso->nombre }}
            </p>

            <p>
                <strong>Descripción:</strong>
                {{ $curso->descripcion ?? 'Sin descripción' }}
            </p>

            <p>
                <strong>Créditos:</strong>
                {{ $curso->creditos }}
            </p>

            <p>
                <strong>Docente:</strong>
                {{ $curso->docente?->nombre ?? 'Sin docente' }}
            </p>
        </div>

        <!-- Formulario de matrícula -->
        <div class="mb-8 bg-blue-50 p-5 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">
                Matricular Estudiante
            </h2>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cursos.matricular', $curso) }}"
                  method="POST">
                @csrf

                <div class="mb-4">
                    <label for="estudiante_id" class="block font-medium mb-2">
                        Seleccionar estudiante
                    </label>

                    <select name="estudiante_id"
                            id="estudiante_id"
                            required
                            class="w-full border p-2 rounded">
                        <option value="">Seleccione un estudiante</option>

                        @foreach($estudiantesDisponibles as $estudiante)
                            <option value="{{ $estudiante->id }}"
                                @selected(old('estudiante_id') == $estudiante->id)>
                                {{ $estudiante->nombre }} - {{ $estudiante->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nota" class="block font-medium mb-2">
                        Nota (opcional)
                    </label>

                    <input type="number"
                           name="nota"
                           id="nota"
                           value="{{ old('nota') }}"
                           min="0"
                           max="20"
                           step="0.01"
                           class="w-full border p-2 rounded">
                </div>

                <button type="submit"
                        @disabled($estudiantesDisponibles->isEmpty())
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded disabled:opacity-50">
                    Matricular Estudiante
                </button>

                @if($estudiantesDisponibles->isEmpty())
                    <p class="text-gray-600 text-sm mt-3">
                        No hay estudiantes disponibles para matricular.
                    </p>
                @endif
            </form>
        </div>

        <!-- Tabla de matriculados -->
        <h2 class="text-xl font-semibold mb-4">
            Estudiantes Matriculados
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border p-3 text-left">Estudiante</th>
                        <th class="border p-3 text-left">Correo</th>
                        <th class="border p-3 text-left">Nota</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($curso->estudiantes as $estudiante)
                        <tr>
                            <td class="border p-3">
                                {{ $estudiante->nombre }}
                            </td>

                            <td class="border p-3">
                                {{ $estudiante->email }}
                            </td>

                            <td class="border p-3">
                                {{ $estudiante->pivot->nota ?? 'Sin nota' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border p-4 text-center">
                                No hay estudiantes matriculados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 mt-6">
            <a href="{{ route('cursos.edit', $curso) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Editar Curso
            </a>

            <a href="{{ route('cursos.index') }}"
               class="bg-gray-200 px-4 py-2 rounded">
                Volver al Listado
            </a>
        </div>

    </div>

</body>
</html>
